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

	private $_code;
	private $_type;
	private $_content;
	
	public function __construct(ProtocolResponse $code, $type = ContentResponse::EmptyContent, $content = null) {
		$this->_code = $code;
		$this->_type = $type;
		$this->_content = $content;
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
	
	public static function fromStr($str) {
		$parts = explode(" ", $str, 4);
		
		$code = ProtocolResponse::fromStr($parts[0]);
		$type = ContentResponse::EmptyContent;
		$content = null;
		
		if(count($parts) == 1) {
			return new ContentResponse($code);
		} else if(!isset($parts[1]) || !isset($parts[2]) || !isset($parts[3])) {
			throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
		$size = intval($parts[1], 10);
		switch($parts[2]) {
			case "node":
				$type = ContentResponse::NodeInfo;
				$content = NodeInfoFmt::fromStr($parts[3]);
				break;
			case "network":
				$type = ContentResponse::Network;
				$content = NetworkFmt::fromStr($parts[3]);
				break;
			case "service/text":
				$type = ContentResponse::ServiceText;
				$content = ServiceTextFmt::fromStr($parts[3]);
				break;
		}
		
		return new ContentResponse($code, $type, $content);
	}
	
	public function toStr() {
		if($this->_type == ContentResponse::EmptyContent) {
			return $this->_code->toStr();
		}
		$content = $this->_content->toStr();
		$len = strlen($content);

		switch($this->_type) {
			case ContentResponse::NodeInfo:
				return $this->_code->toStr(). ' ' . ($len+5) . ' node ' .$content;
			case ContentResponse::Network:
				return $this->_code->toStr(). ' ' . ($len+8) . ' network ' .$content;
			case ContentResponse::ServiceText:
				return $this->_code->toStr(). ' ' . ($len+13) . ' service/text ' .$content;
			
		}
	}

	public function toJsonArray() {
		$type = "";
		
		switch($this->_type) {
			case ContentResponse::NodeInfo: $type = 'node';    break;
			case ContentResponse::Network:  $type = 'network'; break;
			case ContentResponse::ServiceText:  $type = 'service/text'; break;
			default: break;
		}
		
		return array(
			'code' => $this->_code->toStr(),
			'type' => $type,
			'content' => $this->_type == ContentResponse::EmptyContent ? 
							'' : $this->_content->toJsonArray() 
		);
	}
}
