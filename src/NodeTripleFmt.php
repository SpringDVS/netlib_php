<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class NodeTripleFmt implements IProtocolObject {
	private $_spring;
	private $_host;
	private $_address;

	public function __construct($spring,$host,$address) {
		$this->_spring = $spring;
		$this->_host = $host;
		$this->_address = $address;
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

	public static function fromStr($str) {
		$parts = explode(",", $str);

		if( count($parts) != 3) { throw new ParseFailure(ParseFailure::InvalidContentFormat); }

		return new NodeTripleFmt($parts[0],$parts[1],$parts[2]);
	}

	public function toStr() {
		echo "{$this->_spring},{$this->_host},{$this->_address}";
	}
}