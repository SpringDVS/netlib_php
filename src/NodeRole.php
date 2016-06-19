<?php
namespace SpringDvs;
class NodeRole implements IProtocolObject, IEnum {
	const Unknown = 0;
	const Hub = 1;
	const Org = 2;
	const Hybrid = 3;

	private $_role;

	public function __construct($service) {
		$this->_role = $service;
	}

	public function get() {
		return $this->_role;
	}

	public static function fromStr($str) {
		switch ($str) {
			case "hub": return new NodeRole(NodeRole::Hub);
			case "org": return new NodeRole(NodeRole::Org);
			case "hybrid": return new NodeRole(NodeRole::Hybrid);
			default: return new NodeRole(NodeRole::Unknown);
		}
	}

	public function toStr() {
		switch ($this->_role) {
			case NodeRole::Hub: return "hub"; break;
			case NodeRole::Org: return "org"; break;
			case NodeRole::Hybrid: return "hybrid"; break;
			default: return "unknown"; break;
		}
	}
}