<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
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