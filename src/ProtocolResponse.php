<?php
namespace SpringDvs;

class ProtocolResponse implements IProtocolObject, IEnum {
	const NetspaceError = 101;
	const NetspaceDuplication = 102;
	const NetworkError = 103;
	const MalformedContent = 104;
	
	const UnsupportedAction  = 121;
	const UnsupportedService = 122;
	
	const Ok = 200;
	
	private $_code;
	
	public function __construct($code) {
		$this->_code = $code;
	}
	
	public function get() {
		return $this->_code;
	}
	
	public static function fromStr($str) {
		switch($str) {
			case "101": return new ProtocolResponse(ProtocolResponse::NetspaceError);
			case "102": return new ProtocolResponse(ProtocolResponse::NetspaceDuplication);
			case "103": return new ProtocolResponse(ProtocolResponse::NetworkError);
			case "104": return new ProtocolResponse(ProtocolResponse::MalformedContent);
			case "121": return new ProtocolResponse(ProtocolResponse::UnsupportedAction);
			case "122": return new ProtocolResponse(ProtocolResponse::UnsupportedService);
			case "200": return new ProtocolResponse(ProtocolResponse::Ok);
			default:    throw new ParseFailure(ParseFailure::InvalidContentFormat);
		}
	}
	
	public function toStr() {
		switch($this->_code) {
			case ProtocolResponse::NetspaceError: return "101";
			case ProtocolResponse::NetspaceDuplication: return "102";
			case ProtocolResponse::NetworkError: return "103";
			case ProtocolResponse::MalformedContent: return "104";
			case ProtocolResponse::UnsupportedAction: return "121";
			case ProtocolResponse::UnsupportedService: return "122";
			case ProtocolResponse::Ok: return "200";
		}
	}
}