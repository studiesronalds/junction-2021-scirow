<?php
namespace Helpers;

class DatabaseHelper {

	private static $connection = false;

	public static function init($connection){
		self::$connection = $connection;
	}

	public static function getConnection(){
		return self::$connection;
	}

}