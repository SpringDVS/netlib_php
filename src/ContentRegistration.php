<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class ContentRegistration implements IProtocolObject {
	
	private $_nodeDouble;
	private $_role;
	private $_service;
	private $_token;
	
	public function __construct(NodeDoubleFmt $nodeDouble, NodeRole $role, NodeService $service, $token) {
		$this->_nodeDouble = $nodeDouble;
		$this->_role       = $role;
		$this->_service    = $service;
		$this->_token      = $token;
	}
	
	public function double() {
		return $this->_nodeDouble;
	}
	
	public function role() {
		return $this->_role->get();
	}
	
	public function service() {
		return $this->_service->get();
	}
	
	public static function fromStr($str) {
		$parts = explode(";", $str);
		if(count($parts) != 4) throw new ParseFailure(ParseFailure::InvalidContentFormat);
		
		return new ContentRegistration(
					NodeDoubleFmt::fromStr($parts[0]),
					NodeRole::fromStr($parts[1]),
					NodeService::fromStr($parts[2]),
					$parts[3]
				);
	}
	
	public function toStr() {
		return $this->_nodeDouble->toStr().';'.
		       $this->_role->toStr().';'.
		       $this->_service->toStr().';'.
		       $this->_token;
	}
}