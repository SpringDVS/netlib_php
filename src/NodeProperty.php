<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class NodeProperty implements IProtocolObject, IEnum {
	
	const All = 0;
	const Hostname = 1;
	const Address = 2;
	const State = 3;
	const Service = 4;
	const Role = 5;
	
	private $_type;
	private $_value;
	
	public function __construct($type, $value = null) {
		$this->_type = $type;
		$this->_value = $value;
	}
	
	public function get() {
		return $this->_type;
	}
	
	public function value() {

		
		if(!is_object($this->_value) || is_string($this->_value)) {
			return $this->_value;
		} else {
			return $this->_value->get();
		}
	}
	
	public static function fromStr($str) {
		
		if(!isset($str[0])) {
			return new NodeProperty(NodeProperty::All);
		}

		$parts = explode(" ", $str);
		$t = null;
		$v = null;

		if(count($parts) > 2) {
			throw new ParseFailure(ParseFailure::InvalidContentFormat); 
		}

		switch($parts[0]) {
			case "hostname": $t = NodeProperty::Hostname; break;
			case "address":  $t = NodeProperty::Address;  break;
			case "state":    $t = NodeProperty::State;    break;
			case "service":  $t = NodeProperty::Service;  break;
			case "role":     $t = NodeProperty::Role;     break;
			case "all":      $t = NodeProperty::All;      break;
			default:         throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
		
		if(!isset($parts[1])) {
			return new NodeProperty($t);
		}

		switch($parts[0]) {
			case "hostname": $v = $parts[1];                        break;
			case "address":  $v = $parts[1];                        break;
			case "state":    $v = NodeState::fromStr($parts[1]);    break;
			case "service":  $v = NodeService::fromStr($parts[1]);  break;
			case "role":     $v = NodeRole::fromStr($parts[1]);     break;
		}

		return new NodeProperty($t, $v);
	}
	
	public function toStr() {
		$out = "";
		switch($this->_type) {
			case NodeProperty::Hostname: $out = "hostname"; break;
			case NodeProperty::Address:  $out = "address";  break;
			case NodeProperty::State:    $out = "state";    break;
			case NodeProperty::Service:  $out = "service";  break;
			case NodeProperty::Role:     $out = "role";     break;
			case NodeProperty::All:      $out = "all";     break;
			default:                                        break;
		}
		
		if($this->_value == null){ return $out; }
		
		if(is_string($this->_value)) {
			$out .= " {$this->_value}";
		} else {
			$out .= " {$this->_value->toStr()}";
		}
		
		return $out;
	}
}