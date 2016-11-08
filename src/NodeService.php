<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;
class NodeService implements IProtocolObject, IEnum {
	const Unknown = 0;
	const Dvsp = 1;
	const Http = 2;
	
	private $_service;
	
	public function __construct($service) {
		$this->_service = $service;
	}
	
	public function get() {
		return $this->_service;
	}
	
	public static function fromStr($str) {
		switch ($str) {
			case "dvsp": return new NodeService(NodeService::Dvsp);
			case "http": return new NodeService(NodeService::Http);
			default:     return new NodeService(NodeService::Unknown);
		}
	}
	
	public function toStr() {
		switch ($this->_service) {
			case NodeService::Dvsp: return "dvsp";    break;
			case NodeService::Http: return "http";    break;
			default:                return "unknown"; break;
		}
	}
}