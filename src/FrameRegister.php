<?php
namespace SpringDvs;
class FrameRegister {
	public $type;
	public $len;
	public $protocol;
	public $hostname;
	
	/**
	 * Construct a gsn_register frame to register with the node
	 * with the spring network
	 * 
	 * @param \SpringDvs\NetnodeType $type The type of node
	 * @param \SpringDvs\ServiceProtocol $protocol The Service Protocol
	 * @param type $hostname The hostname of the node
	 */
	public function __construct($type, $protocol, $hostname) {
		$this->type = $type;
		$this->hostname = $hostname;
		$this->protocol = $protocol;
		$this->len = strlen($hostname);
	}
	
	/**
	 * Serialise frame into bytes for transmission
	 * @return string A string of bytes
	 */
	public function serialise() {
		$this->len = strlen($this->hostname);
		$frame = pack("ccc", $this->type, $this->len, $this->protocol);
		$frame .= pack_chars($this->hostname);
		return $frame;
	}
	
	/**
	 * Deserialise a sequence of bytes into frame
	 * @param string $bytes The serialised bytes
	 * @return SpringDvs\FrameRegister Filled out frame
	 */
	public static function deserialise($bytes) {
		$v = unpack("Ctype/Clen/Cprotocol", $bytes);

		return new FrameRegister(
				$v['type'],
				$v['protocol'],
				substr($bytes, 3)
			);
	}
}
