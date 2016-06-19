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
	
	
	
	
	
	public function testNodeState_FromStr_Disabled_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("disabled");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Disabled);
	}
	
	public function testNodeState_ToStr_Disabled_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("disabled");

		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "disabled" );
	}

	public function testNodeState_FromStr_Enabled_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("enabled");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Enabled);
	}
	
	public function testNodeState_ToStr_Enabled_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("enabled");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "enabled" );
	}

	public function testNodeState_FromStr_Unresponsive_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unresponsive");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Unresponsive);
	}
	
	public function testNodeState_ToStr_Unresponsive_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unresponsive");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "unresponsive" );
	}

	public function testNodeState_FromStr_Unspecified_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unspecified");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Unspecified);
	}
	
	public function testNodeState_ToStr_Unspecified_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unspecified");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "unspecified" );
	}



	public function testNodeService_FromStr_Dvsp_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("dvsp");
		$this->assertEquals($fmt->get(), SpringDvs\NodeService::Dvsp);
	}
	
	public function testNodeState_ToStr_Dvsp_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("dvsp");
	
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "dvsp" );
	}

	public function testNodeService_FromStr_Http_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("http");
		$this->assertEquals($fmt->get(), SpringDvs\NodeService::Http);
	}
	
	public function testNodeState_ToStr_Http_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("http");
	
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "http" );
	}

	public function testNodeService_FromStr_Uknown_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("unknown");
		$this->assertEquals($fmt->get(), SpringDvs\NodeService::Unknown);
	}
	
	public function testNodeState_ToStr_Unknown_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("unknown");
	
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "unknown" );
	}
}