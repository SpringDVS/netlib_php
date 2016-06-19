<?php


include 'auto.php';

class EnumsTest extends PHPUnit_Framework_TestCase {

	public function testCmdType_FromStr_Register_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("register");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Register );
	}

	public function testCmdType_ToStr_Register_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("register");
		$this->assertEquals($fmt->toStr(), "register" );
	}

	public function testCmdType_FromStr_Unregister_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("unregister");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Unregister );
	}
	
	public function testCmdType_ToStr_Unregister_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("unregister");
		$this->assertEquals($fmt->toStr(), "unregister" );
	}
	
	public function testCmdType_FromStr_Info_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("info");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Info );
	}
	
	public function testCmdType_ToStr_Info_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("info");
		$this->assertEquals($fmt->toStr(), "info" );
	}
	
	
	public function testCmdType_FromStr_Update_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("update");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Update );
	}
	
	public function testCmdType_ToStr_Update_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("update");
		$this->assertEquals($fmt->toStr(), "update" );
	}
	
	
	public function testCmdType_FromStr_Resolve_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("resolve");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Resolve );
	}
	
	public function testCmdType_ToStr_Resolve_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("resolve");
		$this->assertEquals($fmt->toStr(), "resolve" );
	}
	

	public function testCmdType_FromStr_Service_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("service");
		$this->assertEquals($fmt->get(), SpringDvs\CmdType::Service );
	}
	
	public function testCmdType_ToStr_Service_Pass() {
		$fmt = SpringDvs\CmdType::fromStr("service");
		$this->assertEquals($fmt->toStr(), "service" );
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
		$this->assertEquals($fmt->toStr(), "disabled" );
	}

	public function testNodeState_FromStr_Enabled_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("enabled");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Enabled);
	}
	
	public function testNodeState_ToStr_Enabled_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("enabled");
		$this->assertEquals($fmt->toStr(), "enabled" );
	}

	public function testNodeState_FromStr_Unresponsive_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unresponsive");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Unresponsive);
	}
	
	public function testNodeState_ToStr_Unresponsive_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unresponsive");
		$this->assertEquals($fmt->toStr(), "unresponsive" );
	}

	public function testNodeState_FromStr_Unspecified_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unspecified");
		$this->assertEquals($fmt->get(), SpringDvs\NodeState::Unspecified);
	}
	
	public function testNodeState_ToStr_Unspecified_Pass() {
		$fmt = SpringDvs\NodeState::fromStr("unspecified");
		$this->assertEquals($fmt->toStr(), "unspecified" );
	}



	public function testNodeService_FromStr_Dvsp_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("dvsp");
		$this->assertEquals($fmt->get(), SpringDvs\NodeService::Dvsp);
	}
	
	public function testNodeState_ToStr_Dvsp_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("dvsp");
		$this->assertEquals($fmt->toStr(), "dvsp" );
	}

	public function testNodeService_FromStr_Http_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("http");
		$this->assertEquals($fmt->get(), SpringDvs\NodeService::Http);
	}
	
	public function testNodeState_ToStr_Http_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("http");
		$this->assertEquals($fmt->toStr(), "http" );
	}

	public function testNodeService_FromStr_Uknown_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("unknown");
		$this->assertEquals($fmt->get(), SpringDvs\NodeService::Unknown);
	}
	
	public function testNodeState_ToStr_Unknown_Pass() {
		$fmt = SpringDvs\NodeService::fromStr("unknown");
		$this->assertEquals($fmt->toStr(), "unknown" );
	}




	public function testNodeRole_FromStr_Hub_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("hub");
		$this->assertEquals($fmt->get(), SpringDvs\NodeRole::Hub);
	}
	
	public function testNodeHub_ToStr_Hub_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("hub");
		$this->assertEquals($fmt->toStr(), "hub" );
	}
	
	public function testNodeRole_FromStr_Org_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("org");
		$this->assertEquals($fmt->get(), SpringDvs\NodeRole::Org);
	}
	
	public function testNodeHub_ToStr_Org_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("org");
		$this->assertEquals($fmt->toStr(), "org" );
	}
	
	public function testNodeRole_FromStr_Hybrid_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("hybrid");
		$this->assertEquals($fmt->get(), SpringDvs\NodeRole::Hybrid);
	}
	
	public function testNodeHub_ToStr_Hybrid_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("hybrid");
		
		$this->assertEquals($fmt->toStr(), "hybrid" );
	}
	
	public function testNodeRole_FromStr_Unknown_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("unknown");
		$this->assertEquals($fmt->get(), SpringDvs\NodeRole::Unknown);
	}
	
	public function testNodeHub_ToStr_Uknown_Pass() {
		$fmt = SpringDvs\NodeRole::fromStr("unknown");
		$this->assertEquals($fmt->toStr(), "unknown" );
	}

	
	
	
	public function testProtocolResponse_FromStr_NetspaceError_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("101");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::NetspaceError);
	}
	
	public function testProtocolResponse_ToStr_NetspaceError_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("101");
		$this->assertEquals($fmt->toStr(), "101");
	}

	public function testProtocolResponse_FromStr_NetspaceDuplication_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("102");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::NetspaceDuplication);
	}

	public function testProtocolResponse_ToStr_NetspaceDuplication_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("102");
		$this->assertEquals($fmt->toStr(), "102");
	}
	
	public function testProtocolResponse_FromStr_NetworkError_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("103");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::NetworkError);
	}
	
	public function testProtocolResponse_ToStr_NetworkError_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("103");
		$this->assertEquals($fmt->toStr(), "103");
	}
	
	public function testProtocolResponse_FromStr_MalformedContent_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("104");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::MalformedContent);
	}
	
	public function testProtocolResponse_ToStr_MalformedContent_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("104");
		$this->assertEquals($fmt->toStr(), "104");
	}

	public function testProtocolResponse_FromStr_UnsupportedAction_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("121");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::UnsupportedAction);
	}
	
	public function testProtocolResponse_ToStr_UnsupportedAction_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("121");
		$this->assertEquals($fmt->toStr(), "121");
	}

	public function testProtocolResponse_FromStr_UnsupportedService_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("122");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::UnsupportedService);
	}
	
	public function testProtocolResponse_ToStr_UnsupportedService_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("122");
		$this->assertEquals($fmt->toStr(), "122");
	}
	
	public function testProtocolResponse_FromStr_Ok_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("200");
		$this->assertEquals($fmt->get(), SpringDvs\ProtocolResponse::Ok);
	}
	
	public function testProtocolResponse_ToStr_Ok_Pass() {
		$fmt = SpringDvs\ProtocolResponse::fromStr("200");
		$this->assertEquals($fmt->toStr(), "200");
	}
}