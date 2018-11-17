<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/rest/REST_Controller.php';
class Rest_api extends REST_Controller
{
	protected $auth_method;

	function __construct()
	{
		parent::__construct();
		$this->authentication();
	}

	/* Authentication */
	public function authentication()
	{
		$get_token = $this->security->get_token();
		if(!empty($get_token))
		{
			try
			{
				$this->security->jwt_decode($get_token);
			}
			catch (Exception $e)
			{
				header('content-type:application/json');
				exit(json_encode(['status' => 'failed','message_code' => 'invalid_token','message' => $e->getMessage()]));			
			}
		}
		else
		{
			// header('content-type:application/json');
			// exit(json_encode(['status' => 'failed','message_code' => 'authentication_required','message' => 'authentication required']));
		}
	}
}

/* End of file Rest_api.php */
/* Location: ./application/core/Rest_api.php */
