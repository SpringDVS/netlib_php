<?php

namespace SpringDvs;

class FrameResponse 
{
	public $code;

	public function __construct($code) {
		$this->code = $code;
	}
	
	public function serialise() {
		return pack("L", $this->code);
	}
	
	public static function deserialise($bytes) {
		$v = unpack("Lval", $bytes);
		return new FrameResponse($v['val']);
	}
}