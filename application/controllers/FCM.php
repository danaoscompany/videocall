<?php

class FCM extends CI_Controller {

	static public function sendPushNotification($title, $body, $data, $token) {
	    $url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAAH_Srtxc:APA91bHlTnIwbcleCm96MiGvQy3Bh--MNYxD8KS7P_baU23-9mFJGV_D19Y659H68a7oVq_vGIQEWl6njwgKrkPv1r1azOPFXxmhV9lA_4oa5ZJefGJUda2x5VTbVWScQ-3I6DsMjAoa';
	    $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
	    $arrayToSend = array('to' => $token,/* 'notification' => $notification,*/ 'priority'=>'high', 'data' => $data);
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    //Send the request
	    $response = curl_exec($ch);
	    //Close request
	    if ($response === FALSE) {
	    	die('FCM Send Error: ' . curl_error($ch));
	    }
	    curl_close($ch);
	    echo $response;
	}
	
	static public function send_message($token, $notificationType, $title, $body, $data) {
	  $data['type'] = "" . $notificationType;
      return FCM::sendPushNotification($title, $body, $data, $token);
    }

	static public function sendPushNotificationWithColor($title, $body, $color, $data, $token) {
	    $url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAAH_Srtxc:APA91bHlTnIwbcleCm96MiGvQy3Bh--MNYxD8KS7P_baU23-9mFJGV_D19Y659H68a7oVq_vGIQEWl6njwgKrkPv1r1azOPFXxmhV9lA_4oa5ZJefGJUda2x5VTbVWScQ-3I6DsMjAoa';
	    $notification = array('title' => $title, 'body' => $body, 'color' => $color, 'sound' => 'default', 'badge' => '1');
	    $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority'=>'high', 'data' => $data);
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    //Send the request
	    $response = curl_exec($ch);
	    //Close request
	    if ($response === FALSE) {
	    	die('FCM Send Error: ' . curl_error($ch));
	    }
	    curl_close($ch);
	}
	
	static public function send_message_with_color($token, $notificationType, $showNotification, $title, $body, $color, $data) {
	  $data['show_notification'] = $showNotification;
	  $data['notification_type'] = $notificationType;
      FCM::sendPushNotificationWithColor($title, $body, $color, $data, $token);
    }

	static public function sendPushNotificationWithoutNotification($data, $token) {
	    $url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAAH_Srtxc:APA91bHlTnIwbcleCm96MiGvQy3Bh--MNYxD8KS7P_baU23-9mFJGV_D19Y659H68a7oVq_vGIQEWl6njwgKrkPv1r1azOPFXxmhV9lA_4oa5ZJefGJUda2x5VTbVWScQ-3I6DsMjAoa';
	    $arrayToSend = array('to' => $token, 'priority'=>'high', 'data' => $data);
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    //Send the request
	    $response = curl_exec($ch);
	    //Close request
	    if ($response === FALSE) {
	    	die('FCM Send Error: ' . curl_error($ch));
	    }
	    curl_close($ch);
	}
	
	static public function send_message_without_notification($token, $notificationType, $data) {
	  $data['show_notification'] = 0;
	  $data['notification_type'] = $notificationType;
      FCM::sendPushNotificationWithoutNotification($data, $token);
    }
    
    public static function send_message_to_topic($title, $body, $data, $topic) {
    	$url = "https://fcm.googleapis.com/fcm/send";
	    $serverKey = 'AAAAZkzF8SI:APA91bFrx3OFLIXoLwWA2ovvI3j0UI8x4_yH053j7aWTWeR1O01P8FidSCr_uqE9rAlw0nuod3hWJrPrM7i-kkOMOX4H0_oD03dB9pUb1F13WDppVpiHoNO9_-uFnyIDuRXleAJrZQEl';
	    $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
	    $arrayToSend = array('to' => '/topics/' . $topic, 'notification' => $notification, 'priority'=>'high', 'data' => $data);
	    $json = json_encode($arrayToSend);
	    $headers = array();
	    $headers[] = 'Content-Type: application/json';
	    $headers[] = 'Authorization: key='. $serverKey;
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	    curl_exec($ch);
	    curl_close($ch);
    }
}
