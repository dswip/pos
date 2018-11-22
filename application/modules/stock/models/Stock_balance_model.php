<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\SoftDeletes;
class Stock_balance_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= false;
	
	protected $table	= 'stock_balance';
	protected $guarded	= [];
	protected $hidden 	= [];
	protected $fillable = 
	[

	];
	protected $connection = ENVIRONMENT;
}

/* End of file Stock_balance_model.php */
/* Location: ./application/modules/stock/models/Stock_balance_model.php */