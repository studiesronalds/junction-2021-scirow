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
		if (!isset($rq['access_key'])){
			return [
				'status' => 0,
				'error' => 'Access Key not provided'
			]; 
		}

		$stmt= $this->db->prepare(
			"
				SELECT `apartment`.* 
				FROM `apartment` 
				LEFT JOIN app_user ON app_user.apartment_id = apartment.id
				WHERE `app_user`.`access_key`=?
			"
		);
		$stmt->execute([$rq['access_key']]);
		$item = $stmt->fetchAll();

		if (count($item) > 0){
			return ['data' => $item[0]];
		}
	}

	public function statsGet($rq){
		if (!isset($rq['token'])){
			return [
				'status' => 0,
				'error' => 'User not authenticated'
			]; 
		}

		// TODO properly authenticate user
		$user_id;
		if($rq['token'] == 'vdfvdd8n372xfgenixugesxdnwehjsdbw') $user_id = 1;

		if (!isset($user_id)){
			return [
				'status' => 0,
				'error' => 'User not authenticated'
			]; 
		}

		$stmt= $this->db->prepare(
			"SELECT `sustainability_daily`.* 
				FROM `sustainability_daily` 
			LEFT JOIN app_user ON app_user.apartment_id = sustainability_daily.apartment_id
				WHERE `app_user`.`id`=?"
		);
		$stmt->execute([$user_id]);
		$item = $stmt->fetchAll();


		$data = [];
		// live sustainability index
		$data['index'] = 25;
		// last 30 days sustaimability index canculations
		$data['index'] = ['2021-11-19' => ['index' => 80], '2021-11-18' => ['index' => 70], '2021-11-17' => ['index' => 50], '2021-11-16' => ['index' => 50], '2021-11-15' => ['index' => 10]];

		return ['data' => $data];
	}
}