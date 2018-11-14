<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Units extends Rest_api
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'units_model' => 'units'
		]);
	}

	/* Units List */
	public function index_get()
	{
		$model 			= $this->unit;
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

	/* Add Units */
	public function add_post()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('code', 'code', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('description', 'description', 'trim|required');
		if ($this->form_validation->run() == TRUE)
		{
			$this->units->name = $this->post('name');
			$this->units->code = $this->post('code');
			$this->units->desc = $this->post('description');
			$this->units->save();
			$response = 
			[
				'status' => 'success',
				'data' => $this->units
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

	/* View Units */
	public function view_get($id=null)
	{
		$find = $this->units->find($id);
		$response = 
		[
			'status' => (!empty($find))?'success':'failed',
			'data' => $find
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Update Units */
	public function update_post($id=null)
	{
		$find = $this->units->find($id);
		if(!empty($find))
		{
			$find->name = return_if_exists($this->post(),'name',$find->name);
			$find->code = return_if_exists($this->post(),'code',$find->code);
			$find->desc = return_if_exists($this->post(),'description',$find->desc);
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

	/* Soft Delete Units */
	public function delete_get($id)
	{
		$find = $this->units->find($id);
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Force Delete Units */
	public function force_delete_get()
	{
		$find = $this->units->find($id);
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);	
	}
}

/* End of file Units.php */
/* Location: ./application/modules/units/controllers/Units.php */