<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Business_category_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= false;
	
	protected $table	= 'business_category';
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

/* End of file Business_category_model.php */
/* Location: ./application/modules/business_category/models/Business_category_model.php */