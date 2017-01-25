<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */

namespace SpringDvs;

class Node {
	private $_spring;
	private $_host;
	private $_hostpath;
	private $_address;
	private $_service;
	private $_state;
	private $_role;
	private $_key;
	
	/**
	 * Construct a new node object
	 * 
	 * The host parameter acts as a hostfield or just a hostname
	 * if there is no host path. This parameter is then split into
	 * the hostname and hostpath.
	 * 
	 * @param string $spring The Springname
	 * @param string $host The hostname/hostfield
	 * @param string $address The IP Address of the node
	 * @param \SpringDvs\NodeService $service The service layer running (DVSP or HTTP)
	 * @param \SpringDvs\NodeState $state Current state of node
	 * @param \SpringDvs\NodeRole $role Current role of the node
	 * @param string $key Ascii Armor of key
	 */
	public function __construct($spring, $host = "", $address = "", 
								$service = NodeService::Unknown,
								$state = NodeState::Unspecified, 
								$role = NodeRole::Unknown,
								$key = "") 
	{
		$this->_spring = $spring;
		
		$field = explode('/',$host, 2);
		$this->_host = $field[0];
		if(isset($field[1])) {
			$this->_hostpath = $field[1];
		}
		$this->_address = $address;
		
		$this->_service = is_numeric($service) ? new NodeService($service) : $service;
		$this->_state = is_numeric($state)     ? new NodeState($state)     : $state;
		$this->_role = is_numeric($role)       ? new NodeRole($role)       : $role;
		$this->_key = $key;
	}

	public static function from_str($str) {
		if(strpos($str, ":") !== false) {
			return Node::fromNodeInfo(NodeInfoFmt::fromStr($str));
		}
		
		$parts = explode(",", $str);
		
		switch(count($parts)) {
			case 1:  return Node::fromNodeSingle(NodeSingleFmt::fromStr($str));
			case 2:  return Node::fromNodeDouble(NodeDoubleFmt::fromStr($str));
			case 3:  return Node::fromNodeTriple(NodeTripleFmt::fromStr($str));
			case 4:  return Node::fromNodeQuad(NodeQuadFmt::fromStr($str));
			default: throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
	}

	/**
	 * Get the Springnanme
	 * @return string
	 */
	public function spring() {
		return $this->_spring;
	}
	
	/**
	 * Get the Hostname
	 * @return string
	 */
	public function host() {
		return $this->_host;
	}
	
	/**
	 * Get the hostpath of the node (if any)
	 * @return string The host path
	 */
	public function hostPath() {
		return $this->_hostpath;
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
	 * Get the address
	 * @return string
	 */
	public function address() {
		return $this->_address;
	}
	
	/**
	 * Get the service protocol
	 * @return \SpringDvs\NodeService
	 */
	public function service() {
		return $this->_service->get();
	}
	
	/**
	 * Get the current state
	 * @return \SpringDvs\NodeState
	 */
	public function state() {
		return $this->_state->get();
	}
	
	/**
	 * Get types of roles the node performs
	 * 
	 * @return \SpringDvs\NodeRole
	 */
	public function role() {
		return $this->_role->get();
	}
	
	/**
	 * Get the public key associated with the node
	 * 
	 * @return String
	 */
	public function key() {
		return $this->_key;
	}
	/**
	 * Update the service protocol of the node
	 * @param SpringDvs\DvspService $service
	 */
	public function updateService(NodeService $service) {
		$this->_service = $service;
	}
	
	/**
	 * Update the types of roles of the node
	 * 
	 * @param Bitfield $roles
	 */
	public function updateRoles(NodeRole $role) {
		$this->_role = $role;
	}

	/**
	 * Update the state of the node
	 * @param SpringDvs\DvspNode $state
	 */	
	public function updateState(NodeState $state) {
		$this->_state = $state;
	}
	
	/**
	 * Update the public key of the node
	 * @param SpringDvs\DvspNode $state
	 */
	public function updateKey($key) {
		$this->_key = $key;
	}
	
	/**
	 * Generate a NodeSingle format of node
	 * @return SpringDvs\NodeSingle
	 */
	public function toNodeSingle() {
		return new NodeSingleFmt($this->_spring);
	}
	
	/**
	 * Generate a Node from NodeSingle format
	 * @return \SpringDvs\Node
	 */
	public static function fromNodeSingle(NodeSingleFmt $fmt) {
		return new Node($fmt->spring());
	}
	
	/**
	 * Generate a NodeDouble format of node
	 * @return SpringDvs\NodeDoubleFmt
	 */
	public function toNodeDouble() {
		return new NodeDoubleFmt($this->_spring, $this->_host);
	}
	
	/**
	 * Generate a Node from NodeDouble format
	 * @return \SpringDvs\Node
	 */
	public static function fromNodeDouble(NodeDoubleFmt $fmt) {
		return new Node($fmt->spring(), $fmt->host());
	}
	
	/**
	 * Generate a NodeTriple format of node
	 * @return SpringDvs\NodeTripleFmt
	 */
	public function toNodeTriple() {
		return new NodeTripleFmt($this->_spring, $this->_host, $this->_address);
	}
	
	/**
	 * Generate a Node from NodeTriple format
	 * @return \SpringDvs\Node
	 */
	public static function fromNodeTriple(NodeTripleFmt $fmt) {
		return new Node($fmt->spring(), $fmt->host(), $fmt->address());
	}

	/**
	 * Generate a NodeQuad format of node
	 * @return SpringDvs\NodeQuadFmt
	 */
	public function toNodeQuad() {
		return new NodeQuadFmt($this->_spring, $this->_host, $this->_address, $this->_service);
	}
	
	/**
	 * Generate a Node from NodeQuad format
	 * @return \SpringDvs\Node
	 */
	public static function fromNodeQuad(NodeQuadFmt $fmt) {
		return new Node($fmt->spring(), $fmt->host(), $fmt->address(), $fmt->service());
	}

	/**
	 * Generate a NodeInfo format of node
	 * @return SpringDvs\NodeInfoFmt
	 */
	public function toNodeInfo() {
		return new NodeInfoFmt($this->_spring, $this->_host, $this->_address, $this->_service, $this->_role, $this->_state);
	}
	
	/**
	 * Generate a Node from NodeInfo format
	 * @return \SpringDvs\Node
	 */
	public static function fromNodeInfo(NodeInfoFmt $fmt) {
		return new Node($fmt->spring(), $fmt->host(), $fmt->address(),
						$fmt->service(), $fmt->state(), $fmt->role());
	}
}