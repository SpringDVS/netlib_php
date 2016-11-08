<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ContentResponse implements IProtocolObject, IJson {
	const EmptyContent = 0;
	const NodeInfo = 1;
	const Network = 2;
	const ServiceText = 3;
	const ServiceMulti = 4;

	private $_code;
	private $_type;
	private $_content;
	private $_length;
	private $_meta;
	
	public function __construct(ProtocolResponse $code, $type = ContentResponse::EmptyContent, $length = 0, $meta = 0, $content = null) {
		$this->_code = $code;
		$this->_type = $type;
		$this->_content = $content;
		$this->_length = $length;
		$this->_meta = $meta;
	}
	
	public function code() {
		return $this->_code->get();
	}
	
	public function type() {
		return $this->_type;
	}
	
	public function content() {
		return $this->_content;
	}
	
	/**
	 * Get the length of the content
	 * @return number
	 */
	public function length() {
		return $this->_length;
	}
	
	/**
	 * Get the offset for the end of this message in a stream
	 * 
	 * This gives the number of bytes this message takes up in a stream
	 * so you can quickly jump to the end of it
	 * 
	 * @return number
	 */
	public function offset() {
		return $this->_length + $this->_meta;
	}
	
	/**
	 * 
	 * @param string $str
	 * @throws \SpringDvs\ParseFailure if malformed
	 * @return \SpringDvs\ContentResponse
	 */
	public static function fromStr($str) {
		$parts = explode(" ", $str, 4);
		
		$code = ProtocolResponse::fromStr($parts[0]);
		$type = ContentResponse::EmptyContent;
		$content = null;
		$meta = 4; // +4 bytes for Response code
		
		if(count($parts) == 1) {
			return new ContentResponse($code);
		} else if(!isset($parts[1]) || !isset($parts[2]) || !isset($parts[3])) {
			throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}

		$meta += strlen($parts[1])+1; // Add size of length field to meta
		$size = intval($parts[1], 10);
		switch($parts[2]) {
			case "node":
				$type = ContentResponse::NodeInfo;
				$meta += 5;
				$size -= 5;
				
				$content = NodeInfoFmt::fromStr(substr($parts[3], 0, $size));
				break;
			case "network":
				$type = ContentResponse::Network;
				$meta += 8;
				$size -= 8;
				$sub = substr($parts[3], 0, $size);
				$content = NetworkFmt::fromStr(substr($parts[3], 0, $size));
				break;
			case "service/text":
				$type = ContentResponse::ServiceText;
				$meta += 13;
				$size -= 13;
				$content = ServiceTextFmt::fromStr(substr($parts[3], 0, $size));
				break;
			case "service/multi":
				$type = ContentResponse::ServiceMulti;
				$meta += 14; // +1 for space between header and rest
				$size = 0;
				break;
		}
		
		return new ContentResponse($code, $type, $size, $meta, $content);
	}
	
	public function toStr() {
		if($this->_type == ContentResponse::EmptyContent) {
			return $this->_code->toStr();
		}
		if($this->_content != null) {
			$content = $this->_content->toStr();
		} else {
			$content = "";
		}
		$len = strlen($content);

		switch($this->_type) {
			case ContentResponse::NodeInfo:
				return $this->_code->toStr(). ' ' . ($len+5) . ' node ' .$content;
			case ContentResponse::Network:
				return $this->_code->toStr(). ' ' . ($len+8) . ' network ' .$content;
			case ContentResponse::ServiceText:
				return $this->_code->toStr(). ' ' . ($len+13) . ' service/text ' .$content;
			case ContentResponse::ServiceMulti:
				return $this->_code->toStr(). ' 14 service/multi';
			
		}
	}

	public function toJsonArray() {
		$type = "";
		
		switch($this->_type) {
			case ContentResponse::NodeInfo: $type = 'node';    break;
			case ContentResponse::Network:  $type = 'network'; break;
			case ContentResponse::ServiceText:  $type = 'service/text'; break;
			case ContentResponse::ServiceMulti:  $type = 'service/multi'; break;
			default: break;
		}
		
		return array(
			'code' => $this->_code->toStr(),
			'type' => $type,
			'content' => $this->_type == ContentResponse::EmptyContent ? 
							'' : $this->_content->toJsonArray() 
		);
	}
	
	/**
	 * Get the content hinted as a NodeInfoFmt. If it is not NodeInfo
	 * it returns a null
	 *
	 * @throws \Exception if not \SpringDvs\NodeInfoFmt
	 * 
	 * @return \SpringDvs\NodeInfoFmt
	 */
	public function getNodeInfo() {
		if($this->_type != ContentResponse::NodeInfo) {
			throw new \Exception("Bad content type");
		}
		
		return $this->_content;
	}
	
	/**
	 * Get the content hinted as a NetworkFmt. If it is not NetworkFmt
	 * it returns a null
	 *
	 * @throws \Exception if not \SpringDvs\NetworkFmt
	 * @return \SpringDvs\NetworkFmt
	 */
	public function getNetwork() {
		if($this->_type != ContentResponse::Network) {
			throw new \Exception("Bad content type");
		}
	
		return $this->_content;
	}
	
	/**
	 * Get the content hinted as a ServiceTextFmt. If it is not ServiceTextFmt
	 * it returns a null
	 *
	 * @throws \Exception if not \SpringDvs\ServiceTextFmt
	 * @return \SpringDvs\ServiceTextFmt
	 */
	public function getServiceText() {
		if($this->_type != ContentResponse::ServiceText) {
			throw new \Exception("Bad content type");
		}
	
		return $this->_content;
	}
	
	/**
	 * Get an array of Messages that have been sent in a service/multi stream
	 * 
	 * Pass in from the beginning of the stream with specified offset. Offset
	 * defaults to 18 which is the usual length of the header
	 * 
	 * @param string $stream
	 * @return array \SpringDvs\Message[]
	 */
	public static function parseServiceMulti($stream, $offset=18) {
		$isEot = false;
		$messages = array();
		try {
			while(!$isEot) {
				$stream = substr($stream, $offset);

				$msg = Message::fromStr($stream);
				if($msg->cmd() != CmdType::Response) continue;
				if($msg->getContentResponse()->code() == ProtocolResponse::Eot) break;
				
				$offset = $msg->getContentResponse()->offset() + 1; // +1 for visual delimiter (space) 
				$messages[] = $msg;
			}
			return $messages;
		} catch(\Exception $e) {
			throw $e;
		}
	}
}
