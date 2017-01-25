<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class NodeInfoFmt implements IProtocolObject, IJson, INodeNetInterface {
	private $_spring;
	private $_host;
	private $_hostpath;
	private $_address;
	private $_service;
	private $_role;
	private $_state;

	public function __construct($spring,$host,$address,$service,$role,$state) {
		$this->_spring = $spring;
		
		$field = explode('/',$host, 2);
		$this->_host = $field[0];
		if(isset($field[1])) {
			$this->_hostpath = $field[1];
		}

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
	
	/**
	 * Get the host field of the node
	 *
	 * The host field consists of hostname and hostpath
	 * concatinated with forward slash
	 *
	 * @return string The hostfield
	 */
	public function hostField() {
		return $this->_host . ($this->_hostpath == ''
				? ''
				: $this->_hostpath);
	}

	/**
	 * Get the hostpath of the node (if any)
	 * @return string The host path
	 */
	public function hostPath() {
		return $this->_hostpath;
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
	
	public function toJsonArray() {
		$l = array();

		if(isset($this->_spring[0])) {
			$l['spring'] = $this->_spring; 
		}
		
		if(isset($this->_host[0])) { 
			$l['host'] = $this->_host;
		}
		
		if(isset($this->_address[0])) {
			$l['address'] = $this->_address;
		}
		
		if($this->_service->get() != NodeService::Unknown) {
			$l['service'] = $this->_service->toStr();
		}
		
		if($this->_role->get() != NodeRole::Unknown) {
			$l['role'] = $this->_role->toStr();
		}
		
		if($this->_state->get() != NodeState::Unspecified) {
			$l['state'] = $this->_state->toStr();
		}
		
		return $l;		
	}
}