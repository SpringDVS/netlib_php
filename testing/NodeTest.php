<?php

include 'auto.php';

class NodeTest extends PHPUnit_Framework_TestCase {

	public function testNode_FromStr_NodeSingle_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar");
		$this->assertEquals($nd->spring(), "foobar");
	}
	
	public function testNode_ToFmt_NodeSingle_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar");
		$fmt = $nd->toNodeSingle();
		$this->assertEquals($fmt->spring(), "foobar");
	}
	
	public function testNode_FromStr_NodeDouble_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar,foo.bar");
		$this->assertEquals($nd->spring(), "foobar");
		$this->assertEquals($nd->host(), "foo.bar");
	}
	
	public function testNode_ToFmt_NodeDouble_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar,foo.bar");
		$fmt = $nd->toNodeDouble();
		$this->assertEquals($fmt->spring(), "foobar");
		$this->assertEquals($fmt->host(), "foo.bar");
	}
	
	public function testNode_FromStr_NodeTriple_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar,foo.bar,127.0.0.1");
		$this->assertEquals($nd->spring(), "foobar");
		$this->assertEquals($nd->host(), "foo.bar");
		$this->assertEquals($nd->address(), "127.0.0.1");
	}

	public function testNode_ToFmt_NodeTriple_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar,foo.bar,127.0.0.1");
		$fmt = $nd->toNodeTriple();
		$this->assertEquals($fmt->spring(), "foobar");
		$this->assertEquals($fmt->host(), "foo.bar");
		$this->assertEquals($fmt->address(), "127.0.0.1");
	}

	public function testNode_FromStr_NodeQuad_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar,foo.bar,127.0.0.1,dvsp");
		$this->assertEquals($nd->spring(), "foobar");
		$this->assertEquals($nd->host(), "foo.bar");
		$this->assertEquals($nd->address(), "127.0.0.1");
		$this->assertEquals($nd->service(), \SpringDvs\NodeService::Dvsp);
	}

	public function testNode_ToFmt_NodeQuad_Pass() {
		$nd = \SpringDvs\Node::from_str("foobar,foo.bar,127.0.0.1,dvsp");
		$fmt = $nd->toNodeQuad();
		$this->assertEquals($fmt->spring(), "foobar");
		$this->assertEquals($fmt->host(), "foo.bar");
		$this->assertEquals($fmt->address(), "127.0.0.1");
		$this->assertEquals($fmt->service(), \SpringDvs\NodeService::Dvsp);
	}

	public function testNode_FromStr_NodeInfo_Full_Pass() {
		$nd = \SpringDvs\Node::from_str("spring:foobar,host:foo.bar,address:127.0.0.1,service:http,state:enabled,role:org");
		$this->assertEquals($nd->spring(), "foobar");
		$this->assertEquals($nd->host(), "foo.bar");
		$this->assertEquals($nd->address(), "127.0.0.1");
		$this->assertEquals($nd->service(), \SpringDvs\NodeService::Http);
		$this->assertEquals($nd->state(), \SpringDvs\NodeState::Enabled);
		$this->assertEquals($nd->role(), \SpringDvs\NodeRole::Org);
	}
	
	public function testNode_FromStr_NodeInfo_Full_Partial() {
		$nd = \SpringDvs\Node::from_str("spring:foobar,host:foo.bar,address:127.0.0.1,state:enabled,role:org");
		$this->assertEquals($nd->spring(), "foobar");
		$this->assertEquals($nd->host(), "foo.bar");
		$this->assertEquals($nd->address(), "127.0.0.1");
		$this->assertEquals($nd->service(), \SpringDvs\NodeService::Unknown);
		$this->assertEquals($nd->state(), \SpringDvs\NodeState::Enabled);
		$this->assertEquals($nd->role(), \SpringDvs\NodeRole::Org);
	}
	
	public function testNode_ToFmt_NodeInfo_Pass() {
		$nd = \SpringDvs\Node::from_str("spring:foobar,host:foo.bar,address:127.0.0.1,service:http,state:enabled,role:org");
		$fmt = $nd->toNodeInfo();
		$this->assertEquals($fmt->spring(), "foobar");
		$this->assertEquals($fmt->host(), "foo.bar");
		$this->assertEquals($fmt->address(), "127.0.0.1");
		$this->assertEquals($fmt->service(), \SpringDvs\NodeService::Http);
		$this->assertEquals($fmt->state(), \SpringDvs\NodeState::Enabled);
		$this->assertEquals($fmt->role(), \SpringDvs\NodeRole::Org);
	}
	
	public function testNode_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		
		$nd = \SpringDvs\Node::from_str("foo,bar,bar,foo,bar");
		$this->assertEquals($nd, null);
		
		$nd = \SpringDvs\Node::from_str("foo,bar,127.0.0.1,ftp");
		$this->assertEquals($nd, null);
	}
}