<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * Used for sending information on a given node
 */
class FrameNodeInfo implements iFrame {
	public $code;
	public $type;
	public $service;
	public $address;
	public $name;
	
	public function __construct($code, $type, $service, $address, $name) {
		$this->code = $code;
		$this->type = $type;
		$this->service = $service;
		$this->address = $address;
		$this->name = $name;
	}
	
	public function serialise() {
		$frame = pack("LCCCCCC",
				$this->code,
				$this->type,
				$this->service,
				$this->address[0],
				$this->address[1],
				$this->address[2],
				$this->address[3]);
		
		$frame .= pack_chars($this->name);
		return $frame;
	}
	
	public static function deserialise($bytes) {
		if(strlen($bytes) < FrameNodeInfo::lowerBound()) return false;
		
		$v = unpack("Lcode/Ctype/Cservice/Ca0/Ca1/Ca2/Ca3", $bytes);
		
		return new FrameNodeInfo($v['code'], $v['type'], $v['service'],
					array($v['a0'],$v['a1'],$v['a2'],$v['a3']), 
					substr($bytes, FrameNodeInfo::lowerBound()));
	}
	
	public function jsonEncode($option) {
		return array(
			'code' => $this->code,
			'type' => $this->type,
			'service' => $this->service,
			'address' => $this->address,
			'name' => $this->name
		);
	}
	
	public static function contentType() {
		return "FrameNodeInfo";
	}

		public static function lowerBound() {
		return 10;
	}
}
