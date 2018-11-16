<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'category_model' => 'category'
		]);
	}

	/* List */
	public function index_get()
	{
		$model 			= $this->category;
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
		$this->form_validation->set_rules('code', 'code', 'trim|required|is_unique[category.code]');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'parent_id', 'trim|required');
		$this->form_validation->set_rules('publish', 'publish', 'trim|required');
		$this->form_validation->set_data($this->post());
		if($this->form_validation->run() == TRUE)
		{
			$this->category->code = $this->post('code');
			$this->category->name = $this->post('name');
			$this->category->publish = $this->post('publish');
			$this->category->image = $this->post('image');
			$this->category->save();
			$response = $this->category;
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
		$this->response($this->category->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post($id=null)
	{
		$this->form_validation->set_rules('code', 'code', 'trim|required|is_unique[category.code]');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'parent_id', 'trim|required');
		$this->form_validation->set_rules('publish', 'publish', 'trim|required');
		$this->form_validation->set_data($this->post());
		if($this->form_validation->run() == TRUE)
		{
			$find = $this->category->find($id);
			$find->code = $this->post('code');
			$find->name = $this->post('name');
			$find->publish = $this->post('publish');
			$find->image = $this->post('image');
			$find->save();
			$response = 
			[
				'status' => 'success'
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
	}

	/* Delete */
	public function delete_post($id=null)
	{
		$find = $this->category->find($id);
		$response = (!empty($find))?['status' => ($find->delete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_get($id=null)
	{
		$find = $this->category->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->restore())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_get($id=null)
	{
		$find = $this->category->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->forceDelete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}
}

/* End of file Category.php */
/* Location: ./application/modules/category/controllers/Category.php */