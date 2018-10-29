<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/rest/REST_Controller.php';
class Rest_api extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->autentication();
	}

	/* Authentication */
	public function autentication()
	{
		// if(!Modules::run('user/user_module/_is_logged_in'))
		// {
		// 	// Require API Key
		// }
	}
}

/* End of file Rest_api.php */
/* Location: ./application/core/Rest_api.php */
