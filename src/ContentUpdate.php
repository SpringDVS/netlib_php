<?php

namespace SpringDvs;

class ContentUpdate implements IProtocolObject {
	private $_property;
	
	public function __construct(NodeProperty $property) {
		$this->_property = $property;
	}
	
	public function type() {
		return $this->_property->get();
	}
	
	public function value() {
		return $this->_property->value();
	}
	
	
	public static function fromStr($str) {
		$np = NodeProperty::fromStr($str);
		
		if($np->value() == null) {
			throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
		return new ContentUpdate($np);
	}
	
	public function toStr() {
		return $this->_property->toStr();
	}
}