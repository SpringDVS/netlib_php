<?php
include 'auto.php';

class MessagesTest extends PHPUnit_Framework_TestCase {

	public function testContentRegistration_FromStr_Pass() {
		$mct = \SpringDvs\ContentRegistration::fromStr("foobar,foo.bar;org;http");
		$this->assertEquals($mct->double()->spring(), "foobar");
		$this->assertEquals($mct->double()->host(), "foo.bar");
		$this->assertEquals($mct->role(), \SpringDvs\NodeRole::Org);
		$this->assertEquals($mct->service(), \SpringDvs\NodeService::Http);
	}
	
	public function testContentRegistration_ToStr_Pass() {
		$mct = \SpringDvs\ContentRegistration::fromStr("foobar,foo.bar;org;http");
		$this->assertEquals($mct->toStr(), "foobar,foo.bar;org;http");
	}
	
	public function testContentRegistration_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		\SpringDvs\ContentRegistration::fromStr("foobar,foo.bar;http");
		\SpringDvs\ContentRegistration::fromStr("foobar;org;http");
	}
	


	public function testContentInfoRequest_FromStr_Node_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("node state");
		$this->assertEquals($mct->type(), \SpringDvs\ContentInfoRequest::Node);
		$this->assertEquals($mct->get(), \SpringDvs\NodeProperty::State);
		$this->assertEquals($mct->value(), null);
		
		$mct = \SpringDvs\ContentInfoRequest::fromStr("node");
		$this->assertEquals($mct->type(), \SpringDvs\ContentInfoRequest::Node);
		$this->assertEquals($mct->get(), \SpringDvs\NodeProperty::All);
		$this->assertEquals($mct->value(), null);
	}

	public function testContentInfoRequest_FromStr_Network_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("network");
		$this->assertEquals($mct->type(), \SpringDvs\ContentInfoRequest::Network);
		$this->assertEquals($mct->get(), null);
		$this->assertEquals($mct->value(), null);
	}

	public function testContentInfoRequest_ToStr_Node_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("node state");
		$this->assertEquals($mct->toStr(), "node state");
	}
	
	public function testContentInfoRequest_ToStr_Network_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("network");
		$this->assertEquals($mct->toStr(), "network");
	}
	
	public function testContentInfoRequest_FromStr_Node_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		\SpringDvs\ContentInfoRequest::fromStr("nodez state");
		\SpringDvs\ContentInfoRequest::fromStr("node void");
		\SpringDvs\ContentInfoRequest::fromStr("n");
	}



	public function testContentUpdate_FromStr_Pass() {
		$mct = \SpringDvs\ContentUpdate::fromStr("state enabled");
		$this->assertEquals($mct->type(), \SpringDvs\NodeProperty::State);
		$this->assertEquals($mct->value(), \SpringDvs\NodeState::Enabled);
	}
	
	public function testContentUpdate_ToStr_Pass() {
		$mct = \SpringDvs\ContentUpdate::fromStr("state enabled");
		$this->assertEquals($mct->toStr(), "state enabled");
	}
	
	public function testContentUpdate_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		\SpringDvs\ContentUpdate::fromStr("brain enabled");
	}



	public function testContentResponse_FromStr_EmptyContent_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("101");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::NetspaceError);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::EmptyContent);
	}
	
	public function testContentResponse_FromStr_NodeInfo_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 node spring:foobar,host:foo.bar");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::Ok);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::NodeInfo);
		$this->assertEquals($mct->content()->spring(), "foobar");
		$this->assertEquals($mct->content()->host(), "foo.bar");
	}
	
	public function testContentResponse_FromStr_Network_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::Ok);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::Network);
		$this->assertEquals(count($mct->content()->nodes()), 2);
		$this->assertEquals($mct->content()->nodes()[0]->spring(), "foobar");
		$this->assertEquals($mct->content()->nodes()[1]->spring(), "barfoo");
		$this->assertEquals($mct->content()->nodes()[0]->host(), "foo.bar");
		$this->assertEquals($mct->content()->nodes()[1]->host(), "bar.foo");
	}
	
	public function testContentResponse_ToStr_EmptyContent_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("101");
		$this->assertEquals($mct->toStr(), "101");
	}
	
	public function testContentResponse_ToStr_Node_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 node spring:foobar,host:foo.bar");
		$this->assertEquals($mct->toStr(), "200 node spring:foobar,host:foo.bar");
	}
	
	public function testContentResponse_ToStr_Network_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($mct->toStr(), "200 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
	}
}