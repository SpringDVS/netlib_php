<?php
include 'auto.php';
/**
 * Test the interface between the HTTP service layer transport
 * and the DVSP network layer
 */
class DvspHttpTest  extends PHPUnit_Framework_TestCase {
	public function testSerialiseDeserialise() {
		$f = new SpringDvs\FrameRegistration(
			true,
			SpringDvs\NetnodeType::org,
			SpringDvs\ServiceProtocol::http,
			"Spring,Foobar");
		
		$b = $f->serialise();
		$encoded = bin2hex($b);
		
		$bytes = SpringDvs\hex_to_bin($encoded);
		
		$frame = SpringDvs\FrameRegistration::deserialise($bytes);

		$this->assertEquals( true, $frame->register );
		$this->assertEquals( SpringDvs\NetnodeType::org, $frame->type );
		$this->assertEquals( SpringDvs\ServiceProtocol::http, $frame->service );
		$this->assertEquals( 13, $frame->len );
		$this->assertEquals( "Spring,Foobar", $frame->nodereg );
	}
}
