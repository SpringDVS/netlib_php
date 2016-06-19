<?php

namespace SpringDvs;

class NodeQuadFmt implements IProtocolObject {
	private $_spring;
	private $_host;
	private $_address;
	private $_service;

	public function __construct($spring,$host,$address,$service) {
		$this->_spring = $spring;
		$this->_host = $host;
		$this->_address = $address;
		$this->_service = $service;
	}

	public function spring() {

		return $this->_spring;
	}

	public function host() {
		return $this->_host;
	}

	public function address() {
		return $this->_address;
	}
	
	public function service() {
		return $this->_service->get();
	}

	public static function fromStr($str) {
		$parts = explode(",", $str);

		if( count($parts) != 4) { throw new ParseFailure(ParseFailure::InvalidContentFormat); }

		return new NodeQuadFmt($parts[0],$parts[1],$parts[2],NodeService::fromStr($parts[3]));
	}

	public function toStr() {
		return "{$this->_spring},{$this->_host},{$this->_address},{$this->_service->toStr()}";
	}
}