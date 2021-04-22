<?php

include "FCM.php";

class Test extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->session->set_userdata("user_id", '123');
        //echo "Current user id: (" . $this->session->userdata('user_id') . ")";
    }
   
   	public function index() {
   	}
   	
   	public function db() {
   		echo json_encode($this->db->query("SELECT * FROM `users`")->result_array());
   	}
   	
   	public function cookie() {
   		$value = $this->input->get('value');
   		$this->session->set_userdata("user_id", $value);
   	}
   	
   	private function ip_is_private ($ip) {
    $pri_addrs = array (
                      '10.0.0.0|10.255.255.255', // single class A network
                      '172.16.0.0|172.31.255.255', // 16 contiguous class B network
                      '192.168.0.0|192.168.255.255', // 256 contiguous class C network
                      '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
                      '127.0.0.0|127.255.255.255' // localhost
                     );

    $long_ip = ip2long ($ip);
    if ($long_ip != -1) {

        foreach ($pri_addrs AS $pri_addr) {
            list ($start, $end) = explode('|', $pri_addr);

             // IF IS PRIVATE
             if ($long_ip >= ip2long ($start) && $long_ip <= ip2long ($end)) {
                 return true;
             }
        }
    }

    return false;
	}
	
	public function ip_check() {
		echo $this->ip_is_private("34.101.188.127")?"true":"false";
	}
	
	public function fcm() {
		FCM::send_message('evXJoHnXRFO0xUyyI8OhDn:APA91bE-yFIehxfoGKAMmQ8kk_2YrwiPbKY2Yrpvpkg4CpoodnEACxr5apVFUkEg6TIjjEUaokjZNmFgK6qptejJeNXUVtbFSDprUt2r4FsvouFIOCwQyjVLmGJ9bQ-yS4sTDhZ6i34_', 1, "Test title", "Test body", array());
	}
}
