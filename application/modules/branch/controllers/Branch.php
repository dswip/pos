<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Branch extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'branch_model' => 'branch'
		]);
	}

	/* List */
	public function index_get()
	{
		$model 			= $this->branch;
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
		$this->form_validation->set_rules('member_id', 'member id', 'trim|required');
		$this->form_validation->set_rules('code', 'code', 'trim|required');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('address', 'address', 'trim|required');
		$this->form_validation->set_rules('phone', 'phone', 'trim|required');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|valid_email');
		$this->form_validation->set_rules('city', 'city', 'trim|required');
		$this->form_validation->set_rules('zip', 'zip', 'trim|required');
		$this->form_validation->set_rules('publish', 'publish', 'trim|required');
		$this->form_validation->set_rules('defaults', 'defaults', 'trim|required');
		$this->form_validation->set_rules('sales_account', 'sales_account', 'trim|required');
		$this->form_validation->set_rules('stock_account', 'stock_account', 'trim|required');
		$this->form_validation->set_rules('unit_cost_account', 'unit_cost_account', 'trim|required');
		$this->form_validation->set_rules('ar_account', 'ar_account', 'trim|required');
		$this->form_validation->set_rules('bank_account', 'bank_account', 'trim|required');
		$this->form_validation->set_rules('cash_account', 'cash_account', 'trim|required');
		if($this->form_validation->run() == TRUE)
		{
			$this->branch->member_id = $this->post('member_id');
			$this->branch->code = $this->post('code');
			$this->branch->name = $this->post('name');
			$this->branch->address = $this->post('address');
			$this->branch->phone = $this->post('phone');
			$this->branch->mobile = $this->post('mobile');
			$this->branch->email = $this->post('email');
			$this->branch->city = $this->post('city');
			$this->branch->zip = $this->post('zip');
			$this->branch->image = $this->post('image');
			$this->branch->publish = $this->post('publish');
			$this->branch->defaults = $this->post('defaults');
			$this->branch->sales_account = $this->post('sales_account');
			$this->branch->stock_account = $this->post('stock_account');
			$this->branch->cash_account = $this->post('cash_account');
			$this->branch->save();
			$response = $this->branch;
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

	/* View */
	public function view_get($id=null)
	{
		$this->response($this->branch->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$find = $this->branch->find($this->post('id'));	
	}

	/* Delete */
	public function delete_post()
	{
		$find = $this->branch->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_post()
	{
		$find = $this->branch->withTrashed()->find($this->post('id'));
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->branch->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Branch.php */
/* Location: ./application/modules/branch/controllers/Branch.php */