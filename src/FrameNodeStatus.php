<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * Description of FrameNodeStatus
 *
 * @author cfg
 */
class FrameNodeStatus implements iFrame {
	public $code;
	public $status;
	
	public function __construct($status) {
		$this->code = 200;
		$this->status = $status;
	}
	
	public function serialise() {
		return pack("LC", $this->code, $this->status);
	}
	
	public static function deserialise($bytes) {
		if(strlen($bytes) < FrameNodeStatus::lowerBound()) return false;
		
		$v = unpack("Lcode/Cstatus", $bytes);
		return new FrameNodeStatus($v['status']);
	}
	
	public function jsonEncode($option = '') {
		return array(
			'code' => $this->code,
			'status' => $this->status
		);
	}
	
	public static function contentType() {
		return "FrameNodeStatus";
	}
	
	public static function lowerBound() {
		return 5;
	}
}
