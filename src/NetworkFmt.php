<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */

namespace SpringDvs;

class NetworkFmt implements IProtocolObject {

	private $_nodes;

	public function __construct($nodes) {
		$this->_nodes = $nodes;
	}
	
	public function nodes() {
		return $this->_nodes;
	}
	
	public static function fromStr($str) {
		$parts = explode(";", $str);
		$nodes = array();
		foreach($parts as $p) {
			array_push($nodes, NodeQuadFmt::fromStr($p));
		}
		
		return new NetworkFmt($nodes);
	}
	
	public function toStr() {
		$nodes = array();
		
		foreach($this->_nodes as $n) {
			array_push($nodes, $n->toStr());
		}
			
		return implode(";", $nodes);
	}
}