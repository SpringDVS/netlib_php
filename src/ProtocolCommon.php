<?php
//include ('bin_helpers.php');
namespace SpringDvs;


class ServiceProtocol {
	const dvsp = 0;
	const http = 1;
}

class NetnodeType {
	const undefined = 0;
	const root = 1;
	const org = 2;
	const trusted = 3;
	const georoot = 4;
}

class DvspMsgType {
	const undefined = 0;
	const gsn_register_host = 1;
	const gsn_unregister_host = 2;
	
	const gsn_resolution = 3;
	const gsn_local_area = 4;
	const gsn_root_nods = 5;
	const gsn_hostname = 6;
	
	const gsn_request = 7;
	const gsn_response = 8;
	const gsn_payload = 9;
	const gtn_root_nodes = 10;
}

class DvspRcode {
	const netspace_error = 101;
	const network_error = 102;
	const malformed_content = 103;
	const ok = 200;
	const fake_udp = 505;
}