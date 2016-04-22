<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * Request the state of a node on the network
 */
class FrameStatusRequest {
	public $node;
	
	public function __construct($node) {
		$this->node = $node;
	}
	
	public function serialise() {
		return pack_chars($this->node);
	}
	
	public static function deserialise($bytes) {
		return new FrameStatusRequest($bytes);
	}
	
	public static function lowerBound() {
		return 0;
	}
	
	public static function contentType() {
		return "FrameStatusRequest";
	}
	
	public function jsonEncode($option) {
		return array('node' => $this->node);
	}
}
