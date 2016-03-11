<?php
require 'auto.php';

class DvspFramesTest extends PHPUnit_Framework_TestCase {
	
	public function testRegisterFrame_Ctor() {
		$f = new SpringDvs\FrameRegister(
				SpringDvs\NetnodeType::org,
				SpringDvs\ServiceProtocol::http,
				"Foobar");
		
		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->protocol );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->hostname );	
	}
	
	public function testRegisterFrame_SerialiseDeserialise() {
		$s = new SpringDvs\FrameRegister(
				SpringDvs\NetnodeType::org,
				SpringDvs\ServiceProtocol::http,
				"Foobar");
		
		$bytes = $s->serialise();
		
		$f = SpringDvs\FrameRegister::deserialise($bytes);
		
		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->protocol );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->hostname );
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
	
	public function testFrameService_Ctor() {
		$f = new SpringDvs\FrameService("FooBar");
		
		$this->assertEquals(SpringDvs\DvspRcode::ok, $f->response);
		$this->assertEquals(6, $f->len);
		$this->assertEquals("FooBar", $f->result);
	}

	public function testFrameService_SerialiseDeserialise() {
		$s = new SpringDvs\FrameService("FooBar");
		$bytes = $s->serialise();
		$f = SpringDvs\FrameService::deserialise($bytes);

		$this->assertEquals(SpringDvs\DvspRcode::ok, $f->response);
		$this->assertEquals(6, $f->len);
		$this->assertEquals("FooBar", $f->result);
	}
};

