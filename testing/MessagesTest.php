<?php


include 'auto.php';

class FormatsTest extends PHPUnit_Framework_TestCase {

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
}