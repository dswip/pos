<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Illuminate\Database\Eloquent\Model;
class Eloquent_model extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	/* Set Model Connection */
	public function activateGroup($connection)
	{
		$this->connection = $connection;
	}
}

/* End of file Eloquent_model.php */
/* Location: ./application/core/Eloquent_model.php */