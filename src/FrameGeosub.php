<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * Description of FrameGeosub
 *
 * @author cfg
 */
class FrameGeosub {
	public $geosub;
	
	public function __construct($geosub) {
		$this->geosub = $geosub;
	}
	
	public function serialise() {
		return pack_chars($this->geosub);
	}
	
	public static function deserialise($bytes) {
		return new FrameGeosub($bytes);
	}
	
	public static function lowerBound() {
		return 0;
	}
	
	public static function contentType() {
		return "FrameGeosub";
	}
	
	public function jsonEncode($option = '') {
		return array('geosub' => $this->geosub);
	}
}
