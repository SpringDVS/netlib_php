<?php

namespace SpringDvs;

/**
 * Used for sending a URL to be resolved
 */
class FrameResolution {
	public $url;
	
	public function __construct($url) {
		$this->url = $url;
	}
	
	public function serialise() {
		return pack_chars($this->url);
	}
	
	public static function deserialise($bytes) {
		return new FrameResolution($bytes);
	}
	
	public static function lowerBound() {
		return 0;
	}
	
	public static function contentType() {
		return "FrameResolution";
	}
	
	public function jsonEncode($option = '') {
		return array('url' => $this->url);
	}
}
