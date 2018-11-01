<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Bank extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'bank_model' => 'bank'
		]);
	}

	/* Add Bank */
	public function add_post()
	{
		$this->form_validation->set_rules('acc_name', 'account name', 'trim|required');
		$this->form_validation->set_rules('acc_no', 'account number', 'trim|required');
		$this->form_validation->set_rules('acc_bank', 'account bank', 'trim|required');
		$this->form_validation->set_rules('currency', 'currency', 'trim|required');
		if($this->form_validation->run() == TRUE)
		{
			$this->bank->acc_name = $this->post('acc_name');
			$this->bank->acc_no = $this->post('acc_no');
			$this->bank->acc_bank = $this->post('acc_bank');
			$this->bank->currency = $this->post('currency');
			$this->bank->save();
		}
		else
		{
			$validation_errors = explode('<p>',str_replace('</p>','',validation_errors()));
			array_shift($validation_errors);
			$response = 
			[
				'message_code' => 'validation_error',
				'message' => site_language('validation_error','validation error'),
				'data' => $validation_errors
			];
		}
	}

	/* List */
	public function list_get()
	{
		$this->response($this->bank->all(),REST_Controller::HTTP_OK);	
	}

	/* View */
	public function view_get($id=null)
	{
		$this->response($this->bank->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post()
	{
		$find = $this->bank->find($this->post('id'));	
	}

	/* Delete */
	public function delete_post()
	{
		$find = $this->bank->find($this->post('id'));
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_post()
	{
		$find = $this->bank->withTrashed()->find($this->post('id'));
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Bank.php */
/* Location: ./application/modules/bank/controllers/Bank.php */