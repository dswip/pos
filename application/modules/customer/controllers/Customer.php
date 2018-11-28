<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'customer_model' => 'customer'
		]);
	}

	/* List */
	public function index_get()
	{
		$model 			= $this->customer;
		$record_total	= $model->count();
		$query 			= $this->input->get();
		if(filter_var(return_if_exists($query,'ajax',false),FILTER_VALIDATE_BOOLEAN))
		{
			$limit 		= (isset($query['length']) && $query['length'] != -1)?$query['length'] : $model::count();
			$offset 	= (isset($query['start']))? $query['start'] : 0;
			$model 		= datatable_query($model,$query);
			$get_data 	= $model->limit($limit)->offset($offset)->get();
		}
		else
		{
			$get_data 	= (isset($query['in_trash']))?$model->onlyTrashed()->get():$model->get();
		}
		
		
		$response 				= 
		[
			'draw'				=> (isset($query['draw']))?$query['draw']:false,
			'record_total'		=> $record_total,
			'record_filtered'	=> $record_total,
			'data' 				=> $get_data
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Add */
	public function add_post()
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
		$this->form_validation->set_rules('status', 'status', 'trim|required|integer');
		$this->form_validation->set_data($this->post());

		if ($this->form_validation->run() == TRUE)
		{
			$this->customer->member_id = $this->post('member_id');
			$this->customer->first_name = $this->post('first_name');
			$this->customer->last_name = $this->post('last_name');
			$this->customer->type = $this->post('type');
			$this->customer->address = $this->post('address');
			$this->customer->shipping_address = $this->post('shipping_address');
			$this->customer->phone1 = $this->post('phone1');
			$this->customer->phone2= $this->post('phone2');
			$this->customer->fax = $this->post('fax');
			$this->customer->email = $this->post('email');
			$this->customer->password = $this->post('password');
			$this->customer->website = $this->post('website');
			$this->customer->state = $this->post('state');
			$this->customer->city = $this->post('city');
			$this->customer->region = $this->post('region');
			$this->customer->zip = $this->post('zip');
			$this->customer->notes = $this->post('notes');
			$this->customer->image = $this->post('image');
			$this->customer->joined = nice_date(unix_to_human(time()),'Y-m-d H:is');
			$this->customer->status = $this->post('status');
			$this->customer->save();
			$response = 
			[
				'status' => 'success',
				'data' => $this->customer
			];
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

	/* View */
	public function view_get($id=null)
	{
		$find = $this->customer->find($id);
		$response = (!empty($find))?['status' => 'success','data' => $find]:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$this->form_validation->set_rules('member_id', 'member id', 'trim|required|integer');
		$this->form_validation->set_rules('first_name', 'first name', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
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
		$this->form_validation->set_rules('status', 'status', 'trim|required|integer');
		$this->form_validation->set_data($this->post());
		if($this->form_validation->run() == TRUE)
		{
			$find = $this->customer->find($id);
			if(!empty($find))
			{
				$find->member_id = return_if_exists($this->post(),'member_id',$find->member_id);
				$find->first_name = return_if_exists($this->post(),'first_name',$find->first_name);
				$find->last_name = return_if_exists($this->post(),'last_name',$find->last_name);
				$find->type = return_if_exists($this->post(),'type',$find->type);
				$find->address = return_if_exists($this->post(),'address',$find->address);
				$find->shipping_address = return_if_exists($this->post(),'shipping_address',$find->shipping_address);
				$find->phone1 = return_if_exists($this->post(),'phone1',$find->phone1);
				$find->phone2 = return_if_exists($this->post(),'phone2',$find->phone2);
				$find->fax = return_if_exists($this->post(),'fax',$find->fax);
				$find->email = return_if_exists($this->post(),'email',$find->email);
				$find->password = return_if_exists($this->post(),'password',$find->password);
				$find->website = return_if_exists($this->post(),'website',$find->website);
				$find->state = return_if_exists($this->post(),'state',$find->state);
				$find->city = return_if_exists($this->post(),'city',$find->city);
				$find->region = return_if_exists($this->post(),'region,$find->region');
				$find->zip = return_if_exists($this->post(),'zip',$find->zip);
				$find->notes = return_if_exists($this->post(),'notes',$find->notes);
				$find->image = return_if_exists($this->post(),'image',$find->image);
				$find->joined = return_if_exists($this->post(),'joined',$find->joined);
				$find->status = return_if_exists($this->post(),'status',$find->status);
				$find->save();
				$response = 
				[
					'status' => 'success',
					'data' => $data
				];
			}
		}
		else
		{
			$validation_errors = explode('<p>',str_replace('</p>','',validation_errors()));
			array_shift($validation_errors);
			$response = 
			[
				'status' => 'failed',
				'message_code' => 'validation_error',
				'message' => site_language('validation_error','validation error'),
				'data' => $validation_errors
			];
		}
		$this->response($response,REST_Controller::HTTP_OK);	
	}

	/* Delete */
	public function delete_get($id=null)
	{
		$find = $this->customer->find($id);
		$response = (!empty($find))?['status' => ($find->delete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_get($id=null)
	{
		$find = $this->customer->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->restore())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_get($id=null)
	{
		$find = $this->customer->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->forceDelete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}
}

/* End of file Customer.php */
/* Location: ./application/modules/customer/controllers/Customer.php */