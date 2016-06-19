<?php

namespace SpringDvs;

class Message implements IProtocolObject {
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
	
}