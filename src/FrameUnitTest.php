<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

class FrameUnitTest implements \SpringDvs\iFrame {
	public $action;
	public $extra;

	public function __construct($action, $extra = '') {
		$this->action = $action;
		$this->extra = $extra;
	}
	
	public function serialise() {
		$bytes = pack("C", $this->action);
		
		$bytes .= pack_chars($this->extra);
		return $bytes;
	}
	
	public static function deserialise($bytes) {
		$v = unpack("Caction", $bytes);
		$action = $v['action'];
		$extra = substr($bytes, 1);
		
		return new FrameUnitTest($action,$extra);
	}
	
	public static function lowerBound() {
		return 1;
	}
	
	public function jsonEncode($option) {
		return array(
			'action' => $this->action,
			'extra' => $this->extra
		);
	}
	
	public static function contentType() {
		return "FrameUnitTest";
	}
}
