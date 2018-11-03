<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Kabupaten_model extends Eloquent_model
{
	public $timestamps	= false;
	
	protected $table	= 'kabupaten';
	protected $guarded	= [];
	protected $hidden 	= [];
	protected $fillable = 
	[

	];
	protected $connection = ENVIRONMENT;
}

/* End of file Kabupaten_model.php */
/* Location: ./application/modules/kabupaten/models/Kabupaten_model.php */