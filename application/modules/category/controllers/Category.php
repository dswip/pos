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
		$this->response($this->category->all(),REST_Controller::HTTP_OK);	
	}


	/* Add */
	public function add_post()
	{
		$this->form_validation->set_rules('code', 'code', 'trim|required|is_unique[category.code]');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'parent_id', 'trim|required');
		$this->form_validation->set_rules('publish', 'publish', 'trim|required');
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
	public function update_post()
	{
		$find = $this->category->find($this->post('id'));	
	}

	/* Delete */
	public function delete_post()
	{
		$find = $this->category->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_post()
	{
		$find = $this->category->withTrashed()->find($this->post('id'));
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->category->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Category.php */
/* Location: ./application/modules/category/controllers/Category.php */