<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
//include ('bin_helpers.php');
namespace SpringDvs;


class DvspService {
	const unspecified = 0;
	const dvsp = 1;
	const http = 2;
}

class DvspNodeType {
	const undefined = 0;
	const root = 1;
	const org = 2;
}

class DvspMsgType {
	const undefined = 0;
	const gsn_registration = 1;
	const gsn_resolution = 2;
	
	const gsn_area = 3;
	const gsn_state = 4;
	const gsn_node_info = 5;
	const gsn_node_status = 6;
	
	const gsn_request = 7;
	const gsn_type_request = 8;

	const gtn_geosub = 21;
	const gtn_registration = 22;
	const gtn_geosub_nodes = 23;
	
	const gsn_response = 30;
	const gsn_response_node_info = 31;
	const gsn_response_network = 32;
	const gsn_response_high = 33;
	const gsn_response_status = 34;
	
	const unit_test = 101;
}

class DvspRcode {
	const netspace_error = 101;
	const netspace_duplication = 102;
	const network_error = 103;
	const malformed_content = 104;
	const ok = 200;
}

class DvspNodeState {
	const disabled = 0;
	const enabled = 1;
	const unresponsive = 2;
	const unspecified = 3;
}

class UnitTestAction {
	const undefine = 0;
	const reset = 1;
	const update_address = 2;
	const add_geosub_root = 3;
}