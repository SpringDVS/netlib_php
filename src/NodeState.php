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
			case "disabled": return new NodeService(NodeState::Disabled);
			case "enabled": return new NodeService(NodeState::Enabled);
			case "unresponsive": return new NodeService(NodeState::Unresponsive);
			default: return new NodeService(NodeService::Unspecified);
		}
	}

	public function toStr() {
		switch ($this->_service) {
			case NodeState::Disabled: echo "disable"; break;
			case NodeState::Enabled: echo "enabled"; break;
			case NodeState::Unresponsive: echo "unresponsive"; break;
			default: echo "unspecified"; break;
		}
	}
}