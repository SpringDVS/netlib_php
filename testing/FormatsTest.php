<?php
include 'auto.php';

class FormatsTest extends PHPUnit_Framework_TestCase {

	public function testNodeSingle_FromStr_Pass() {
		$fmt = SpringDvs\NodeSingleFmt::fromStr("spring");
		$this->assertEquals($fmt->spring(), "spring" );
	}
	
	public function testNodeSingle_ToStr_Pass() {
		$fmt = SpringDvs\NodeSingleFmt::fromStr("spring");
		$this->assertEquals($fmt->toStr(), "spring" );
	}
	
	
	public function testNodeDouble_FromStr_Pass() {
		$fmt = SpringDvs\NodeDoubleFmt::fromStr("spring,host");
		$this->assertEquals($fmt->spring(), "spring" );
		$this->assertEquals($fmt->host(), "host" );
	}
	
	public function testNodeDouble_ToStr_Pass() {
		$fmt = SpringDvs\NodeDoubleFmt::fromStr("spring,host");
		$this->assertEquals($fmt->toStr(), "spring,host" );
	}
	
	public function testNodeDouble_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		$fmt = SpringDvs\NodeDoubleFmt::fromStr("spring,host,blah");
	}

	
	public function testNodeTriple_FromStr_Pass() {
		$fmt = SpringDvs\NodeTripleFmt::fromStr("spring,host,127.0.0.1");
		$this->assertEquals($fmt->spring(), "spring" );
		$this->assertEquals($fmt->host(), "host" );
		$this->assertEquals($fmt->address(), "127.0.0.1" );
	}
	
	public function testNodeTripe_ToStr_Pass() {
		$fmt = SpringDvs\NodeTripleFmt::fromStr("spring,host,127.0.0.1");
		ob_start();
		$fmt->toStr();
		$this->assertEquals(ob_get_clean(), "spring,host,127.0.0.1" );
	}
	
	public function testNodeTriple_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		$fmt = SpringDvs\NodeTripleFmt::fromStr("spring,host");
	}



	public function testNodeQuad_FromStr_Pass() {
		$fmt = SpringDvs\NodeQuadFmt::fromStr("spring,host,127.0.0.1,http");
		$this->assertEquals($fmt->spring(), "spring" );
		$this->assertEquals($fmt->host(), "host" );
		$this->assertEquals($fmt->address(), "127.0.0.1" );
		$this->assertEquals($fmt->service(), SpringDvs\NodeService::Http );
	}
	
	public function testNodeQuad_ToStr_Pass() {
		$fmt = SpringDvs\NodeQuadFmt::fromStr("spring,host,127.0.0.1,http");
		$this->assertEquals($fmt->toStr(), "spring,host,127.0.0.1,http" );
	}
	
	public function testNodeQuad_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		$fmt = SpringDvs\NodeQuadFmt::fromStr("spring,host");
	}
	
	
	public function testNodeInfo_FromStr_Full_Pass() {
		$fmt = SpringDvs\NodeInfoFmt::fromStr("spring:foobar,host:foo.bar,address:127.0.0.1,service:http,role:hybrid,state:enabled");
		$this->assertEquals($fmt->spring(), "foobar" );
		$this->assertEquals($fmt->host(), "foo.bar" );
		$this->assertEquals($fmt->address(), "127.0.0.1" );
		$this->assertEquals($fmt->service(), SpringDvs\NodeService::Http );
		$this->assertEquals($fmt->role(), SpringDvs\NodeRole::Hybrid );
		$this->assertEquals($fmt->state(), SpringDvs\NodeState::Enabled );
	}
	
	public function testNodeInfo_FromStr_Partial_Pass() {
		$fmt = SpringDvs\NodeInfoFmt::fromStr("spring:foobar,address:127.0.0.1,role:hybrid,state:enabled");
		$this->assertEquals($fmt->spring(), "foobar" );
		$this->assertEquals($fmt->host(), "" );
		$this->assertEquals($fmt->address(), "127.0.0.1" );
		$this->assertEquals($fmt->service(), SpringDvs\NodeService::Unknown );
		$this->assertEquals($fmt->role(), SpringDvs\NodeRole::Hybrid );
		$this->assertEquals($fmt->state(), SpringDvs\NodeState::Enabled );
	}
	
	public function testNodeInfo_ToStr_Full_Pass() {
		$fmt = SpringDvs\NodeInfoFmt::fromStr("spring:foobar,host:foo.bar,address:127.0.0.1,service:http,role:hybrid,state:enabled");
		$this->assertEquals($fmt->toStr(), "spring:foobar,host:foo.bar,address:127.0.0.1,service:http,role:hybrid,state:enabled" );
	}
	
	public function testNodeInfo_ToStr_Partial_Pass() {
		$fmt = SpringDvs\NodeInfoFmt::fromStr("spring:foobar,host:foo.bar,address:127.0.0.1,service:http,state:enabled");
		$this->assertEquals($fmt->toStr(), "spring:foobar,host:foo.bar,address:127.0.0.1,service:http,state:enabled" );
	}
	
	
	
	public function testNetwork_FromStr_Pass() {
		$fmt = SpringDvs\NetworkFmt::fromStr("foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals(count($fmt->nodes()), 2);
		$this->assertEquals($fmt->nodes()[0]->spring(), "foobar");
		$this->assertEquals($fmt->nodes()[1]->spring(), "barfoo");
		$this->assertEquals($fmt->nodes()[0]->host(), "foo.bar");
		$this->assertEquals($fmt->nodes()[1]->host(), "bar.foo");
	}
	
	public function testNetwork_ToStr_Pass() {
		$fmt = SpringDvs\NetworkFmt::fromStr("foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($fmt->toStr(), "foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
	}
}