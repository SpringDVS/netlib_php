<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ContentUpdate implements IProtocolObject {
	private $_property;
	private $_spring;
	public function __construct(NodeProperty $property, $spring) {
		$this->_property = $property;
		$this->_spring = $spring;
	}
	
	public function type() {
		return $this->_property->get();
	}
	
	public function value() {
		return $this->_property->value();
	}
	
	public function spring() {
		return $this->_spring;
	}
	
	public static function fromStr($str) {
		$parts = explode(" ", $str, 2);
		
		if(!isset($parts[1])) {
			throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}

		$np = NodeProperty::fromStr($parts[1]);
		
		if($np->value() == null) {
			throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
		return new ContentUpdate($np, $parts[0]);
	}
	
	public function toStr() {
		return $this->_spring . ' ' . $this->_property->toStr();
	}
}