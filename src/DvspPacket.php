<?php
/* Notice:  Copyright 2016, The Care Connections Initiative c.i.c.
 * Author:  Charlie Fyvie-Gauld <cfg@zunautica.org>
 * License: Apache License, Version 2 (http://www.apache.org/licenses/LICENSE-2.0)
 */
namespace SpringDvs;
class DvspPacket implements iNetSerial {
	private $m_header;
	private $m_content;
	
	/**
	 * Default construct a frame object
	 */
	public function __construct() {
		$this->m_header = new DvspHeader();
		$this->m_header->addr_origin = array(
			127,0,0,1
		);
		
		$this->m_header->addr_dest = array(
			127,0,0,1
		);
		$this->m_content = "";
		$this->m_header->size = 0;
		$this->m_header->type = DvspNodeType::undefined;
	}
	
	/**
	 * Static method to quick Construct a frame of type
	 * 
	 * @param SpringDvs\NetnodeType $type The type of frame
	 * @param string $content The bytes of the content
	 * @return \SpringDvs\DvspPacket
	 */
	public static function ofType($type, $content = "") {
		$p = new DvspPacket();
		$p->header()->type = $type;
		$p->copyContent($content);
		return $p;
	}
	
	/**
	 * Static method to separate and extract the content from
	 * the header in a serialised frame
	 * 
	 * @param string $bytes The bytes that contain the frame
	 * @return string The bytes that make up the content
	 */
	public static function extractFrame($bytes) {
		return substr($bytes, 14);
	}
	
	/**
	* Returns reference to the frame header
	*
	* @return SpringDvs\DvspHeader The header of the frame
	*/
	public function &header() {
		return $this->m_header;
	}
	
	/**
	* Returns string value of the content of the frame
	*
	* @return string The content
	*/
	public function content() {
		return $this->m_content;
	}
	
	public function contentAs($type) {
		return call_user_func($type."::deserialise", $this->m_content);
	}
	
	/**
	 * Set the content of the frame and update the header
	 * with the new size
	 * 
	 * @param string $data The content to assign
	 */
	public function copyContent($data) {
		$this->m_content = $data;
		$this->m_header->size = strlen($data);
	}
	
	/**
	 * Serialise the frame for transmission onto the network
	 * 
	 * @return string The serialised bytes
	 */
	public function serialise() {
		$frame = pack("CCLCCCCCCCC",
		$this->m_header->type,
		$this->m_header->part,
		$this->m_header->size,
				
		$this->m_header->addr_origin[0],
		$this->m_header->addr_origin[1],
		$this->m_header->addr_origin[2],
		$this->m_header->addr_origin[3],

		$this->m_header->addr_dest[0],
		$this->m_header->addr_dest[1],
		$this->m_header->addr_dest[2],
		$this->m_header->addr_dest[3]
		);

		for($i = 0; $i < $this->m_header->size; $i++) {
			$frame .= pack("C", ord($this->m_content[$i]));
		}
		
		return $frame;
	}
	
	/**
	 * Create a filled out frame object by deserialising the received
	 * string
	 * 
	 * @param string $bytes The bytes making up the serial
	 * @return \SpringDvs\DvspPacket or false on failure
	 */
	public static function deserialise($bytes) {
		
		if(strlen($bytes) < DvspPacket::lowerBound()) return false;
			
		$v = unpack("Ctype/Cpart/Lsize/C4origin/C4dest", $bytes);
		$p = new DvspPacket();
		$p->m_header->type = $v['type'];
		$p->m_header->part = $v['part'];
		$p->m_header->size = $v['size'];

		$p->m_header->addr_origin[0] = $v['origin1'];
		$p->m_header->addr_origin[1] = $v['origin2'];
		$p->m_header->addr_origin[2] = $v['origin3'];
		$p->m_header->addr_origin[3] = $v['origin4'];
		
		$p->m_header->addr_dest[0] = $v['dest1'];
		$p->m_header->addr_dest[1] = $v['dest2'];
		$p->m_header->addr_dest[2] = $v['dest3'];
		$p->m_header->addr_dest[3] = $v['dest4'];
		$p->copyContent(DvspPacket::extractFrame($bytes));
		return $p;
	}
	
	
	public function json_encode() {
		return json_encode(array(
				'type' => $this->m_header->type,
				'part' => $this->m_header->part,
				));
	}
	/**
	 * Get the lower bound number of bytes of a Packet
	 * 
	 * @returns int The number of bytes
	 */
	
	public static function lowerBound() {
		14;
	}
}