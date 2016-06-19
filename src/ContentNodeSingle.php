<?php

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