<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;

function pack_chars($str) {
	$len = strlen($str);
	$out = NULL;
	for($i = 0; $i < $len; $i++)
		$out .= pack("C*", ord($str[$i]));
	return $out;
}

function rcode_to_string($code) {
	switch($code) {
		case DvspRcode::ok:					return "rcode::ok";
		case DvspRcode::netspace_error:		return "rcode::netspace_error";
		case DvspRcode::malformed_content:	return "rcode::malformed_content";
		case DvspRcode::network_error:		return "rcode::network_error";
		case DvspRcode::fake_udp:			return "rcode::fake_udp";

		default: return "Unknown";
	}
}

function hex_to_bin($str) {
	return pack("H*" , $str);
}