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

 
};

