<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Stock_ledger extends Rest_api
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
		$model 			= $this->stock_ledger;
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
		$this->form_validation->set_rules('dates', 'dates', 'trim|required');
		$this->form_validation->set_rules('code', 'code', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('currency', 'currency', 'trim|required|max_length[15]');
		$this->form_validation->set_rules('branch_id', 'branch id', 'trim|required|integer');
		$this->form_validation->set_rules('product_id', 'product id', 'trim|required|integer|max_length[9]');
		$this->form_validation->set_rules('debit', 'debit', 'trim|required|integer|max_length[6]');
		$this->form_validation->set_rules('credit', 'credit', 'trim|required|integer|max_length[6]');
		$this->form_validation->set_rules('price', 'price', 'trim|required|numeric');
		$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric');

		if ($this->form_validation->run() == TRUE)
		{
			$this->stock_ledger->dates = $this->post('dates');
			$this->stock_ledger->code = $this->post('code');
			$this->stock_ledger->currency = $this->post('currency');
			$this->stock_ledger->branch_id = $this->post('branch_id');
			$this->stock_ledger->product_id = $this->post('product_id');
			$this->stock_ledger->debit = $this->post('debit');
			$this->stock_ledger->credit = $this->post('credit');
			$this->stock_ledger->price = $this->post('price');
			$this->stock_ledger->amount = $this->post('amount');
			$this->stock_ledger->save();
			$response = $this->stock_ledger;
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
		$this->response($this->stock_ledger->find($id),REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post($id=null)
	{
		$find = $this->stock_ledger->find($id);
		if(!empty($find))
		{
			$find->dates = return_if_exists($this->post(),'dates',$find->dates);
			$find->code = return_if_exists($this->post(),'code',$find->code);
			$find->currency = return_if_exists($this->post(),'currency',$find->currency);
			$find->branch_id = return_if_exists($this->post(),'branch_id',$find->branch_id);
			$find->product_id = return_if_exists($this->post(),'product_id',$find->product_id);
			$find->debit = return_if_exists($this->post(),'debit',$find->debit);
			$find->credit = return_if_exists($this->post(),'credit',$find->credit);
			$find->price = return_if_exists($this->post(),'price',$find->price);
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
		$find = $this->stock_ledger->find($id);
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_get($id=null)
	{
		$find = $this->stock_ledger->withTrashed()->find($id);
		$this->response($find->restore(),REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_get($id=null)
	{
		$find = $this->stock_ledger->withTrashed()->find($id);
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);
	}
}

/* End of file Stock_ledger.php */
/* Location: ./application/modules/stock/controllers/Stock_ledger.php */