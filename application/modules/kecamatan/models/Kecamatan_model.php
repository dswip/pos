<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Kecamatan_model extends Eloquent_model
{
	public $timestamps	= false;
	
	protected $table	= 'kecamatan';
	protected $guarded	= [];
	protected $hidden 	= [];
	protected $fillable = 
	[

	];
	protected $connection = ENVIRONMENT;
}

/* End of file Kecamatan_model.php */
/* Location: ./application/modules/kecamatan/models/Kecamatan_model.php */