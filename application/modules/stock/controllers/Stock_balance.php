<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Stock_balance extends Rest_api
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
		$model 			= $this->stock_balance;
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
		$this->form_validation->set_rules('member_id', 'member id', 'trim|required');
		$this->form_validation->set_rules('branch_id', 'branch id', 'trim|required|integer|max_length[9]');
		$this->form_validation->set_rules('product_id', 'product id', 'trim|required|integer|max_length[9]');
		$this->form_validation->set_rules('month', 'month', 'trim|required|integer|max_length[2]');
		$this->form_validation->set_rules('year', 'year', 'trim|required|integer|max_length[4]');
		$this->form_validation->set_rules('open_qty', 'open qty', 'trim|required|integer|max_length[6]');
		$this->form_validation->set_rules('end_qty', 'end qty', 'trim|required|integer|max_length[6]');
		$this->form_validation->set_rules('open_balance', 'open balance', 'trim|required|numeric');
		$this->form_validation->set_rules('end_balance', 'end balance', 'trim|required|numeric');

		if ($this->form_validation->run() == TRUE)
		{
			$this->stock_balance->dates = $this->post('dates');
			$this->stock_balance->code = $this->post('code');
			$this->stock_balance->currency = $this->post('currency');
			$this->stock_balance->branch_id = $this->post('branch_id');
			$this->stock_balance->product_id = $this->post('product_id');
			$this->stock_balance->debit = $this->post('debit');
			$this->stock_balance->credit = $this->post('credit');
			$this->stock_balance->price = $this->post('price');
			$this->stock_balance->amount = $this->post('amount');
			$this->stock_balance->save();
			$response = $this->stock_balance;
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
		$find = $this->stock_balance->find($id);
		$response = (!empty($find))?['status' => 'success','data' => $find]:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Update */
	public function update_post($id=null)
	{
		$find = $this->stock_ledger->find($id);
		if(!empty($find))
		{
			$find->member_id = return_if_exists($this->post(),'member_id',$find->member_id);
			$find->branch_id = return_if_exists($this->post(),'branch_id',$find->branch_id);
			$find->product_id = return_if_exists($this->post(),'product_id',$find->product_id);
			$find->month = return_if_exists($this->post(),'month',$find->month);
			$find->year = return_if_exists($this->post(),'year',$find->year);
			$find->open_qty = return_if_exists($this->post(),'open_qty',$find->open_qty);
			$find->end_qty = return_if_exists($this->post(),'end_qty',$find->end_qty);
			$find->open_balance = return_if_exists($this->post(),'open_balance',$find->open_balance);
			$find->end_balance = return_if_exists($this->post(),'end_balance',$find->end_balance);
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
		$find = $this->stock_balance->find($id);
		$response = (!empty($find))?['status' => ($find->delete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Restore */
	public function restore_get($id=null)
	{
		$find = $this->stock_balance->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->restore())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Force Delete */
	public function force_delete_get($id=null)
	{
		$find = $this->stock_balance->withTrashed()->find($id);
		$response = (!empty($find))?['status' => ($find->forceDelete())?'success':'failed']:['status' => 'failed','message_code' => 'data_not_found','message' => 'data not found'];
		$this->response($response,REST_Controller::HTTP_OK);
	}
}

/* End of file Stock_balance.php */
/* Location: ./application/modules/stock/controllers/Stock_balance.php */