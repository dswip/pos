<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Stock extends Rest_api
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'stock_model' => 'stock',
			'stock_balance_model' => 'stock_balance',
			'stock_ledger_model' => 'stock_ledger'
		]);
	}

	/* List */
	public function index_get()
	{
		$model 			= $this->stock;
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
		$this->form_validation->set_rules('product_id', 'product id', 'trim|required|integer');
		$this->form_validation->set_rules('dates', 'dates', 'trim|required');
		$this->form_validation->set_rules('qty', 'qty', 'trim|required|integer');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
		{
			$this->stock->product_id = $this->post('product_id');
			$this->stock->dates = $this->post('dates');
			$this->stock->qty = $this->post('qty');
			$this->stock->amount = $this->post('amount');
			$this->stock->save();
			$response = $this->stock;
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
		$find = $this->stock->find($id);
		$response = (!empty($find))?['status' => 'success','data' => $find]:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post($id=null)
	{
		$find = $this->stock->find($id);
		if(!empty($find))
		{
			$find->product_id = return_if_exists($this->post(),'product_id',$find->product_id);
			$find->dates = return_if_exists($this->post(),'dates',$find->dates);
			$find->qty = return_if_exists($this->post(),'qty',$find->qty);
			$find->amount = return_if_exists($this->post(),'amount',$find->amount);
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
	public function delete_get($id=null)
	{
		$find = $this->stock->find($id);
		$response = (!empty($find))?['status' => ($find->delete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_get($id=null)
	{
		$find = $this->stock->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->restore())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_get($id=null)
	{
		$find = $this->stock->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->forceDelete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}
}

/* End of file Stock.php */
/* Location: ./application/modules/stock/controllers/Stock.php */