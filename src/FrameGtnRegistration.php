<?php

namespace SpringDvs;

/**
 * For registering a node as  root on the GTN
 */

class FrameGtnRegistration {
	public $register;
	public $service;
	public $len;
	public $nodereg;
	
	/**
	 * Construct a frame to register with the node
	 * with the spring GTN
	 * 
	 * @param bool $register Register (true) or Unregister (false) node
	 * @param \SpringDvs\ServiceProtocol $service The Service Protocol
	 * @param type $hostname The hostname of the node
	 */
	public function __construct($register, $service, $nodereg) {
		$this->register = $register;
		$this->service = $service;
		$this->len = strlen($nodereg);
		$this->nodereg = $nodereg;
	}
	
	/**
	 * Serialise frame into bytes for transmission
	 * @return string A string of bytes
	 */
	public function serialise() {
		$this->len = strlen($this->nodereg);
		$reg = $this->register ? 1 : 0;
		$frame = pack("ccc", $reg, $this->service, $this->len);
		$frame .= pack_chars($this->nodereg);
		return $frame;
	}
	
	/**
	 * Deserialise a sequence of bytes into a frame
	 * @param string $bytes The serialised bytes
	 * @return SpringDvs\FrameGtnRegistration Filled out frame or false on failure
	 */
	public static function deserialise($bytes) {

		if(strlen($bytes) < FrameGtnRegistration::lowerBound()) return false;
		
		$v = unpack("Creg/Cservice/Clen", $bytes);
		
		return new FrameGtnRegistration(
				($v["reg"] == 1) ? true : false,
				$v['service'],
				substr($bytes, 3) // skip the len byte
			);
	}
	
	public function jsonEncode($option = '') {
		return array(
			'register' => $this->register,
			'service' => $this->service,
			'len' => $this->len,
			'nodereg' => $this->nodereg
		);
	}
	
	public static function contentType() {
		return "FrameGtnRegistration";
	}

	/**
	 * Get the lower bound number of bytes for frame
	 * @return int Number of bytes
	 */
	
	public static function lowerBound() {
		return 3;
	}	
}
