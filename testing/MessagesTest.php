<?php
use SpringDvs\CmdType;
use SpringDvs\NodeRole;
use SpringDvs\NodeService;
use SpringDvs\ContentInfoRequest;
use SpringDvs\NodeProperty;
use SpringDvs\NodeState;
use SpringDvs\ProtocolResponse;
use SpringDvs\ContentResponse;

include 'auto.php';

class MessagesTest extends PHPUnit_Framework_TestCase {

	public function testContentRegistration_FromStr_Pass() {
		$mct = \SpringDvs\ContentRegistration::fromStr("foobar,foo.bar;org;http;bar\nPUBLIC KEY");
		$this->assertEquals($mct->double()->spring(), "foobar");
		$this->assertEquals($mct->double()->host(), "foo.bar");
		$this->assertEquals($mct->role(), \SpringDvs\NodeRole::Org);
		$this->assertEquals($mct->service(), \SpringDvs\NodeService::Http);
		$this->assertEquals($mct->token(), 'bar');
		$this->assertEquals($mct->key(), 'PUBLIC KEY');
	}
	
	public function testContentRegistration_ToStr_Pass() {
		$mct = \SpringDvs\ContentRegistration::fromStr("foobar,foo.bar;org;http;bar\nPUBLIC KEY");
		$this->assertEquals($mct->toStr(), "foobar,foo.bar;org;http;bar\nPUBLIC KEY");
	}
	
	public function testContentRegistration_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		\SpringDvs\ContentRegistration::fromStr("foobar,foo.bar;http");
		\SpringDvs\ContentRegistration::fromStr("foobar;org;http");
	}
	


	public function testContentInfoRequest_FromStr_Node_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("node foo state");
		$this->assertEquals($mct->type(), \SpringDvs\ContentInfoRequest::Node);
		$this->assertEquals($mct->get(), \SpringDvs\NodeProperty::State);
		$this->assertEquals($mct->spring(), "foo");
		$this->assertEquals($mct->value(), null);
		
		$mct = \SpringDvs\ContentInfoRequest::fromStr("node foo");
		$this->assertEquals($mct->type(), \SpringDvs\ContentInfoRequest::Node);
		$this->assertEquals($mct->get(), \SpringDvs\NodeProperty::All);
		$this->assertEquals($mct->spring(), "foo");
		$this->assertEquals($mct->value(), null);
	}

	public function testContentInfoRequest_FromStr_Network_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("network");
		$this->assertEquals($mct->type(), \SpringDvs\ContentInfoRequest::Network);
		$this->assertEquals($mct->get(), null);
		$this->assertEquals($mct->value(), null);
	}

	public function testContentInfoRequest_ToStr_Node_Pass() {
		$mct = \SpringDvs\ContentInfoRequest::fromStr("node foo state");
		$this->assertEquals($mct->toStr(), "node foo state");
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
		$mct = \SpringDvs\ContentUpdate::fromStr("foo state enabled");
		$this->assertEquals($mct->type(), \SpringDvs\NodeProperty::State);
		$this->assertEquals($mct->value(), \SpringDvs\NodeState::Enabled);
		$this->assertEquals($mct->spring(), "foo");
	}
	
	public function testContentUpdate_ToStr_Pass() {
		$mct = \SpringDvs\ContentUpdate::fromStr("foo state enabled");
		$this->assertEquals($mct->toStr(), "foo state enabled");
	}
	
	public function testContentUpdate_FromStr_Fail() {
		$this->setExpectedException('\SpringDvs\ParseFailure');
		\SpringDvs\ContentUpdate::fromStr("state enabled");
		\SpringDvs\ContentUpdate::fromStr("foo brain enabled");
	}



	public function testContentResponse_FromStr_EmptyContent_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("101");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::NetspaceError);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::EmptyContent);
	}
	
	public function testContentResponse_FromStr_NodeInfo_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 99 node spring:foobar,host:foo.bar");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::Ok);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::NodeInfo);
		$this->assertEquals($mct->content()->spring(), "foobar");
		$this->assertEquals($mct->content()->host(), "foo.bar");
	}
	
	public function testContentResponse_FromStr_Network_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::Ok);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::Network);
		$this->assertEquals(count($mct->content()->nodes()), 2);
		$this->assertEquals($mct->content()->nodes()[0]->spring(), "foobar");
		$this->assertEquals($mct->content()->nodes()[1]->spring(), "barfoo");
		$this->assertEquals($mct->content()->nodes()[0]->host(), "foo.bar");
		$this->assertEquals($mct->content()->nodes()[1]->host(), "bar.foo");
	}

	public function testContentResponse_FromStr_ServiceText_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 19 service/text foobar");
		$this->assertEquals($mct->code(), \SpringDvs\ProtocolResponse::Ok);
		$this->assertEquals($mct->type(), \SpringDvs\ContentResponse::ServiceText);
		$this->assertEquals($mct->content()->get(), "foobar");
	}
	
	public function testContentResponse_ToStr_EmptyContent_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("101");
		$this->assertEquals($mct->toStr(), "101");
	}
	
	public function testContentResponse_ToStr_Node_Pass() {

		$mct = \SpringDvs\ContentResponse::fromStr("200 31 node spring:foobar,host:foo.bar");
		$this->assertEquals($mct->toStr(), "200 31 node spring:foobar,host:foo.bar");
	}

	public function testContentResponse_ToStr_Network_Pass() {

		$mct = \SpringDvs\ContentResponse::fromStr("200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($mct->toStr(), "200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
	}
	
	public function testContentResponse_ToStr_ServiceText_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 19 service/text foobar");
		$this->assertEquals($mct->toStr(), "200 19 service/text foobar");
	}

	public function testContentResponse_ToJsonArray_EmptyContent_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("101");
		$ja = $mct->toJsonArray();
		$this->assertEquals($ja['code'], '101');
		$this->assertEquals($ja['type'], '');
		$this->assertEquals($ja['content'], '');
	}
	
	public function testContentResponse_ToJsonArray_NodeInfo_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 31 node spring:foobar,host:foo.bar");
		$ja = $mct->toJsonArray();
		$this->assertEquals($ja['code'], '200');
		$this->assertEquals($ja['type'], 'node');
		$this->assertEquals($ja['content']['spring'], 'foobar');
		$this->assertEquals($ja['content']['host'], 'foo.bar');
		$this->assertEquals(isset($ja['content']['address']), false);
	}
	
	public function testContentResponse_ToJsonArray_Network_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$ja = $mct->toJsonArray();
		$this->assertEquals($ja['code'], '200');
		$this->assertEquals($ja['type'], 'network');
		$this->assertEquals(count($ja['content']), 2);
		$this->assertEquals($ja['content'][0]['spring'], 'foobar');
		$this->assertEquals($ja['content'][0]['host'], 'foo.bar');
		$this->assertEquals($ja['content'][1]['spring'], 'barfoo');
		$this->assertEquals($ja['content'][1]['host'], 'bar.foo');
	}
	
	public function testContentResponse_ToJsonArray_ServiceText_Pass() {
		$mct = \SpringDvs\ContentResponse::fromStr("200 19 service/text foobar");
		$ja = $mct->toJsonArray();
		$this->assertEquals($ja['code'], '200');
		$this->assertEquals($ja['type'], 'service/text');
		$this->assertEquals($ja['content'], 'foobar');
	}
	public function testContentResolve_FromStr_Pass() {
		$mct = \SpringDvs\ContentResolve::fromStr("spring://a.b.c.uk:glq/foobar");
		$uri = $mct->uri();
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
		$this->assertEquals('foobar', $uri->res()[0]);
	}

	public function testContentResolve_ToStr_Pass() {
		$mct = \SpringDvs\ContentResolve::fromStr("spring://a.b.c.uk:glq/foobar");
		$this->assertEquals($mct->toStr(), "spring://a.b.c.uk:glq/foobar");
	}
	


	public function testContentService_FromStr_Pass() {
		$mct = \SpringDvs\ContentService::fromStr("spring://a.b.c.uk:glq/foobar");
		$uri = $mct->uri();
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
		$this->assertEquals('foobar', $uri->res()[0]);
	}
	
	public function testContentService_ToStr_Pass() {
		$mct = \SpringDvs\ContentService::fromStr("spring://a.b.c.uk:glq/foobar");
		$this->assertEquals($mct->toStr(), "spring://a.b.c.uk:glq/foobar");
	}
	
	public function testContentNodeSingle_FromStr_Pass() {
		$mct = \SpringDvs\ContentNodeSingle::fromStr("foobar");
		$this->assertEquals($mct->spring(), "foobar");
	}
	
	public function testContentNodeSingle_ToStr_Pass() {
		$mct = \SpringDvs\ContentNodeSingle::fromStr("foobar");
		$this->assertEquals($mct->toStr(), "foobar");
	}





	public function testMessage_FromStr_Register_Pass() {
		$mct = \SpringDvs\Message::fromStr("register foobar,foo.bar;org;http;bar\nPUBLIC KEY");
		$this->assertEquals($mct->cmd(), CmdType::Register);
		$this->assertEquals($mct->content()->double()->spring(), "foobar");
		$this->assertEquals($mct->content()->double()->host(), "foo.bar");
		$this->assertEquals($mct->content()->role(), NodeRole::Org);
		$this->assertEquals($mct->content()->service(), NodeService::Http);
		$this->assertEquals($mct->content()->token(), 'bar');
	}
	
	public function testMessage_ToStr_Register_Pass() {
		$mct = \SpringDvs\Message::fromStr("register foobar,foo.bar;org;http;bar\nPUBLIC KEY");
		$this->assertEquals($mct->toStr(), "register foobar,foo.bar;org;http;bar\nPUBLIC KEY");
	}
	
	
	public function testMessage_FromStr_Unregister_Pass() {
		$mct = \SpringDvs\Message::fromStr("unregister foobar");
		$this->assertEquals($mct->cmd(), CmdType::Unregister);
		$this->assertEquals($mct->content()->spring(), "foobar");
	}
	
	public function testMessage_ToStr_Unregister_Pass() {
		$mct = \SpringDvs\Message::fromStr("unregister foobar");
		$this->assertEquals($mct->toStr(), "unregister foobar");
	}
	
	public function testMessage_FromStr_Info_Node_Pass() {
		$mct = \SpringDvs\Message::fromStr("info node foobar state");
		$this->assertEquals($mct->cmd(), CmdType::Info);
		$this->assertEquals($mct->content()->type(), ContentInfoRequest::Node);
		$this->assertEquals($mct->content()->get(), NodeProperty::State);
	}
	
	public function testMessage_ToStr_Info_Node_Pass() {
		$mct = \SpringDvs\Message::fromStr("info node foobar state");
		$this->assertEquals($mct->toStr(), "info node foobar state");
	}	
	
	public function testMessage_FromStr_Info_Network_Pass() {
		$mct = \SpringDvs\Message::fromStr("info network");
		$this->assertEquals($mct->cmd(), CmdType::Info);
		$this->assertEquals($mct->content()->type(), ContentInfoRequest::Network);
	}
	
	public function testMessage_ToStr_Info_Network_Pass() {
		$mct = \SpringDvs\Message::fromStr("info network");
		$this->assertEquals($mct->toStr(), "info network");
	}
	
	public function testMessage_FromStr_Update_Pass() {
		$mct = \SpringDvs\Message::fromStr("update foobar state enabled");
		$this->assertEquals($mct->cmd(), CmdType::Update);
		$this->assertEquals($mct->content()->spring(), "foobar");
		$this->assertEquals($mct->content()->type(), NodeProperty::State);
		$this->assertEquals($mct->content()->value(), NodeState::Enabled);
	}
	
	public function testMessage_ToStr_Update_Pass() {
		$mct = \SpringDvs\Message::fromStr("update foobar state enabled");
		$this->assertEquals($mct->toStr(), "update foobar state enabled");
	}


	public function testMessage_FromStr_Resolve_Pass() {
		$mct = \SpringDvs\Message::fromStr("resolve spring://cci.esusx.uk");
		$this->assertEquals($mct->cmd(), CmdType::Resolve);
		$this->assertEquals($mct->content()->uri()->gtn(), "uk");
	}
	
	public function testMessage_ToStr_Resolve_Pass() {
		$mct = \SpringDvs\Message::fromStr("resolve spring://cci.esusx.uk");
		$this->assertEquals($mct->toStr(), "resolve spring://cci.esusx.uk");
	}
	
	public function testMessage_FromStr_Service_Pass() {
		$mct = \SpringDvs\Message::fromStr("resolve spring://cci.esusx.uk/res");
		$this->assertEquals($mct->cmd(), CmdType::Resolve);
		$this->assertEquals($mct->content()->uri()->gtn(), "uk");
	}
	
	public function testMessage_ToStr_Service_Pass() {
		$mct = \SpringDvs\Message::fromStr("resolve spring://cci.esusx.uk/res");
		$this->assertEquals($mct->toStr(), "resolve spring://cci.esusx.uk/res");
	}


	public function testMessage_FromStr_Response_Empty_Pass() {
		$mct = \SpringDvs\Message::fromStr("200");
		$this->assertEquals($mct->cmd(), CmdType::Response);
		$this->assertEquals($mct->content()->code(), ProtocolResponse::Ok);
	}
	
	public function testMessage_ToStr_Response_Empty_Pass() {
		$mct = \SpringDvs\Message::fromStr("200");
		$this->assertEquals($mct->toStr(), "200");
	}


	public function testMessage_FromStr_Response_NodeInfo_Pass() {
		$mct = \SpringDvs\Message::fromStr("200 31 node spring:foobar,host:foo.bar");

		$this->assertEquals($mct->cmd(), CmdType::Response);
		$this->assertEquals($mct->content()->code(), ProtocolResponse::Ok);
		$this->assertEquals($mct->content()->type(), ContentResponse::NodeInfo);
		$this->assertEquals($mct->content()->content()->spring(), "foobar");
		$this->assertEquals($mct->content()->content()->host(), "foo.bar");
	}
	
	public function testMessage_ToStr_Response_NodeInfo_Pass() {
		$mct = \SpringDvs\Message::fromStr("200 17 node host:foo.bar");
		$this->assertEquals($mct->toStr(), "200 17 node host:foo.bar");
	}
	

	public function testMessage_FromStr_Response_Network_Pass() {
		$mct = \SpringDvs\Message::fromStr("200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($mct->cmd(), CmdType::Response);
		$this->assertEquals($mct->content()->code(), ProtocolResponse::Ok);
		$this->assertEquals($mct->content()->type(), ContentResponse::Network);
		$this->assertEquals($mct->content()->content()->nodes()[0]->spring(), "foobar");
		$this->assertEquals($mct->content()->content()->nodes()[1]->spring(), "barfoo");
	}
	
	public function testMessage_ToStr_Response_Network_Pass() {
		$mct = \SpringDvs\Message::fromStr("200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$this->assertEquals($mct->toStr(), "200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
	}
	
	public function testMessage_ToJsonArray_Response_Network_Pass() {
		$mct = \SpringDvs\Message::fromStr("200 69 network foobar,foo.bar,127.0.0.1,http;barfoo,bar.foo,192.168.1.1,dvsp");
		$ja = $mct->toJsonArray();
		$this->assertEquals($ja['code'], '200');
		$this->assertEquals($ja['type'], 'network');
		$this->assertEquals(count($ja['content']), 2);
		$this->assertEquals($ja['content'][0]['spring'], 'foobar');
		$this->assertEquals($ja['content'][0]['host'], 'foo.bar');
		$this->assertEquals($ja['content'][1]['spring'], 'barfoo');
		$this->assertEquals($ja['content'][1]['host'], 'bar.foo');
	}

	public function testMessage_ToJsonArray_Fail() {
		$mct = \SpringDvs\Message::fromStr("update foo state enabled");
		$ja = $mct->toJsonArray();
		$this->assertEquals($ja['code'], '201');
	}

	public function testMessage_ServiceMulti_Head_Pass() {
		
		$buf = '200 14 service/multi 201 103 service/text {"leaf023.local.uk":[{"title":"Test Event","uid":"5","tags":["events","network","test"]}]} 201 112 service/text {"mainline.local.uk":[{"title":"Mainline Service","uid":"4","tags":["network","services","test"]}]} 202';
		$mct = \SpringDvs\Message::fromStr($buf);
		$this->assertEquals($mct->toStr(), $buf);
	}
	
	public function testMessage_ServiceMulti_Eot_Pass() {
		$buf = '202';
		$mct = \SpringDvs\Message::fromStr($buf);
		$this->assertEquals($mct->toStr(), "202");
	}
	
	public function testMessage_ServiceMulti_Vector_Pass() {
		$stream = '200 14 service/multi 201 103 service/text {"leaf023.local.uk":[{"title":"Test Event","uid":"5","tags":["events","network","test"]}]} 201 112 service/text {"mainline.local.uk":[{"title":"Mainline Service","uid":"4","tags":["network","services","test"]}]} 202';
		$mct = \SpringDvs\Message::fromStr($stream);
		
		$this->assertEquals($mct->getContentResponse()->type(), ContentResponse::ServiceMulti);
 		$messages = $mct->getContentResponse()->getServiceParts(); 
 		//ContentResponse::parseServiceMulti($stream, $mct->getContentResponse()->offset());
 		$this->assertEquals(count($messages), 2);
		
 		$this->assertEquals($messages[0]->toStr(), '201 103 service/text {"leaf023.local.uk":[{"title":"Test Event","uid":"5","tags":["events","network","test"]}]}');
 		$this->assertEquals($messages[1]->toStr(), '201 112 service/text {"mainline.local.uk":[{"title":"Mainline Service","uid":"4","tags":["network","services","test"]}]}');
	}
}