<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Authors: Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */

namespace SpringDvs;

interface iNetspace {
	public function gsnNodesByAddress($address);
	public function gsnNodeByHostname($hostname);
	public function gsnNodeBySpringName($springname);
	public function gsnNodesByType($types);
	public function gsnNodesByState($state);
	public function gsnNodes();
	
	public function gsnNodeRegister($node);
	public function gsnNodeUnregister($node);
	public function gsnNodeUpdate($node);
	
	public function gtnRootNodes();
	public function gtnGeosubs();
	public function gtnGeosubRegister($node, $geosub);
	public function gtnGeosubUnregister($node, $geosub);
	public function gtnGeosubRootNodes($geosub);
	public function gtnGeosubNodeBySpringname($springname, $geosub);
}
