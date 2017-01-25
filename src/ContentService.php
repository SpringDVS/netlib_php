<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ContentService implements IProtocolObject {
	private $_uri;
	private $_attributes;

	public function __construct(Uri $uri, $attributes = array()) {
		$this->_uri = $uri;
		$this->_attributes = $attributes;
	}

	public function uri() {
		return $this->_uri;
	}

	public static function fromStr($str) {
		$parts = explode(' ', $str, 2);
		$uri = $parts[0];
		$attributes = array();
		if(isset($parts[1])) {
			foreach(explode(';', $parts[1]) as $pair) {
				$kv = explode(':', $pair);
				if(!isset($kv[1])){ continue; }
				$attributes[trim($kv[0])] = trim($kv[1]);
			}
			
		}
		return new ContentService(new Uri($uri), $attributes);
	}

	public function toStr() {
		return $this->_uri->toStr();
	}
	
	public function attribute($key) {
		return isset($this->_attributes[$key])
					? $this->_attributes[$key]
					: null;
	}
	
	public function attributes() {
		return $this->_attributes;
	}
}