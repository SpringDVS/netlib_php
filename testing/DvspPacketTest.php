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
		$packet = SpringDvs\DvspPacket::ofType(SpringDvs\DvspMsgType::gsn_register_host);

		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_register_host,
			$packet->header()->type			
		);
		
		$this->assertEquals(
			0,
			$packet->header()->size
		);
	}

	public function testStaticConstruct_Full() {
		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_register_host,
				"FooBar"
			);

		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_register_host,
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
		$frame = new SpringDvs\FrameRegister(
			SpringDvs\NetnodeType::org,
			SpringDvs\ServiceProtocol::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_register_host,
				$frame->serialise()
		);
		
		$f = SpringDvs\FrameRegister::deserialise($packet->content());

		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_register_host,
			$packet->header()->type
		);	
		
		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->protocol );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->hostname );
	}
	
	public function testSerialise_ExtractFrame() {
		$frame = new SpringDvs\FrameRegister(
			SpringDvs\NetnodeType::org,
			SpringDvs\ServiceProtocol::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_register_host,
				$frame->serialise()
		);
		
		$bytes = $packet->serialise();
		
		$f = SpringDvs\FrameRegister::deserialise(SpringDvs\DvspPacket::extractFrame($bytes));

		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->protocol );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->hostname );
	}
	
	public function testSerialiseDeserialise() {
		$frame = new SpringDvs\FrameRegister(
			SpringDvs\NetnodeType::org,
			SpringDvs\ServiceProtocol::http,
			"Foobar"
		);

		$packet = SpringDvs\DvspPacket::ofType(
				SpringDvs\DvspMsgType::gsn_register_host,
				$frame->serialise()
		);

		$bytes = $packet->serialise();

		$p = SpringDvs\DvspPacket::deserialise($bytes);
		$f = SpringDvs\FrameRegister::deserialise($packet->content());
		
		$this->assertEquals(
			SpringDvs\DvspMsgType::gsn_register_host,
			$p->header()->type
		);
		
		$this->assertEquals(
			9,
			$p->header()->size
		);

		$this->assertEquals( SpringDvs\NetnodeType::org, $f->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $f->protocol );
		$this->assertEquals( 6, $f->len );
		$this->assertEquals( "Foobar", $f->hostname );
	}
}
