<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Testing extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('branch/branch_model','branch');
	}

	public function index()
	{
		$this->load->view('testing');
	}
}

/* End of file Testing.php */
/* Location: ./application/controllers/Testing.php */