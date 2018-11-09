<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Manufacture extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'manufacture_model' => 'manufacture'
		]);
	}


	/* List */
	public function index_get()
	{
		$model 			= $this->manufacture;
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
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('orders', 'orders', 'trim|required');
		if ($this->form_validation->run() == TRUE)
		{
			$this->manufacture->member_id = $this->post('member_id');
			$this->manufacture->name = $this->post('name');
			$this->manufacture->image = $this->post('image');
			$this->manufacture->orders = $this->post('orders');
			$this->manufacture->save();
			$response = 
			[
				'status' => 'success',
				'data' => $this->manufacture
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
				'message' => site_language('validation_error','validation error'),
				'data' => $validation_errors
			];
		}
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* View */
	public function view_get()
	{
		$this->response($this->manufacture->find($this->post('id')),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$find = $this->manufacture->find($this->post('id'));
		if(!empty($find))
		{
			$find->member_id = return_if_exists($this->post(),'member_id',$find->member_id);
			$find->name = return_if_exists($this->post(),'name',$find->name);
			$find->image = return_if_exists($this->post(),'image',$find->image);
			$find->orders = return_if_exists($this->post(),'orders',$find->orders);
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
		$find = $this->manufacture->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->manufacture->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Manufacture.php */
/* Location: ./application/modules/manufacture/controllers/Manufacture.php */