<?php

spl_autoload_register(function($class_name) {
	$a = explode('\\', $class_name);
	include "../src/{$a[1]}.php";
});
