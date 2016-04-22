<?php
require 'auto.php';

class DvspFramesTest extends PHPUnit_Framework_TestCase {
	
	public function testRegisterFrame_Ctor() {
		$f = new SpringDvs\FrameRegistration(
				true,
				SpringDvs\DvspNodeType::org,
				SpringDvs\DvspService::http,
				"Spring,Foobar");
		
		$this->assertEquals( true, $f->register );
		$this->assertEquals( SpringDvs\DvspNodeType::org, $f->type );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service );
		$this->assertEquals( 13, $f->len );
		$this->assertEquals( "Spring,Foobar", $f->nodereg );	
	}
	
	public function testRegisterFrame_SerialiseDeserialise() {
		$s = new SpringDvs\FrameRegistration(
				true,
				SpringDvs\DvspNodeType::org,
				SpringDvs\DvspService::http,
				"Spring,Foobar");
		
		$bytes = $s->serialise();
		
		$f = SpringDvs\FrameRegistration::deserialise($bytes);
		
		$this->assertEquals( true, $f->register );
		$this->assertEquals( SpringDvs\DvspNodeType::org, $f->type );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service );
		$this->assertEquals( 13, $f->len );
		$this->assertEquals( "Spring,Foobar", $f->nodereg );
	}

	
	public function testFrameResponse_Ctor() {
		$f = new SpringDvs\FrameResponse(SpringDvs\DvspRcode::malformed_content);
		
		$this->assertEquals(SpringDvs\DvspRcode::malformed_content, $f->code);
	}

	public function testFrameResponse_SerialiseDeserialise() {
		$s = new SpringDvs\FrameResponse(SpringDvs\DvspRcode::malformed_content);
		$bytes = $s->serialise();
		$f = SpringDvs\FrameResponse::deserialise($bytes);
		$this->assertEquals(SpringDvs\DvspRcode::malformed_content, $f->code);
	}
	
	
	public function testFrameStateUpdateSerialiseDeserialise() {
		$in = new SpringDvs\FrameStateUpdate(SpringDvs\DvspNodeState::enabled, "foobar");
		$bytes = $in->serialise();

		$out = SpringDvs\FrameStateUpdate::deserialise($bytes);

		$this->assertEquals($in->state, $out->state);
		$this->assertEquals($in->springname, $out->springname);
	}

 	public function testFrameNodeRequestSerialiseDeserialise() {
		$in = new SpringDvs\FrameNodeRequest("foobar");
		$bytes = $in->serialise();

		$out = SpringDvs\FrameNodeRequest::deserialise($bytes);

		$this->assertEquals($in->node, $out->node);
	}
	
 	public function testFrameStatusRequestSerialiseDeserialise() {
		$in = new SpringDvs\FrameStatusRequest("foobar");
		$bytes = $in->serialise();

		$out = SpringDvs\FrameStatusRequest::deserialise($bytes);

		$this->assertEquals($in->node, $out->node);
	}
	
 	public function testFrameNodeInfoSerialiseDeserialise() {
		$in = new SpringDvs\FrameNodeInfo(
			\SpringDvs\DvspRcode::ok, 
			\SpringDvs\DvspNodeType::org,
			\SpringDvs\DvspService::http, 
			array(192,168,1,2), 
			"foobar"
		);
		
		$bytes = $in->serialise();

		$out = SpringDvs\FrameNodeInfo::deserialise($bytes);

		$this->assertEquals($in->code, $out->code);
		$this->assertEquals($in->type, $out->type);
		$this->assertEquals($in->service, $out->service);
		$this->assertEquals($in->address, $out->address);
		$this->assertEquals($in->name, $out->name);
	}
	
 	public function testFrameTypeRequestSerialiseDeserialise() {
		$in = new SpringDvs\FrameTypeRequest(SpringDvs\DvspNodeType::org);
			
		
		$bytes = $in->serialise();

		$out = SpringDvs\FrameTypeRequest::deserialise($bytes);

		$this->assertEquals($in->type, $out->type);
	}
	
 	public function testFrameResolutionSerialiseDeserialise() {
		$in = new SpringDvs\FrameResolution("spring://cci.esusx.uk");
		$bytes = $in->serialise();

		$out = SpringDvs\FrameResolution::deserialise($bytes);

		$this->assertEquals($in->url, $out->url);
	}
	
	public function testFrameGtnRegistrationSerialiseDeserialise() {
		$s = new SpringDvs\FrameGtnRegistration(
				true,
				SpringDvs\DvspService::http,
				"Spring,Foobar");
		
		$bytes = $s->serialise();
		
		$f = SpringDvs\FrameGtnRegistration::deserialise($bytes);
		
		$this->assertEquals( true, $f->register );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service );
		$this->assertEquals( 13, $f->len );
		$this->assertEquals( "Spring,Foobar", $f->nodereg );
	}
	
	public function testFrameNodeStatusSerialiseDeserialise() {
		$in = new SpringDvs\FrameNodeStatus(
			SpringDvs\DvspNodeState::unresponsive
		);
		
		$bytes = $in->serialise();
		
		$out = SpringDvs\FrameNodeStatus::deserialise($bytes);
		
		$this->assertEquals($in->code, $out->code);	
		$this->assertEquals($in->status, $out->status);	
	}
	
 	public function testFrameNetworkSerialiseDeserialise() {
		$in = new SpringDvs\FrameNetwork("foobar");
		$bytes = $in->serialise();

		$out = SpringDvs\FrameNetwork::deserialise($bytes);

		$this->assertEquals($in->list, $out->list);
	}
};

