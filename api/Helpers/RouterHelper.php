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


	public function typeStatsGet($rq){
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

		if (!isset($rq['type'])){
			return [
				'status' => 0,
				'error' => 'Type not set '
			]; 
		}

		//@to wrong as possible wrong - as indexes are generates similary works , but merged by main key... what is wrong-wrong @fix @fix @fix
		$stmt= $this->db->prepare(
			'select 
				ia.type,
				ia.apartment_id,
				ia.consumption as average_cons,
				imx.consumption as max_cons,
				imx.temp as max_temp,
				imx.flow_time as max_flow_time,
				imn.consumption as min_cons,
				imn.temp as min_temp,
				imn.flow_time as min_flow_time,
				itm.consumption as times_cons,
				itm.temp as times_temp,
				itm.flow_time as times_flow_time
				from index_average AS ia
				left join index_max as imx ON imx.id = ia.id
				left join index_min as imn ON imn.id = ia.id
				left join index_most_times as itm ON itm.id = ia.id
				left join app_user as au on au.apartment_id = ia.apartment_id
				where au.id = ?
				and ia.type = ?
				order by ia.id desc
				limit 30;
		'
		);
		$stmt->execute([$user_id, $rq['type']]);
		$item = $stmt->fetchAll();

		return [
			'data' => $item,
			'status' => 1
		];

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
			'SELECT 
				`sustainability_daily`.index , 
				DATE_FORMAT(sustainability_daily.created_at, "%Y-%m-%d") as date 
			FROM `sustainability_daily` 
			LEFT JOIN app_user ON app_user.apartment_id = sustainability_daily.apartment_id
				WHERE `app_user`.`id`=?
			ORDER BY sustainability_daily.created_at DESC 
			LIMIT 50'
		);
		$stmt->execute([$user_id]);
		$item = $stmt->fetchAll();

		return [
			'data' => $item,
			'status' => 1
		];
	}

	public function leadershipGet($rq){
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
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Leader Board using HTML CSS and Javascript</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="wrapper">
	<div class="lboard_section">
		<div class="lboard_tabs">
			<div class="tabs">
				<ul>
					<li data-li="today">Today</li>
					<li class="active" data-li="month">Month</li>
					<li data-li="year">Year</li>
				</ul>
			</div>
		</div>

		<div class="lboard_wrap">
			<div class="lboard_item today" style="display: none;">
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_1.png" alt="picture_1">
					</div>
					<div class="name_bar">
						<p><span>1.</span> Charles John</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 95%"></div>
						</div>
					</div>
					<div class="points">
						195 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_2.png" alt="picture_2">
					</div>
					<div class="name_bar">
						<p><span>2.</span>Alex Mike</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 80%"></div>
						</div>
					</div>
					<div class="points">
						185 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_3.png" alt="picture_2">
					</div>
					<div class="name_bar">
						<p><span>3.</span>Johnson</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 60%;"></div>
						</div>
					</div>
					<div class="points">
						160 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_4.png" alt="picture_1">
					</div>
					<div class="name_bar">
						<p><span>4.</span>Rosey</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 30%"></div>
						</div>
					</div>
					<div class="points">
						130 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_5.png" alt="picture_2">
					</div>
					<div class="name_bar">
						<p><span>5.</span>Scarlett Angela</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 10%"></div>
						</div>
					</div>
					<div class="points">
						110 points
					</div>
				</div>
			</div>
			<div class="lboard_item month" style="display: block;">
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_2.png" alt="picture_2">
					</div>
					<div class="name_bar">
						<p><span>1.</span> Alex Mike</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 95%"></div>
						</div>
					</div>
					<div class="points">
						1195 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_3.png" alt="picture_3">
					</div>
					<div class="name_bar">
						<p><span>2.</span>Johnson</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 80%"></div>
						</div>
					</div>
					<div class="points">
						1185 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_1.png" alt="picture_1">
					</div>
					<div class="name_bar">
						<p><span>3.</span>Charles John</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 70%;"></div>
						</div>
					</div>
					<div class="points">
						1160 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_5.png" alt="picture_5">
					</div>
					<div class="name_bar">
						<p><span>4.</span>Scarlett Angela</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 50%"></div>
						</div>
					</div>
					<div class="points">
						1130 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_4.png" alt="picture_4">
					</div>
					<div class="name_bar">
						<p><span>5.</span>Rosey</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 30%"></div>
						</div>
					</div>
					<div class="points">
						1110 points
					</div>
				</div>
			</div>
			<div class="lboard_item year" style="display: none;">
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_5.png" alt="picture_5">
					</div>
					<div class="name_bar">
						<p><span>1.</span>Scarlett Angela</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 90%"></div>
						</div>
					</div>
					<div class="points">
						2195 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_4.png" alt="picture_4">
					</div>
					<div class="name_bar">
						<p><span>2.</span>Rosey</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 85%"></div>
						</div>
					</div>
					<div class="points">
						2185 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_3.png" alt="picture_3">
					</div>
					<div class="name_bar">
						<p><span>3.</span>Johnson</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 65%;"></div>
						</div>
					</div>
					<div class="points">
						2160 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_1.png" alt="picture_1">
					</div>
					<div class="name_bar">
						<p><span>4.</span>Charles John</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 30%"></div>
						</div>
					</div>
					<div class="points">
						2130 points
					</div>
				</div>
				<div class="lboard_mem">
					<div class="img">
						<img src="pic_2.png" alt="picture_2">
					</div>
					<div class="name_bar">
						<p><span>5.</span>Alex Mike</p>
						<div class="bar_wrap">
							<div class="inner_bar" style="width: 10%"></div>
						</div>
					</div>
					<div class="points">
						2110 points
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

<script src="scripts.js"></script>
</body>
</html>
<?php


	}
}