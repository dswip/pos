<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends Rest_api
{
	function __construct()
	{
		parent::__construct();
		$this->load->model([
			'product_model' => 'product'
		]);
	}

	/* Product List */
	public function index_get()
	{
		$model 			= $this->product;
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

	/* Add Product */
	public function add_post()
	{
		$this->form_validation->set_rules('member_id', 'member id', 'trim|required');
		$this->form_validation->set_rules('sku', 'sku', 'trim|required|integer');
		$this->form_validation->set_rules('category', 'category', 'trim|required|integer');
		$this->form_validation->set_rules('manufacture', 'manufacture', 'trim|required|integer');
		$this->form_validation->set_rules('name', 'name', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('model', 'model', 'trim|required');
		$this->form_validation->set_rules('permalink', 'permalink', 'trim|required|max_length[300]');
		$this->form_validation->set_rules('currency', 'currency', 'trim|required|max_length[25]');
		$this->form_validation->set_rules('price', 'price', 'trim|numeric');
		$this->form_validation->set_rules('publish', 'publish', 'trim|required|in_list[draft,publish]');
		$this->form_validation->set_rules('weight', 'weight', 'trim|required');
		$this->form_validation->set_rules('discount', 'discount', 'trim|required|numeric');
		$this->form_validation->set_rules('min_order', 'min_order', 'trim|required');
		$this->form_validation->set_rules('color', 'color', 'trim|required');
		$this->form_validation->set_rules('size', 'size', 'trim|required');
		$this->form_validation->set_rules('unit', 'unit', 'trim|required');
		if ($this->form_validation->run() == TRUE)
		{
			$this->product->member_id = $this->post('member_id');
			$this->product->sku = $this->post('sku');
			$this->product->category = $this->post('category');
			$this->product->manufacture = $this->post('manufacture');
			$this->product->name = $this->post('name');
			$this->product->model = $this->post('model');
			$this->product->permalink = url_title($this->post('name'));
			$this->product->currency = $this->post('currency');
			$this->product->description = $this->post('description');
			$this->product->price = $this->post('price');
			$this->product->image = $this->post('image');
			$this->product->url1 = $this->post('url1');
			$this->product->url2 = $this->post('url2');
			$this->product->url3 = $this->post('url3');
			$this->product->url4 = $this->post('url4');
			$this->product->url5 = $this->post('url5');
			$this->product->publish = $this->post('publish');
			$this->product->weight = $this->post('weight');
			$this->product->related = $this->post('related');
			$this->product->discount = $this->post('discount');
			$this->product->min_order = $this->post('min_order');
			$this->product->color = $this->post('color');
			$this->product->size = $this->post('size');
			$this->product->unit = $this->post('unit');
			$this->product->save();
			$response = 
			[
				'status' => 'success',
				'data' => $this->product
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

	/* View Product */
	public function view_get($id=null)
	{
		$find = $this->product->find($id);
		$response = 
		[
			'status' => (!empty($find))?'success':'failed',
			'data' => $find
		];
		$this->response($response,REST_Controller::HTTP_OK);
	}

	/* Update Product */
	public function update_post($id=null)
	{
		$this->product->member_id = $this->post('member_id');
			$this->product->sku = $this->post('sku');
			$this->product->category = $this->post('category');
			$this->product->manufacture = $this->post('manufacture');
			$this->product->name = $this->post('name');
			$this->product->model = $this->post('model');
			$this->product->permalink = url_title($this->post('name'));
			$this->product->currency = $this->post('currency');
			$this->product->description = $this->post('description');
			$this->product->price = $this->post('price');
			$this->product->image = $this->post('image');
			$this->product->url1 = $this->post('url1');
			$this->product->url2 = $this->post('url2');
			$this->product->url3 = $this->post('url3');
			$this->product->url4 = $this->post('url4');
			$this->product->url5 = $this->post('url5');
			$this->product->publish = $this->post('publish');
			$this->product->weight = $this->post('weight');
			$this->product->related = $this->post('related');
			$this->product->discount = $this->post('discount');
			$this->product->min_order = $this->post('min_order');
			$this->product->color = $this->post('color');
			$this->product->size = $this->post('size');
			$this->product->unit = $this->post('unit');
		$find = $this->product->find($id);
		if(!empty($find))
		{
			$find->member_id = return_if_exists($this->post(),'member_id',$find->member_id);
			$find->sku = return_if_exists($this->post(),'sku',$find->sku);
			$find->category = return_if_exists($this->post(),'category',$find->category);
			$find->manufacture = return_if_exists($this->post(),'manufacture',$find->manufacture);
			$find->name = return_if_exists($this->post(),'name',$find->name);
			$find->model = return_if_exists($this->post(),'model',$find->model);
			$find->permalink = url_title(return_if_exists($this->post(),'name',$find->permalink));
			$find->currency = return_if_exists($this->post(),'currency',$find->currency);
			$find->description = return_if_exists($this->post(),'description',$find->description);
			$find->price = return_if_exists($this->post(),'price',$find->price);
			$find->image = return_if_exists($this->post(),'image',$find->image);
			$find->url1 = return_if_exists($this->post(),'url1',$find->url1);
			$find->url2 = return_if_exists($this->post(),'url2',$find->url2);
			$find->url3 = return_if_exists($this->post(),'url3',$find->url3);
			$find->url4 = return_if_exists($this->post(),'url4',$find->url4);
			$find->url5 = return_if_exists($this->post(),'url5',$find->url5);
			$find->publish = return_if_exists($this->post(),'publish',$find->publish);
			$find->weight = return_if_exists($this->post(),'weight',$find->weight);
			$find->related = return_if_exists($this->post(),'related',$find->related);
			$find->discount = return_if_exists($this->post(),'discount',$find->discount);
			$find->min_order = return_if_exists($this->post(),'min_order',$find->min_order);
			$find->color = return_if_exists($this->post(),'color',$find->color);
			$find->size = return_if_exists($this->post(),'size',$find->size);
			$find->unit = return_if_exists($this->post(),'unit',$find->unit);
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

	/* Soft Delete Product */
	public function delete_get($id)
	{
		$find = $this->product->find($id);
		$this->response($find->delete(),REST_Controller::HTTP_OK);
	}

	/* Force Delete Product */
	public function force_delete_get()
	{
		$find = $this->product->find($id);
		$this->response($find->forceDelete(),REST_Controller::HTTP_OK);	
	}
}

/* End of file Product.php */
/* Location: ./application/modules/product/controllers/Product.php */