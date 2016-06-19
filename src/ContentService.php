<?php
namespace SpringDvs;

class ContentService implements IProtocolObject {
	private $_uri;

	public function __construct(Uri $uri) {
		$this->_uri = $uri;
	}

	public function uri() {
		return $this->_uri;
	}

	public static function fromStr($str) {
		return new ContentService(new Uri($str));
	}

	public function toStr() {
		return $this->_uri->toStr();
	}

}