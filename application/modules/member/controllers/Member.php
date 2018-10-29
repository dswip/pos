<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Member extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'member_model' => 'member'
		]);
	}

	/* List Member */
	public function index_get()
	{
		$response = 
		[
			'status' => 'success',
			'data' => $this->member->all(),
			'record_total' => $this->member->count()
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Create Member */
	public function create_post()
	{
		$this->member->first_name = $this->post('first_name')
	}

	/* View Member */
	public function view_get()
	{
		
	}

	/* Update Member */
	public function update_post()
	{
		
	}

	/* Delete Member */
	public function delete_post()
	{
		
	}
}

/* End of file Member.php */
/* Location: ./application/modules/member/controllers/Member.php */