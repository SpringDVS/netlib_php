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
}