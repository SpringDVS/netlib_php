<?php
namespace SpringDvs;
class ParseFailure extends \Exception {
	const InvalidContentFormat = 1;
	const InvalidCommand = 2;
	const InvalidRole = 3;
	const InvalidName = 4;
	const InvalidAddress = 5;
	const InvalidService = 6;
	const InvalidState = 7;
	const InvalidProperty = 8;
	
	
	public function __construct($code = 0) {
		$message = '';
		switch($code) {
			case ParseFailure::InvalidContentFormat:
				$message = 'InvalidContentFormat'; 
				break;
			case ParseFailure::InvalidCommand:
				$message = 'InvalidCommand';
				break;
			case ParseFailure::InvalidRole:
				$message = 'InvalidRole';
				break;
			case ParseFailure::InvalidName:
				$message = 'InvalidName';
				break;
			case ParseFailure::InvalidAddress:
				$message = 'InvalidAddress';
				break;
			case ParseFailure::InvalidService:
				$message = 'InvalidSerive';
				break;
			case ParseFailure::InvalidState:
				$message = 'InvalidState';
				break;
			case ParseFailure::InvalidProperty:
				$message = 'InvalidProperty';
				break;
			default: break;
		}
		parent::__construct($message,$code);
	}
}