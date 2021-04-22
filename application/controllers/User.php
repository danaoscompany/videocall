<?php

include "FCM.php";
include "Util.php";

class User extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $sessionUserID = $this->input->post('_session_user_id');
        $sessionDate = $this->input->post('_session_date');
        //$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $sessionDate . "' WHERE `id`=" . $sessionUserID);
    }
	
	public function login() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$users = $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "' AND `password`='" . $password . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$user['response_code'] = 1;
			echo json_encode($user);
			$this->db->query("UPDATE `users` SET `online`=1, `last_online_date`='" . $this->input->post('_session_date') . "' WHERE `id`=" . $user['id']);
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
	
	public function update_user_location() {
		$userID = intval($this->input->post('user_id'));
		$latitude = doubleval($this->input->post('latitude'));
		$longitude = doubleval($this->input->post('longitude'));
		$this->db->query("UPDATE `users` SET `latitude`=" . $latitude . ", `longitude`=" . $longitude. " WHERE `id`=" . $userID);
	}
	
	public function update_fcm_id() {
		$userID = intval($this->input->post('user_id'));
		$fcmID = $this->input->post('fcm_id');
		$this->db->query("UPDATE `users` SET `fcm_id`='" . $fcmID . "' WHERE `id`=" . $userID);
	}
	
	public function find_opponent() {
		$userID = intval($this->input->post('user_id'));
		$videoUUID = Util::generateUUIDv4();
		$this->db->query("UPDATE `users` SET `busy`=1, `video_uuid`='" . $videoUUID . "' WHERE `id`=" . $userID);
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`!=" . $userID . " AND `busy`=0 ORDER BY RAND() LIMIT 1")->row_array();
		$this->db->query("UPDATE `users` SET `video_uuid`='" . $videoUUID . "' WHERE `id`=" . $user['id']);
		$fcmID = $user['fcm_id'];
		FCM::send_message($fcmID, 1, "Anda mendapatkan pasangan baru", "Klik untuk menghubungkan", array(
			'user_id' => $userID,
			'video_uuid' => $videoUUID
		));
		echo json_encode($user);
	}
	
	public function get_topics() {
		$date = $this->input->post('date');
		$topics = $this->db->query("SELECT * FROM `topics` WHERE `date`<='" . $date . "' ORDER BY `date` DESC LIMIT 10")->result_array();
		echo json_encode($topics);
	}
	
	public function find_nearest_partners() {
		$lat = doubleval($this->input->post('lat'));
		$lng = doubleval($this->input->post('lng'));
		$category = $this->input->post('category');
		$userID = intval($this->input->post('user_id'));
		if ($category == 'all') {
			$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id`!=" . $userID . " HAVING distance < 25 ORDER BY distance;")->result_array();
		} else {
			$partners = $this->db->query("SELECT *, SQRT(POW(69.1 * (latitude - " . $lat . "), 2) + POW(69.1 * (" . $lng . " - longitude) * COS(latitude / 57.3), 2)) AS distance FROM `users` WHERE `id`!=" . $userID . " AND `gender`='" . $category . "' HAVING distance < 25 ORDER BY distance;")->result_array();
		}
		if (sizeof($partners) <= 0) {
			$partners = $this->db->query("SELECT * FROM `users` WHERE `id`!=" . $userID)->result_array();
		}
		echo json_encode($partners);
	}
	
	public function start_video_call() {
		$callerUserID = intval($this->input->post('caller_user_id'));
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		/*$this->db->query("UPDATE `users` WHERE `id`=" . $callerUserID);
		$this->db->query("UPDATE `users` WHERE `id`=" . $receiverUserID);*/
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		FCM::send_message($receiver['fcm_id'], 1, "You have incoming call", "Click to connect", array(
			'caller_user_id' => "" . $callerUserID,
			'receiver_user_id' => "" . $receiverUserID
		));
	}
	
	public function watch_live_stream() {
		$fromUserID = intval($this->input->post('from_user_id'));
		$toUserID = intval($this->input->post('to_user_id'));
		$fcmID = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $toUserID)->row_array()['fcm_id'];
		FCM::send_message($fcmID, 5, "", "", array(
			'user_id' => $fromUserID
		));
	}
	
	public function update_websocket_id() {
		$webSocketID = $this->input->post('websocket_id');
		$userID = intval($this->input->post('user_id'));
		$this->db->query("UPDATE `users` SET `websocket_id`='" . $webSocketID . "' WHERE `id`=" . $userID);
	}
	
	public function get_websocket_id_by_email() {
		$email = $this->input->post('email');
		echo $this->db->query("SELECT * FROM `users` WHERE `email`='" . $email . "'")->row_array()['websocket_id'];
	}
	
	public function get_websocket_id_by_user_id() {
		$userID = $this->input->post('user_id');
		$user = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $userID)->row_array();
		if ($user != NULL) {
			echo $user['websocket_id'];
		}
	}
	
	public function request_receiver_websocket_id() {
		$callerUserID = intval($this->input->post('caller_user_id'));
		$callerWebsocketID = $this->input->post('caller_websocket_id');
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		FCM::send_message($receiver['fcm_id'], 2, "Initializing call", "", array(
			'caller_user_id' => "" . $callerUserID,
			'caller_websocket_id' => $callerWebsocketID,
			'receiver_user_id' => "" . $receiverUserID
		));
	}
	
	public function respond_receiver_websocket_id() {
		$callerUserID = intval($this->input->post('caller_user_id'));
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		$receiverWebsocketID = $this->input->post('receiver_websocket_id');
		$caller = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $callerUserID)->row_array();
		FCM::send_message($caller['fcm_id'], 3, "Initializing call", "", array(
			'caller_user_id' => "" . $callerUserID,
			'receiver_user_id' => "" . $receiverUserID,
			'websocket_id' => $receiverWebsocketID
		));
	}
	
	public function get_user_by_id() {
		$id = intval($this->input->post('id'));
		echo json_encode($this->db->query("SELECT * FROM `users` WHERE `id`=" . $id)->row_array());
	}
	
	public function send_live_video_message() {
		$senderUserID = intval($this->input->post('sender_user_id'));
		$receiverUserID = intval($this->input->post('receiver_user_id'));
		$message = $this->input->post('message');
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		$sender = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $senderUserID)->row_array();
		$receiver = $this->db->query("SELECT * FROM `users` WHERE `id`=" . $receiverUserID)->row_array();
		if ($receiver != NULL) {
			FCM::send_message($receiver['fcm_id'], 4, "New message", "", array(
				'sender_user_id' => "" . $senderUserID,
				'receiver_user_id' => "" . $receiverUserID,
				'message' => $message,
				'sender' => json_encode($sender),
				'receiver' => json_encode($receiver)
			));
		}
		echo json_encode(array(
			'sender_user_id' => $senderUserID,
			'receiver_user_id' => $receiverUserID,
			'message' => $message,
			'sender' => $sender,
			'receiver' => $receiver
		));
	}
}
