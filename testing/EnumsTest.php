<?php


use SpringDvs;

include 'auto.php';

class EnumsTest extends PHPUnit_Framework_TestCase {

	public function testCmdType_FromStr_Register_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("register");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Register );
	}

	public function testCmdType_ToStr_Register_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("register");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "register" );
	}

	public function testCmdType_FromStr_Unregister_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("unregister");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Unregister );
	}
	
	public function testCmdType_ToStr_Unregister_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("unregister");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "unregister" );
	}
	
	public function testCmdType_FromStr_Info_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("info");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Info );
	}
	
	public function testCmdType_ToStr_Info_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("info");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "info" );
	}
	
	
	public function testCmdType_FromStr_Update_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("update");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Update );
	}
	
	public function testCmdType_ToStr_Update_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("update");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "update" );
	}
	
	
	public function testCmdType_FromStr_Resolve_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("resolve");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Resolve );
	}
	
	public function testCmdType_ToStr_Resolve_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("resolve");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "resolve" );
	}
	

	public function testCmdType_FromStr_Service_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("service");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Service );
	}
	
	public function testCmdType_ToStr_Service_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("service");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "service" );
	}
	

	public function testCmdType_FromStr_Response_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("200");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Response );
	}

	public function testCmdType_ToStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		$fmt = SpringDvs\CmdType::fromStr("sss");
	}
}