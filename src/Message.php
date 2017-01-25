<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */

namespace SpringDvs;

class Message implements IProtocolObject, IJson {
	private $_cmd;
	private $_content;
	
	public function __construct(CmdType $cmd, $content) {
		$this->_cmd = $cmd;
		$this->_content = $content;
	}
	
	public function cmd() {
		return $this->_cmd->get();
	}
	
	public function content() {
		return $this->_content;
	}
	
	public static function fromStr($str) {
		$parts = explode(" ", $str, 2);
		
		if(is_numeric($parts[0])) {
			return new Message(new CmdType(CmdType::Response), ContentResponse::fromStr($str));
		}
		$cmd = CmdType::fromStr($parts[0]);
		$content = null;
		if(!isset($parts[1])) {
			return new Message($cmd, $content);
		}
		
		switch($cmd->get()) {
			case CmdType::Register:
				$content = ContentRegistration::fromStr($parts[1]);
				break;
			case CmdType::Unregister:
					$content = ContentNodeSingle::fromStr($parts[1]);
					break;
			case CmdType::Info:
				$content = ContentInfoRequest::fromStr($parts[1]);
				break;
			case CmdType::Update:
				$content = ContentUpdate::fromStr($parts[1]);
				break;
			case CmdType::Resolve:
				$content = ContentResolve::fromStr($parts[1]);
				break;				
			case CmdType::Service:
				$content = ContentService::fromStr($parts[1]);
				break;
			case CmdType::Response:
				$content = ContentResponse::fromStr($str);
				break;
		}
		
		return new Message($cmd, $content);
	}
	
	public function toStr() {
		$cmd = "";
		$ops = "";
		switch($this->_cmd->get()) {
			case CmdType::Register:
				$cmd = "register";
				$ops = $this->_content == null ? "" : $this->_content->toStr();
				break;
			case CmdType::Unregister:
				$cmd = "unregister";
				$ops = $this->_content == null ? "" : $this->_content->toStr();
				break;
			case CmdType::Info:
				$cmd = "info";
				$ops = $this->_content == null ? "" : $this->_content->toStr();
				break;
			case CmdType::Update:
				$cmd = "update";
				$ops = $this->_content == null ? "" : $this->_content->toStr();
				break;
			case CmdType::Resolve:
				$cmd = "resolve";
				$ops = $this->_content == null ? "" : $this->_content->toStr();
				break;
			case CmdType::Service:
				$cmd = "service";
				$ops = $this->_content == null ? "" : $this->_content->toStr();
				break;
			case CmdType::Response:
				$ops = "";
				$cmd = $this->_content == null ? "" : $this->_content->toStr();
				break;
		}
		
		return strlen($ops) > 0 ? "{$cmd} {$ops}" : $cmd;
	}
	
	public function toJsonArray() {
		if($this->_cmd->get() != CmdType::Response) return array('code' => '201');
		
		return $this->_content->toJsonArray();
	}
	
	/**
	 * Get the content hinted as a ContentResponse object. If not response
	 * then it returns null
	 * 
	 * @return \SpringDvs\ContentResponse
	 */
	public function getContentResponse() {
		if($this->_cmd->get() != CmdType::Response) {
			throw new \Exception("Bad content type");
		}
		
		return $this->_content;
	}
	/**
	 * Get the content hinted as a ContentResponse object. If not response
	 * then it returns null
	 *
	 * @return \SpringDvs\ContentService
	 */
	public function getContentService() {
		if($this->_cmd->get() != CmdType::Service) {
			throw new \Exception("Bad content type");
		}
	
		return $this->_content;
	}
	
}