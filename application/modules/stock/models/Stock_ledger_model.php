<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\SoftDeletes;
class Stock_ledger_model extends Eloquent_model
{
	use SoftDeletes;
	public $timestamps	= false;
	
	protected $table	= 'stock_ledger';
	protected $guarded	= [];
	protected $hidden 	= [];
	protected $fillable = 
	[

	];
	protected $connection = ENVIRONMENT;
}

/* End of file Stock_ledger_model.php */
/* Location: ./application/modules/stock/models/Stock_ledger_model.php */