<?php

namespace SpringDvs;

/**
 * Used for updating the status of the node with the network
 */
class FrameStateUpdate implements iFrame {
	public $state;
	public $springname;
	
	public function __construct($state, $springname) {
		$this->state = $state;
		$this->springname = $springname;
	}
	
	public function serialise() {
		$frame = pack('C', $this->state);
		$frame .= pack_chars($this->springname);
		return $frame;
	}
	
	public static function deserialise($bytes) {
		if(strlen($bytes) < FrameStateUpdate::lowerBound()) return false;
		
		$v = unpack('Cstate', $bytes);
		return new FrameStateUpdate(
				$v['state'],
				substr($bytes, FrameStateUpdate::lowerBound())
		);
	}
	
	public function jsonEncode($option = '') {
		return array(
			'state' => $this->state,
			'springname' => $this->springname
		);
	}
	
	public static function contentType() {
		return "FrameStateUpdate";
	}
	
	public static function lowerBound() {
		return 1;
	}
}
