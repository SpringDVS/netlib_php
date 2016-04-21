<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */

namespace SpringDvs;

class FrameResponse implements iFrame
{
	public $code;

	public function __construct($code) {
		$this->code = $code;
	}
	
	public function serialise() {
		return pack("L", $this->code);
	}
	
	public static function deserialise($bytes) {
		if(strlen($bytes) < FrameResponse::lowerBound()) return false;
		
		$v = unpack("Lval", $bytes);
		return new FrameResponse($v['val']);
	}
	
	public function json_encode() {
		return json_encode(array( 'code' => $this->code ));
	}


	public static function lowerBound() {
		4;
	}
	
	public static function contentType() {
		return "FrameResponse";
	}
}