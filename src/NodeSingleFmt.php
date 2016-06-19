<?php
namespace SpringDvs;

class NodeSingleFmt implements IProtocolObject {
	
	private $_spring;
	
	public function __construct($spring) {
		$this->_spring = $spring;
	}
	
	public function spring() {
		return $this->_spring;
	}
	
	public static function fromStr($str) {
		return new NodeSingleFmt($str);
	}
	
	public function toStr() {
		return $this->_spring;
	}
}