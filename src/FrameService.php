<?php
namespace SpringDvs;

class FrameService {
	public $response;
	public $len;
	public $result;
	
	public function __construct($result) {
		$this->response = DvspRcode::ok;
		$this->result = $result;
		$this->len = strlen($result);
	}
	
	public function serialise() {
		$serial = pack("LC", $this->response, $this->len);
		$serial .= pack_chars($this->result);
		return $serial;
	}
	
	public static function deserialise($bytes) {
		return new FrameService(substr($bytes, 5));
	}
}