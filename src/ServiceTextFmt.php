<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ServiceTextFmt implements IProtocolObject, IJson {
	private $_content;
	
	public function __construct($content) {
		$this->_content = $content;
	}
	
	public function get() {
		return $this->_content;
	}
		
	public static function fromStr($str) {
		return new ServiceTextFmt($str);
	}
	
	public function toStr() {
		return $this->_content;
	}
	
	public function toJsonArray() {
		return $this->_content;
	}
}