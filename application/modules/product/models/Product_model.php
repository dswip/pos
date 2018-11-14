<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\SoftDeletes;
class Product_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= true;
	
	protected $table	= 'product';
	protected $guarded	= [];
	protected $hidden 	= [];
	protected $fillable = 
	[

	];
	protected $connection = ENVIRONMENT;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
	const DELETED_AT = 'deleted';
}

/* End of file Product_model.php */
/* Location: ./application/modules/product/models/Product_model.php */