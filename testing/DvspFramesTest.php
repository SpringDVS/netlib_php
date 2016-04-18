<?php
require 'auto.php';

class DvspFramesTest extends PHPUnit_Framework_TestCase {
	
	public function testRegisterFrame_Ctor() {
		$f = new SpringDvs\FrameRegistration(
				true,
				SpringDvs\NetnodeType::org,
				SpringDvs\ServiceProtocol::http,
				"Spring,Foobar");
		
		$this->assertEquals( true, $f->register );
		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->service );
		$this->assertEquals( 13, $f->len );
		$this->assertEquals( "Spring,Foobar", $f->nodereg );	
	}
	
	public function testRegisterFrame_SerialiseDeserialise() {
		$s = new SpringDvs\FrameRegistration(
				true,
				SpringDvs\NetnodeType::org,
				SpringDvs\ServiceProtocol::http,
				"Spring,Foobar");
		
		$bytes = $s->serialise();
		
		$f = SpringDvs\FrameRegistration::deserialise($bytes);
		
		$this->assertEquals( true, $f->register );
		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->service );
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

/*	
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
 */
 
};

