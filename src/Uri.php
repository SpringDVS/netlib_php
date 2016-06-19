<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SpringDvs;

/**
 * The representation of a URL
 */
class Uri {
	private $_route;
	private $_gtn;
	private $_glq;
	private $_res;
	private $_query;
	
	public function __construct($url = '') {
		$staticRoute = array();
		if($url == "") return;
		
		if(substr($url, 0, 9) != 'spring://')
			throw new Exception ("Malformed URL");
		
		$a = explode('?', substr($url,9), 2);
		if(isset($a[1])) {
			$this->_query = $a[1];
		}
		
		$b = explode('/', $a[0]);
		if(isset($b[1])) {
			$this->_res = array_slice($b, 1);
		}
		
		$c = explode(':', $b[0]);
		if(isset($c[1])) {
			$this->_glq = $c[1];
		}

		$d = explode('.', $c[0]);
		
		$last = count($d) - 1;
		switch($d[$last]) {
		case "uk":
			$this->_gtn = $d[$last];
			break;
		
		default:
			$this->_gtn = "";
		}
		
		$this->_route = $d;
	}
	
	public function &route() {
		return $this->_route;
	}
	
	public function gtn() {
		return $this->_gtn;
	}
	
	public function glq() {
		return $this->_glq;
	}
	
	public function query() {
		return $this->_query;
	}
	
	public function res() {
		return $this->_res;
	}
	
	public function toStr() {
		$url = "spring://";
		
		$last = count($this->_route) - 1;
		foreach($this->_route as $i => $r) {
			$url .= $r;
			if($i < $last)
				$url .= '.';
		}
		
		if(!empty($this->_glq)) {
			$url .= ":{$this->_glq}";
		}

		if(!empty($this->_res)) {
			$res = implode("/", $this->_res);
			$url .= "/{$res}";
		}

		if(!empty($this->_query)) {
			$url .= "?{$this->_query}";
		}
		
		return $url;
	}
	
	public function pop() {
		array_pop($this->_route);
	}
}
