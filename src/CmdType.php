<?php
namespace SpringDvs;
class CmdType implements IProtocolObject, IEnum {
	const Register = 1;
	const Unregister = 2;
	const Info = 3;
	const Update = 4;
	const Resolve = 5;
	const Service = 6;
	const Response = 7;
	
	private $_type;
	
	public function __construct($type) {
		$this->_type = $type;
	}
	
	public function get() {
		return $this->_type;
	}
	
	public static function fromStr($str) {
		
		if(is_numeric($str)) {
			return new CmdType(CmdType::Response);
		}
		
		switch($str) {
			case "register":   return new CmdType(CmdType::Register);
			case "unregister": return new CmdType(CmdType::Unregister);
			case "info":       return new CmdType(CmdType::Info);
			case "update":     return new CmdType(CmdType::Update);
			case "resolve":    return new CmdType(CmdType::Resolve);
			case "service":    return new CmdType(CmdType::Service);
			default:           throw new ParseFailure(ParseFailure::InvalidCommand); 
		}
	}
	
	public function toStr() {
		switch($this->_type) {
			case CmdType::Register:   return "register";   break;
			case CmdType::Unregister: return "unregister"; break;
			case CmdType::Info:       return "info";       break;
			case CmdType::Update:     return "update";     break;
			case CmdType::Resolve:    return "resolve";    break;
			case CmdType::Service:    return "service";    break;
			default: break;
		}
	}
};

