<?php defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;
class MY_Security extends CI_Security
{
	protected $jwt_key = 'gpsJWT';

	/* Encode JWT */
	public function jwt_encode(array $data)
	{
		return JWT::encode($data,$this->jwt_key);
	}

	/* Decode JWT */
	public function jwt_decode($token)
	{
		return JWT::decode($token,$this->jwt_key,array('HS256'));
	}

	/* Get User Agent */
	public function get_user_agent()
	{
		$ci =& get_instance();
		$ci->load->library('user_agent');
		if($ci->agent->is_browser())
		{
			$agent_name = $ci->agent->browser().' '.$ci->agent->version();
			$agent_type = 'browser';
		}
		elseif($ci->agent->is_robot())
		{
			$agent_name = $ci->agent->robot();
			$agent_type = 'robot';
		}
		elseif($ci->agent->is_mobile())
		{
			$agent_name = $ci->agent->mobile();
			$agent_type = 'mobile';
		}
		else
		{
			$agent_name = 'Unidentified User Agent';
			$agent_type = 'unidentified';
		}

		$get_user_agent = 
		[
			'agent' => explode(' ',$agent_name)[0],
			'agent_type' => $agent_type,
			'agent_name' => $agent_name,
			'platform' => $ci->agent->platform(),
			'agent_string' => $ci->agent->agent_string(),
			'user_agent' => $ci->input->user_agent(),
			'ip_address' => $ci->input->ip_address()
		];
		return $get_user_agent;
	}

	/* Get Device ID */
	public function get_device_id()
	{
		// Codeigniter Instance
		$ci =& get_instance();
		if(method_exists($ci,'post'))
		{
			$device_id 	= (!empty($ci->input->get_request_header('device_id')))?$ci->input->get_request_header('device_id',TRUE):$ci->post('device_id');
		}
		else
		{
			$device_id 	= (!empty($ci->input->get_request_header('device_id')))?$ci->input->get_request_header('device_id',TRUE):$ci->input->post('device_id');
		}
		return $device_id;
	}

	/* Get Token */
	public function get_token($key='token')
	{
		// Codeigniter Instance
		$ci =& get_instance();
		if(method_exists($ci,'post'))
		{
			$token 	= (!empty($ci->input->get_request_header($key)))?$ci->input->get_request_header($key,TRUE):$ci->post($key);
		}
		else
		{
			$token 	= (!empty($ci->input->get_request_header($key)))?$ci->input->get_request_header($key,TRUE):$ci->input->post($key);
		}
		return $token;
	}
}

/* End of file MY_Security.php */
/* Location: ./application/core/MY_Security.php */
