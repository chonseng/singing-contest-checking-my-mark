<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MarksController extends AppController {
	public function beforeFilter() {

		if ($this->request->action != "login") {
			// var_dump($this->Session->read("user_is_logged"));
			if (!$this->Session->read("singer_is_logged")) {
				$this->redirect("/marks/login");
			}
		}
	}

	public function login() {
		


		if ($this->request->is('post')) {
			$this->loadModel("Singer");

			$password = $this->request->data("Singer.password");
			$singer = $this->Singer->findByPassword($password);

			if (count($singer) > 0) {
				$this->Session->write("singer_is_logged", true);
				$_SESSION["password"] = $password;
				// $_SESSION["singer_id"] = $singer["Singer"]["id"];
				$this->redirect("/");
			}
			else {
				$this->Session->setFlash(__('登入失敗'), 'default', array ('class' => 'alert-box alert'));
				$this->redirect("/marks/login");
			}
		}
	}
	

	public function asdf() {
		// for ($i=0; $i < 215; $i++) { 
		// 	$this->loadModel("User");
		// 	$is_repeated = false;
		// 	do {
		// 		$random = rand(100000,999999);
		// 		$user = $this->User->findByUsername($random);
		// 		if (count($user)>0) $is_repeated = true;
		// 	}while ($is_repeated);
		// 	$this->User->query("INSERT INTO users(`username`) VALUES ($random)");		
		// }

		// $this->loadModel("Singer");
		// $this->loadModel("User");
		
		// $marks = $this->Mark->findAllByUserId($_SESSION["user_id"]);
		// $_SESSION["is_voted"] = false;
		// if (count($marks)>0) {
		// 	$_SESSION["is_voted"] = true;
		// 	$voted_singer = $this->Singer->findBySingerId($marks[0]["Vote"]["singer_id"]);
		// 	$this->set("voted_singer",$voted_singer);
		// }
		// else {
		// 	$singers = $this->Singer->find("all",array("order"=>"singer_id"));
		// 	$this->set("singers",$singers);
			
		// }

		$this->loadModel("Singer");
		$singer = $this->Singer->findById($_SESSION["singer_id"]);
		$this->set("singer",$singer);
	}

	public function notfound() {

	}

	public function index() {

		$this->loadModel("Singer");
		$singer = $this->Singer->findByPassword($_SESSION["password"]);

		if (count($singer)==0) 
			$this->redirect("/marks/notfound");

		$_SESSION["singer_id"] = $singer["Singer"]["id"];
		$allmarks = $this->Mark->findAllBySingerId($_SESSION["singer_id"]);
		
		if (count($allmarks)>0)
			$type = $allmarks[0]["Mark"]["type"];
		else 
			$type = 0;
		

		$this->set("marks",$allmarks);

		$this->loadModel("User");
		$users_amount = count($this->User->find("all"));
		$this->set("users_amount",$users_amount);


		$all_marks = $this->Mark->findAllByType(intval($type), array(), array('Mark.singer_id' => 'asc'));

		if (count($all_marks)==0) $type="未有紀錄";
		else {
			if ($type==0) $type="獨唱";
			else if ($type==1) $type="合唱";
		}
		// echo "<pre>";
		// var_dump($all_marks);
		// exit;

		// var_dump(isset($all_marks[0]["Mark"]["skill"]));
		$marks = array();
		foreach ($all_marks as $key => $mark) {
			$marks[$mark["Mark"]["singer_id"]]["singer_id"] = $mark["Mark"]["singer_id"];
			
			if (!isset($marks[$mark["Mark"]["singer_id"]]["overall"])) $marks[$mark["Mark"]["singer_id"]]["overall"] = $mark["Mark"]["overall"];
			else $marks[$mark["Mark"]["singer_id"]]["overall"] += $mark["Mark"]["overall"];

		}

		function cmp($a, $b)
		{	
			if ($a["overall"] == $b["overall"]) {
		        return 0;
		    }
		    return ($a["overall"]> $b["overall"]) ? -1 : 1;
		}

		usort($marks, "cmp");

		$rank_count = 0;
		$same = 1;
		$rank = "未有名次";
		$previous = -1;
		// echo "<pre>";
		// var_dump($marks);
		foreach ($marks as $key => $mark) {
			if ($previous != $mark["overall"]) {
				$rank_count+=$same;
				$same = 1;
				$previous = $mark["overall"];
			}
			else {
				$same++;
			}
			if ($mark["singer_id"]==$_SESSION["singer_id"]) $rank = $rank_count;
		}
		// var_dump($rank);
		// exit;
		$gettoday = getdate();
		$today = $gettoday["year"]."年".$gettoday["mon"]."月".$gettoday["mday"]."日 ".$gettoday["hours"].":".$gettoday["minutes"].":".$gettoday["seconds"];


		$this->set("today",$today);
		$this->set("rank",$rank);
		$this->set("type",$type);

		$this->loadModel("User");
		$users_amount = count($this->User->find("all"));
		$this->set("users_amount",$users_amount);



	}

	public function add() {

		if ($this->request->is('post')) {
			// $data = $this->request->data["Activity"]["description"];
			// $this->request->data["Activity"]["description"] = $this->process_data($data);
			// var_dump($this->request->data);
			// exit;
			// $ip = $_SERVER['REMOTE_ADDR'];

			$is_correct = true;
			
			// if ($this->request->data["Mark"]["skill"]<=0 || $this->request->data["Mark"]["skill"]>10) $is_correct = false;
			// if ($this->request->data["Mark"]["interpretation"]<=0 || $this->request->data["Mark"]["interpretation"]>10) $is_correct = false;
			// if ($this->request->data["Mark"]["style"]<=0 || $this->request->data["Mark"]["style"]>10) $is_correct = false;
			// if ($this->request->data["Mark"]["creativity"]<=0 || $this->request->data["Mark"]["creativity"]>10) $is_correct = false;

			if ($is_correct) {
				$existing = $this->Mark->findBySingerIdAndUserId($this->request->data["Mark"]["singer_id"],$_SESSION["user_id"]);

				if ($existing) {
					$this->request->data["Mark"]["id"] = $existing["Mark"]["id"];
				}

				$this->Mark->create();
				$this->request->data["Mark"]["created_at"] = date('Y-m-d H:i:s');
				$this->request->data["Mark"]["user_id"] = $_SESSION["user_id"];
				$mydata = $this->request->data["Mark"];

				// $marking_percent = array(
				// 	"skill" => 1,
				// 	"interpretation" => 1,
				// 	"style" => 1,
				// 	"creativity" => 1
				// );

				$this->request->data["Mark"]["overall"] = $mydata["skill"] + $mydata["interpretation"] + $mydata["style"] + $mydata["creativity"];
				// var_dump($this->request->data);
				


				
				if ($this->Mark->save($this->request->data)) {
					$this->Session->setFlash(__('評分成功 (參賽者編號：'.$this->request->data["Mark"]["singer_id"]."，總分：".$this->request->data["Mark"]["overall"].")"), 'default', array ('class' => 'alert-box success'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('評分失敗，請重新嘗試'), 'default', array ('class' => 'alert-box alert'));
				}
			}
			else {
				$this->Session->setFlash(__('評分失敗，分數輸入錯誤'), 'default', array ('class' => 'alert-box alert'));
			}
			
		}
		
	}

	public function logout() {
		$this->Session->write("singer_is_logged", false);
		$this->redirect("/");
	}

}
