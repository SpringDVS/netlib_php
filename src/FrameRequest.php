<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * Description of FrameRequest
 *
 * @author cfg
 */
class FrameRequest {
	public $payload;
	
	public function __construct($payload) {
		$this->payload = $payload;
	}
	
	public function serialise() {
		return pack_chars($this->payload);
	}
	
	public static function deserialise($bytes) {
		return new FrameRequest($bytes);
	}
	
	public static function lowerBound() {
		return 0;
	}
	
	public static function contentType() {
		return "FrameRequest";
	}
	
	public function jsonEncode($option = '') {
		return array('payload' => $this->payload);
	}
}
