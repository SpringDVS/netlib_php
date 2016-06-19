<?php
namespace SpringDvs;

class ContentInfoRequest implements IProtocolObject {
	const Node = 0;
	const Network = 1;
	
	private $_spring;
	private $_type;
	private $_content;
	
	public function __construct($type, $content, $spring) {
		$this->_type = $type;
		$this->_content = $content;
		$this->_spring = $spring;
	}
	
	public function type() {
		return $this->_type;
	}
	
	public function get() {
		if($this->_type == ContentInfoRequest::Network) return null;
		
		return $this->_content->get();
	}
	
	public function spring() {
		return $this->_spring;
	}
	
	public function value() {
		if($this->_type == ContentInfoRequest::Network) return null;
		return $this->_content->value();
	}
	
	public static function fromStr($str) {
		$parts = explode(" ", $str, 3);
	

		$t = null;
		$c = null;
		$s = null;
		switch($parts[0]) {
			case "node":
				if(!isset($parts[1])) {
					throw new ParseFailure(ParseFailure::InvalidContentFormat);
				}
				$t = ContentInfoRequest::Node;
				$s = $parts[1];
				$r = count($parts) == 3 ? $parts[2] : "";
				$c = NodeProperty::fromStr($r);
				break;
				
			case "network":
				$t = ContentInfoRequest::Network;
				break;

			default: throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
		
		return new ContentInfoRequest($t, $c, $s);
	}
	
	public function toStr() {
		switch($this->_type) {
			case ContentInfoRequest::Node:
				return 'node '.$this->_spring.' '.$this->_content->toStr();
			case ContentInfoRequest::Network:
				return 'network';
		}
	}
}