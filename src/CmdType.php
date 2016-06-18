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
			case CmdType::Register:   echo "register";   break;
			case CmdType::Unregister: echo "unregister"; break;
			case CmdType::Info:       echo "info";       break;
			case CmdType::Update:     echo "update";     break;
			case CmdType::Resolve:    echo "resolve";    break;
			case CmdType::Service:    echo "service";    break;
			default: break;
		}
	}
};

