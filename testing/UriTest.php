<?php
include 'auto.php';
/**
 * Description of DvspUriTest
 */
class UriTest extends PHPUnit_Framework_TestCase {
	public function testUri_Route_pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
	}

	public function testUri_RouteRes_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk/foobar");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('foobar', $uri->res()[0]);
	}

	public function testUri_RouteGlq_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk:glq");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
	}

	public function testUri_RouteQuery_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk?query");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('query', $uri->query());
	}

	public function testUri_RouteGlqRes_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk:glq/foobar");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
		$this->assertEquals('foobar', $uri->res()[0]);
	}

	public function testUri_RouteGlqQuery_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk:glq?query");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
		$this->assertEquals('query', $uri->query());
	}
	
	public function testUri_RouteGlqResQuery_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk:glq/foobar?query");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
		$this->assertEquals('foobar', $uri->res()[0]);
		$this->assertEquals('query', $uri->query());
	}
	
	public function test_UriNoGtn_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c");
		$this->assertEquals(3, count($uri->route()));
		$this->assertEquals('', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
	}
	
	public function testUri_RouteGlqMultiResQuery_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk:glq/foo/bar/?query");
		$this->assertEquals(4, count($uri->route()));
		$this->assertEquals('uk', $uri->gtn());
		$this->assertEquals('a', $uri->route()[0]);
		$this->assertEquals('b', $uri->route()[1]);
		$this->assertEquals('c', $uri->route()[2]);
		$this->assertEquals('uk', $uri->route()[3]);
		$this->assertEquals('glq', $uri->glq());
		$this->assertEquals('foo', $uri->res()[0]);
		$this->assertEquals('bar', $uri->res()[1]);
		$this->assertEquals('query', $uri->query());
	}
	
	public function testUri_Popping_Pass() {
		$uri = new \SpringDvs\Uri("spring://a.b.c.uk");
		$this->assertEquals(4, count($uri->route()));
		array_pop($uri->route());
		$this->assertEquals(3, count($uri->route()));
	}
	
	public function testUri_ToString_Pass() {
		$str = "spring://a.b.c.uk:glq/foobar?query";
		$uri = new \SpringDvs\Uri($str);
		
		$this->assertEquals($str, $uri->toStr());
	}
}
