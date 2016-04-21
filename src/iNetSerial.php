<?php

/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */


namespace SpringDvs;

/**
 * Interface for anything that needs to be serialised and deserialised
 * when transported across the network.
  */

interface iNetSerial {
	public function serialise();
	public function json_encode();
	public static function deserialise($bytes);
	public static function lowerBound();
	
}
