<?php
require 'auto.php';

class DvspBinHelperTest extends PHPUnit_Framework_TestCase {
	public function testHexToBin() {
		
		$binstr = SpringDvs\hex_to_bin("466f6f62617203");
		
		$this->assertEquals( strlen($binstr), 7 );
		$this->assertEquals(substr($binstr,0,6), "Foobar" );
	}
}
