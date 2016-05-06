<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
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
