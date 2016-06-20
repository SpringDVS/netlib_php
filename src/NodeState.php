<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

class NodeState implements IProtocolObject, IEnum {
	const Disabled = 0;
	const Enabled = 1;
	const Unresponsive = 2;
	const Unspecified = 4;

	private $_state;

	public function __construct($state) {
		$this->_state = $state;
	}

	public function get() {
		return $this->_state;
	}

	public static function fromStr($str) {
		switch ($str) {
			case "disabled": return new NodeState(NodeState::Disabled);
			case "enabled": return new NodeState(NodeState::Enabled);
			case "unresponsive": return new NodeState(NodeState::Unresponsive);
			default: return new NodeState(NodeState::Unspecified);
		}
	}

	public function toStr() {
		switch ($this->_state) {
			case NodeState::Disabled: return "disabled"; break;
			case NodeState::Enabled: return "enabled"; break;
			case NodeState::Unresponsive: return "unresponsive"; break;
			default: return "unspecified"; break;
		}
	}
}