<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Tax extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'tax_model' => 'tax'
		]);
	}
	
	/* List */
	public function index_get()
	{
		$model 			= $this->tax;
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
		$this->form_validation->set_rules('code', 'code', 'trim|required|is_unique[tax.code]');
		$this->form_validation->set_data($this->post());
		if ($this->form_validation->run() == TRUE)
		{
			$this->tax->member_id = $this->post('member_id');
			$this->tax->name = $this->post('name');
			$this->tax->code = $this->post('code');
			$this->tax->value = $this->post('value');
			$this->tax->save();
			$response = $this->tax;
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
		$this->response($this->tax->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$find = $this->tax->find($this->post('id'));
		if(!empty($find))
		{
			$find->member_id = return_if_exists($this->post(),'member_id',$find->member_id);
			$find->name = return_if_exists($this->post(),'name',$find->name);
			$find->code = return_if_exists($this->post(),'code',$find->code);
			$find->value = return_if_exists($this->post(),'value',$find->value);
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

	//* Delete */
	public function delete_post()
	{
		$find = $this->tax->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_post()
	{
		$find = $this->tax->withTrashed()->find($this->post('id'));
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->tax->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Tax.php */
/* Location: ./application/modules/tax/controllers/Tax.php */