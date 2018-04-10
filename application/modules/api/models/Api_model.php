<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

	function __construct(){

		parent::__construct();
	}

	public function getFields($table) {

		return $this->db->list_fields($table);
	}

	public function authentication($key) {

		$settings = settings();
		if($settings['api_status'] == 'enable') {
			if($key == $settings['api_key']) {
				$token =  time().generateRandomNumber('50', TRUE);
				if($this->db->insert('api_token', array('token' => $token))) {
					return $token;
				}
			} else {
				return 'error';
			}
		} else {
			return 'disabled';
		}
	}

	public function verify_token($token) {
		$result = 'INVALID_TOKEN';
		$settings = settings();
		$t_expiration = $settings['token_expiration'];
		$res = $this->db->where('token', $token)
		                ->where('activity_date >= DATE_FORMAT(NOW() - INTERVAL '.$t_expiration.' MINUTE, "%Y-%m-%d %H:%i:%s") ')
		                ->get('api_token')
		                ->row();
		//echo '<pre>'; print_r($res); die;
		if(!empty($res)) {
			$this->db->where('id', $res->id)
					 ->set('activity_date', 'NOW()', FALSE )
			         ->update('api_token');
			$result =  TRUE;
		}

		return $result;
	}


	public function getModule() {
		return $this->db->select('data')->where('user_type', 'admin')->get('permission')->row();
	}
}