<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Kabupaten extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'kabupaten_model' => 'kabupaten'
		]);
	}
	
	/* List */
	public function index_get()
	{
		$response = 
		[
			'status' => 'success',
			'data' => $this->kabupaten->all(),
			'record_total' => $this->kabupaten->count()
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Add */
	public function add_post()
	{
		$this->form_validation->set_rules('id_prov', 'id_prov', 'trim|required');
		$this->form_validation->set_rules('nama', 'nama', 'trim|required');
		if ($this->form_validation->run() == TRUE)
		{
			$this->kabupaten->id_prov = $this->post('id_prov');
			$this->kabupaten->nama = $this->post('nama');
			$this->kabupaten->save();
			$response = $this->kabupaten;
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
		$this->response($this->kabupaten->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$find = $this->kabupaten->find($this->post('id'));
		if(!empty($find))
		{
			$find->id_prov = return_if_exists($this->post(),'id_prov',$find->id_prov);
			$find->nama = return_if_exists($this->post(),'nama',$find->nama);
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
		$find = $this->kabupaten->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_post()
	{
		$find = $this->kabupaten->withTrashed()->find($this->post('id'));
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->kabupaten->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Kabupaten.php */
/* Location: ./application/modules/kabupaten/controllers/Kabupaten.php */