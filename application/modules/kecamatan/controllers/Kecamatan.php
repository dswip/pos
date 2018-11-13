<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Kecamatan extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'kecamatan_model' => 'kecamatan'
		]);
	}
	
	/* List */
	public function index_get()
	{
		$model 			= $this->kecamatan;
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
}

/* End of file Kecamatan.php */
/* Location: ./application/modules/kecamatan/controllers/Kecamatan.php */