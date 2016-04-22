<?php

namespace SpringDvs;

/**
 * Request nodes of particular types
 */
class FrameTypeRequest implements iFrame {
	public $type;
	
	public function __construct($type) {
		$this->type = $type;
	}
	
	public function serialise() {
		return pack("C", $this->type);
	}
	
	public static function deserialise($bytes) {
		if(strlen($bytes) < FrameTypeRequest::lowerBound()) return false;
		
		$v = unpack("Ctype", $bytes);
		return new FrameTypeRequest($v['type']);
	}
	
	public function jsonEncode($option) {
		return array('type' => $this->type);
	}
	
	public static function contentType() {
		return "FrameTypeRequest";
	}


	public static function lowerBound() {
		return 1;
	}
}
