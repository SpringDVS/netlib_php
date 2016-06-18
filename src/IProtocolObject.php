<?php
namespace SpringDvs;
interface  IProtocolObject {
	static public function fromStr($str);
	public function toStr();
	
}