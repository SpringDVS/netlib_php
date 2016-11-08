<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ContentNodeSingle implements IProtocolObject {
	private $_single;
	
	public function __construct(NodeSingleFmt $single) {
		$this->_single = $single;
	}
	
	public function spring() {
		return $this->_single->spring();
	}
		
	public static function fromStr($str) {
		return new ContentNodeSingle(NodeSingleFmt::fromStr($str));
	}
	
	public function toStr() {
		return $this->_single->toStr();
	}
}