<?php
namespace Helpers;

use Models\BaseModel;

class RouterHelper {

	public static function balodis($request){

		$return = [];

		if (count($request) == 0){
			$baseModel = new BaseModel();
			$return['base'] = $baseModel->alive();
		} else {
			$return['request'] = $request;
		}

		return $return;
	}

}