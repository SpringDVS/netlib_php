<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ContentResolve implements IProtocolObject {
	private $_uri;
	
	public function __construct(Uri $uri) {
		$this->_uri = $uri;
	}
	
	public function uri() {
		return $this->_uri;
	}
	
	public static function fromStr($str) {
		return new ContentResolve(new Uri($str));
	}
	
	public function toStr() {
		return $this->_uri->toStr();
	}
	
}