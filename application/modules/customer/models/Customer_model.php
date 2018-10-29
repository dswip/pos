<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= true;
	
	protected $table	= 'customer';
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

/* End of file Customer_model.php */
/* Location: ./application/modules/customer/models/Customer_model.php */