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
		$this->form_validation->set_rules('member_id', 'member id', 'trim|required|integer');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[customer.email]',['is_unique' => 'email has been used']);
		$this->form_validation->set_rules('type','trim|required|in_list[customer,member]');
		$this->form_validation->set_rules('address', 'address', 'trim|required');
		$this->form_validation->set_rules('shipping_address', 'shipping_address', 'trim|required');
		$this->form_validation->set_rules('phone1', 'phone1', 'trim|required');
		$this->form_validation->set_rules('phone2', 'phone2', 'trim|required');
		$this->form_validation->set_rules('fax', 'fax', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_rules('website', 'website', 'trim|required');
		$this->form_validation->set_rules('state', 'state', 'trim|required');
		$this->form_validation->set_rules('city', 'city', 'trim|required');
		$this->form_validation->set_rules('region', 'region', 'trim|required');
		$this->form_validation->set_rules('zip', 'zip', 'trim|required');
		$this->form_validation->set_rules('notes', 'notes', 'trim|required');
		$this->form_validation->set_rules('image', 'image', 'trim|required');
		$this->form_validation->set_rules('status', 'status', 'trim|required|integer');
		$this->form_validation->set_data($this->post());

		if ($this->form_validation->run() == TRUE)
		{
			$this->member->first_name = $this->post('first_name');
			$this->member->last_name = $this->post('last_name');
			$this->member->type = $this->post('type');
			$this->member->address = $this->post('address');
			$this->member->shipping_address = $this->post('shipping_address');
			$this->member->phone1 = $this->post('phone1');
			$this->member->phone2= $this->post('phone2');
			$this->member->fax = $this->post('fax');
			$this->member->email = $this->post('email');
			$this->member->password = $this->post('password');
			$this->member->website = $this->post('website');
			$this->member->state = $this->post('state');
			$this->member->city = $this->post('city');
			$this->member->region = $this->post('region');
			$this->member->zip = $this->post('zip');
			$this->member->notes = $this->post('notes');
			$this->member->image = $this->post('image');
			$this->member->joined = nice_date(unix_to_human(time()),'Y-m-d H:is');
			$this->member->status = $this->post('status');
			$this->member->save();
			$response = $this->member;
		}
		else
		{
			$validation_errors = explode('<p>',str_replace('</p>','',validation_errors()));
			array_shift($validation_errors);
			$response = 
			[
				'status' => 'failed',
				'message_code' => 'validation_error',
				'message' => 'validation errror',
				'data' => $validation_errors
			];
		}
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* View Member */
	public function view_get($id=null)
	{
		$find_member = $this->member->find($id);
		$response = 
		[
			'status' => (!empty($find_member))?'success':'failed',
			'data' => $find_member
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Update Member */
	public function update_post($id=null)
	{
		$find_member = $this->member->find($id);
		// $find_member->update->
	}

	/* Delete Member */
	public function delete_post()
	{
		$find_member = $this->member->find($id);
		$delete = (!empty($find_member))?$find_member->delete():false;
		$response = 
		[
			'status' => ($delete)?'success':'failed',
			'message_code' => ($delete)?null:'unable to find data'
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_post()
	{
		$find = $this->member->withTrashed()->find($this->post('id'));
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find_member = $this->member->find($id);
		$delete = (!empty($find_member))?$find_member->force_delete():false;
		$response = 
		[
			'status' => ($delete)?'success':'failed',
			'message_code' => ($delete)?null:'unable to find data'
		];
		$this->response($response,REST_Controller::HTTP_OK);	
	}
}

/* End of file Member.php */
/* Location: ./application/modules/member/controllers/Member.php */