<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Discount extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'discount_model' => 'discount'
		]);
	}
	
	/* List */
	public function index_get()
	{
		$model 			= $this->discount;
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
		$this->form_validation->set_rules('member_id', 'member_id', 'trim|required');
		$this->form_validation->set_rules('name', 'name', 'trim');
		$this->form_validation->set_rules('start', 'start', 'trim');
		$this->form_validation->set_rules('end', 'end', 'trim');
		$this->form_validation->set_rules('type', 'type', 'trim|required|in_list[REGULAR,PERIOD]');
		$this->form_validation->set_rules('payment_type', 'payment_type', 'trim|required|in_list[CASH,WALLET]');
		$this->form_validation->set_rules('minimum', 'minimum', 'trim|required');
		$this->form_validation->set_rules('percentage', 'percentage', 'trim|required');
		$this->form_validation->set_rules('status', 'status', 'trim|required');
		$this->form_validation->set_data($this->post());
		if ($this->form_validation->run() == TRUE)
		{
			$this->discount->member_id = $this->post('member_id');
			$this->discount->start = $this->post('start');
			$this->discount->end = $this->post('end');
			$this->discount->name = $this->post('name');
			$this->discount->type = $this->post('type');
			$this->discount->payment_type = $this->post('payment_type');
			$this->discount->minimum = $this->post('minimum');
			$this->discount->percentage = $this->post('percentage');
			$this->discount->status = $this->post('status');
			$this->discount->save();
			$response = $this->discount;
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
		$this->response($this->discount->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$find = $this->discount->find($this->post('id'));
		if(!empty($find))
		{
			$find->member_id = return_if_exists($this->post(),'member_id',$find->member_id);
			$find->start = return_if_exists($this->post(),'start',$find->start);
			$find->end = return_if_exists($this->post(),'end',$find->end);
			$find->name = return_if_exists($this->post(),'name',$find->name);
			$find->type = return_if_exists($this->post(),'type',$find->type);
			$find->payment_type = return_if_exists($this->post(),'payment_type',$find->payment_type);
			$find->minimum = return_if_exists($this->post(),'minimum',$find->minimum);
			$find->percentage = return_if_exists($this->post(),'percentage',$find->percentage);
			$find->status = return_if_exists($this->post(),'status',$find->status);
			$find->save();
			$response = 
			[
				'status' => 'success',
				'data' => $find
			];			
		}
		else
		{
			$response = 
			[
				'status' => 'failed',
				'message_code' => 'data_not_found',
				'message' => site_language('data_not_found','data not found')
			];
		}
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Delete */
	public function delete_post()
	{
		$find = $this->discount->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_post()
	{
		$find = $this->discount->withTrashed()->find($this->post('id'));
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->discount->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Discount.php */
/* Location: ./application/modules/discount/controllers/Discount.php */