<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * Description of FrameNetwork
 *
 * @author cfg
 */
class FrameNetwork implements iFrame {
	public $list;
	
	public function __construct($list) {
		$this->list = $list;
	}
	
	public function serialise() {
		return pack_chars($this->list);
	}
	
	public static function deserialise($bytes) {
		return new FrameNetwork($bytes);
	}
	
	public static function lowerBound() {
		return 0;
	}
	
	public static function contentType() {
		return "FrameNetwork";
	}
	
	public function jsonEncode($option = '') {
		return array('list' => $this->list);
	}
}
