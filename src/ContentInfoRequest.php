<?php
namespace SpringDvs;

class ContentInfoRequest implements IProtocolObject {
	const Node = 0;
	const Network = 1;
	
	private $_type;
	private $_content;
	
	public function __construct($type, $content) {
		$this->_type = $type;
		$this->_content = $content;
	}
	
	public function type() {
		return $this->_type;
	}
	
	public function get() {
		if($this->_type == ContentInfoRequest::Network) return null;
		
		return $this->_content->get();
	}
	
	public function value() {
		if($this->_type == ContentInfoRequest::Network) return null;
		return $this->_content->value();
	}
	
	public static function fromStr($str) {
		$parts = explode(" ", $str, 2);
		$t = null;
		$c = null;
		switch($parts[0]) {

			case "node":
				$t = ContentInfoRequest::Node;
				$r = count($parts) == 2 ? $parts[1] : "";
				$c = NodeProperty::fromStr($r);
				break;
				
			case "network":
				$t = ContentInfoRequest::Network;
				break;

			default: throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
		
		return new ContentInfoRequest($t, $c);
	}
	
	public function toStr() {
		switch($this->_type) {
			case ContentInfoRequest::Node:
				return 'node '.$this->_content->toStr();
			case ContentInfoRequest::Network:
				return 'network';
		}
	}
}