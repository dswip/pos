<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\SoftDeletes;
class Bank_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= true;
	
	protected $table	= 'bank';
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

/* End of file Bank_model.php */
/* Location: ./application/modules/bank/models/Bank_model.php */