<?php
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
			default: return new NodeService(NodeService::Unknown);
		}
	}
	
	public function toStr() {
		switch ($this->_service) {
			case NodeService::Dvsp: echo "dvsp"; break;
			case NodeService::Http: echo "http"; break;
			default: echo "unknown"; break;
		}
	}
}