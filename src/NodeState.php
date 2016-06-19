<?php
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
			case NodeState::Disabled: echo "disabled"; break;
			case NodeState::Enabled: echo "enabled"; break;
			case NodeState::Unresponsive: echo "unresponsive"; break;
			default: echo "unspecified"; break;
		}
	}
}