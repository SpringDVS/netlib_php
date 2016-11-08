<?php

namespace SpringDvs;

/**
 * Interface for format objects that provide
 * relevent network interface details
 */
interface INodeNetInterface {
	public function spring();
	public function host();
	public function address();
	public function service();
}
