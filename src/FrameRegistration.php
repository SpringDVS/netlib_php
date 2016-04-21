<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */

namespace SpringDvs;
class FrameRegistration implements iFrame {
	public $register;
	public $type;
	public $len;
	public $service;
	public $nodereg;
	
	/**
	 * Construct a gsn_registration frame to register with the node
	 * with the spring network
	 * 
	 * @param bool $register Register (true) or Unregister (false) node
	 * @param \SpringDvs\NetnodeType $type The type of node
	 * @param \SpringDvs\ServiceProtocol $service The Service Protocol
	 * @param type $hostname The hostname of the node
	 */
	public function __construct($register, $type, $service, $nodereg) {
		$this->register = $register;
		$this->type = $type;
		$this->nodereg = $nodereg;
		$this->service = $service;
		$this->len = strlen($nodereg);
	}
	
	/**
	 * Serialise frame into bytes for transmission
	 * @return string A string of bytes
	 */
	public function serialise() {
		$this->len = strlen($this->nodereg);
		$reg = $this->register ? 1 : 0;
		$frame = pack("cccc", $reg, $this->type, $this->len, $this->service);
		$frame .= pack_chars($this->nodereg);
		return $frame;
	}
	
	/**
	 * Deserialise a sequence of bytes into a frame
	 * @param string $bytes The serialised bytes
	 * @return SpringDvs\FrameRegister Filled out frame or false on failure
	 */
	public static function deserialise($bytes) {

		if(strlen($bytes) < FrameRegistration::lowerBound()) return false;
		
		$v = unpack("Creg/Ctype/Clen/Cservice", $bytes);
		
		return new FrameRegistration(
				($v["reg"] == 1) ? true : false,
				$v['type'],
				$v['service'],
				substr($bytes, 4)
			);
	}
	
	public function json_encode($option = '') {
		return array(
			'register' => $this->register,
			'type' => $this->type,
			'len' => $this->len,
			'service' => $this->service,
			'nodereg' => $this->nodereg
		);
	}
	
	public static function contentType() {
		return "FrameRegistration";
	}

	/**
	 * Get the lower bound number of bytes for frame
	 * @return int Number of bytes
	 */
	
	public static function lowerBound() {
		return 4;
	}
}
