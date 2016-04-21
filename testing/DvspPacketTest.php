<?php
require 'auto.php';

class DvspPacketTest extends PHPUnit_Framework_TestCase
{
	public function testDefaultConstruct() {
		$dflt = new SpringDvs\DvspPacket();
		
		$this->assertEquals(
				SpringDvs\DvspMsgType::undefined,
				$dflt->header()->type
		);
		
		$this->assertEquals(
			false,
			$dflt->header()->part
		);

		$this->assertEquals(
			array(127,0,0,1),
			$dflt->header()->addr_origin			
		);

		$this->assertEquals(
			array(127,0,0,1),
			$dflt->header()->addr_dest
		);

		$this->assertEquals(
			0,
			$dflt->header()->size
		);

		$this->assertEquals(
			"",
			$dflt->content()
		);
	}
	
	public function testStaticConstruct_Empty() {
		$packet = SpringDvs\DvspPacket::ofType(SpringDvs\DvspMsgType::gsn_registration);

		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_registration,
			$packet->header()->type			
		);
		
		$this->assertEquals(
			0,
			$packet->header()->size
		);
	}

	public function testStaticConstruct_Full() {
		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_registration,
				"FooBar"
			);

		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_registration,
			$packet->header()->type
		);
		
		$this->assertEquals(
			6,
			$packet->header()->size
		);
		
		$this->assertEquals(
			"FooBar",
			$packet->content()
		);
	}
	
	public function testStaticConstruct_FullFrame() {
		$frame = new SpringDvs\FrameRegistration(
			true,
			SpringDvs\DvspNodeType::org,
			SpringDvs\DvspService::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_registration,
				$frame->serialise()
		);
		
		$f = SpringDvs\FrameRegistration::deserialise($packet->content());

		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_registration,
			$packet->header()->type
		);	
		
		$this->assertEquals( SpringDvs\DvspNodeType::org, $f->type );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service);
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->nodereg );
	}
	
	public function testSerialise_ExtractFrame() {
		$frame = new SpringDvs\FrameRegistration(
			true,
			SpringDvs\DvspNodeType::org,
			SpringDvs\DvspService::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_registration,
				$frame->serialise()
		);
		
		$bytes = $packet->serialise();
		
		$f = SpringDvs\FrameRegistration::deserialise(SpringDvs\DvspPacket::extractFrame($bytes));

		$this->assertEquals( SpringDvs\DvspNodeType::org, $f->type );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->nodereg );
	}
	
	public function testContentAs() {
		$frame = new SpringDvs\FrameRegistration(
			true,
			SpringDvs\DvspNodeType::org,
			SpringDvs\DvspService::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_registration,
				$frame->serialise()
		);
		
		$f = $packet->contentAs(\SpringDvs\FrameRegistration::contentType());

		$this->assertEquals( SpringDvs\DvspNodeType::org, $f->type );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->nodereg );
	}
	
	public function testSerialiseDeserialise() {
		$frame = new SpringDvs\FrameRegistration(
			true,
			SpringDvs\DvspNodeType::org,
			SpringDvs\DvspService::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_registration,
				$frame->serialise()
		);

		$bytes = $packet->serialise();

		$p = SpringDvs\DvspPacket::deserialise($bytes);
		$f = SpringDvs\FrameRegistration::deserialise($packet->content());
		
		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_registration,
			$p->header()->type
		);
		
		$this->assertEquals(
			SpringDvs\FrameRegistration::lowerBound() + 6,
			$p->header()->size
		);

		$this->assertEquals( SpringDvs\DvspNodeType::org, $f->type );
		$this->assertEquals( SpringDvs\DvspService::http, $f->service );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->nodereg );
	}
}
