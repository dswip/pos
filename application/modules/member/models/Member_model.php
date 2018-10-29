<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\SoftDeletes;
class Member_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= true;
	
	protected $table	= 'member';
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

/* End of file Member_model.php */
/* Location: ./application/modules/member/models/Member_model.php */