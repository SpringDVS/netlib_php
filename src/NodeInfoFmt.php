<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class NodeInfoFmt implements IProtocolObject {
	private $_spring;
	private $_host;
	private $_address;
	private $_service;
	private $_role;
	private $_state;

	public function __construct($spring,$host,$address,$service,$role,$state) {
		$this->_spring = $spring;
		$this->_host = $host;
		$this->_address = $address;
		$this->_service = $service;
		$this->_role = $role;
		$this->_state = $state;
	}

	public function spring() {

		return $this->_spring;
	}

	public function host() {
		return $this->_host;
	}

	public function address() {
		return $this->_address;
	}
	
	public function service() {
		return $this->_service->get();
	}

	public function state() {
		return $this->_state->get();
	}

	public function role() {
		return $this->_role->get();
	}
	public static function fromStr($str) {

		$spring = ""; $host = ""; $address = "";
		$service = NodeService::fromStr("unknown");
		$role = NodeRole::fromStr("unknown");
		$state = NodeState::fromStr("unspecified");

		$parts = explode(",", $str);

		foreach($parts as $kv) {
			$v = explode(":", $kv);
			if(count($v) != 2) { continue; }
			$val = array(trim($v[0]),trim($v[1]));

			switch($val[0]) {
				case "spring":  $spring  = $val[1]; break;
				case "host":    $host    = $val[1]; break;
				case "address": $address = $val[1]; break;

				case "service": $service = NodeService::fromStr($val[1]); break;
				case "role":    $role    = NodeRole::fromStr($val[1]);    break;
				case "state":   $state   = NodeState::fromStr($val[1]);   break;

				default: continue;
			}
		}

		return new NodeInfoFmt($spring,$host,$address,
								$service,$role,$state);
	}

	public function toStr() {
		$l = array();
		if(isset($this->_spring[0])) { array_push($l, "spring:{$this->_spring}"); }
		if(isset($this->_host[0])) { array_push($l, "host:{$this->_host}"); }
		if(isset($this->_address[0])) { array_push($l, "address:{$this->_address}"); }
		
		if($this->_service->get() != NodeService::Unknown) {
			array_push($l, "service:{$this->_service->toStr()}"); 
		}

		if($this->_role->get() != NodeRole::Unknown) { 
			array_push($l, "role:{$this->_role->toStr()}"); 
		}

		if($this->_state->get() != NodeState::Unspecified) { 
			array_push($l, "state:{$this->_state->toStr()}"); 
		}
		
		return implode(",", $l);
		
	}
}