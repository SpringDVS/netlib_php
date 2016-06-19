<?php
namespace SpringDvs;

class NodeDoubleFmt implements IProtocolObject {
	private $_spring;
	private $_host;

	public function __construct($spring,$host) {
		$this->_spring = $spring;
		$this->_host = $host;
	}

	public function spring() {
		
		return $this->_spring;
	}
	
	public function host() {
		return $this->_host;
	}

	public static function fromStr($str) {
		$parts = explode(",", $str);

		if( count($parts) != 2) { throw new ParseFailure(ParseFailure::InvalidContentFormat); }
		
		return new NodeDoubleFmt($parts[0],$parts[1]);
	}

	public function toStr() {
		return "{$this->_spring},{$this->_host}";
	}
}