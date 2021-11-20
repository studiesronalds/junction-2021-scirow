<?php
namespace Helpers;

use Models\BaseModel;
use Helpers\DatabaseHelper;

class RouterHelper {

	private static $instance;

	public static function balodis($request, $requestMethod){

		$return = [];

		if (!self::$instance){
			self::$instance = new self;
		}

		if (count($request) == 0){
			$baseModel = new BaseModel();
			$return['base'] = $baseModel->alive();
		} else {
			$return['request'] = $request;
			$return['routeMethod'] = $request['route'].ucfirst(strtolower($requestMethod));

			if (isset($request['route']) && method_exists(self::$instance, $return['routeMethod'])){
				$return = self::$instance->{$return['routeMethod']}($request);
			}
		}

		if (!is_array($return)){
			$return = [
				'status' => 3,
				'error' => 'Problems with Method response'
			];
		}

		return $return;
	}

	public function __construct() {
		$this->db = DatabaseHelper::getConnection();
	}

	public function usersGet(){

		$stmt = $this->db->prepare("SELECT * FROM app_user"); 
		$stmt->execute();

		// set the resulting array to associative
		$result = $stmt->setFetchMode(\PDO::FETCH_ASSOC); 
		$resultArray = [];
		foreach(new \RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) { 
			$resultArray[] = $v;
		}

		return ['status' => 1 , 'data' => $resultArray];
	}

	public function userGet($rq){
		if (!isset($rq['id'])){
			return [
				'status' => 0,
				'error' => 'User not found'
			]; 
		}

		$stmt= $this->db->prepare("SELECT * FROM `app_user` WHERE id=?");
		$stmt->execute([$rq['id']]);

		$item = $stmt->fetchAll();

		if (count($item) > 0){
			return ['data' => $item[0]];
		}
	}

	public function apartmentsGet(){

		$stmt = $this->db->prepare("SELECT * FROM apartment"); 
		$stmt->execute();

		// set the resulting array to associative
		$result = $stmt->setFetchMode(\PDO::FETCH_ASSOC); 
		$resultArray = [];
		foreach(new \RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) { 
			$resultArray[] = $v;
		}

		return ['status' => 1 , 'data' => $resultArray];
	}

	public function apartmentGet($rq){
		if (!isset($rq['id'])){
			return [
				'status' => 0,
				'error' => 'Apartment not found'
			]; 
		}

		$stmt= $this->db->prepare("SELECT * FROM `apartment` WHERE id=?");
		$stmt->execute([$rq['id']]);
		$item = $stmt->fetchAll();

		if (count($item) > 0){
			return ['data' => $item[0]];
		}
	}

	public function userApartmentGet($rq){
		if (!isset($rq['id'])){
			return [
				'status' => 0,
				'error' => 'Apartment not found'
			]; 
		}

		$stmt= $this->db->prepare(
			"
			SELECT `apartment`* 
			FROM `apartment` 
			LEFT JOIN 
			WHERE `apartment`.`id`=?"
		);
		$stmt->execute([$rq['id']]);
		$item = $stmt->fetchAll();

		if (count($item) > 0){
			return ['data' => $item[0]];
		}
	}

}