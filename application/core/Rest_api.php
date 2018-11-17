<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/rest/REST_Controller.php';
class Rest_api extends REST_Controller
{
	protected $auth_method;

	function __construct()
	{
		parent::__construct();
		$this->autentication();
	}

	/* Authentication */
	public function autentication()
	{
		$get_token = $this->security->get_token();
		if(!empty($get_token))
		{

		}
		else
		{
			// header('content-type:application/json');
			// exit(json_encode(['status' => 'failed','message_code' => 'authenication_required','message' => 'authentication required']));
		}
	}
}

/* End of file Rest_api.php */
/* Location: ./application/core/Rest_api.php */
