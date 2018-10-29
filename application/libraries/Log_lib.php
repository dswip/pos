<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_lib extends Custom_model {

    public function __construct($deleted=NULL)
    {
        // Do something with $params
        $this->deleted = $deleted;
        $this->tableName = 'log';
    }

    public function max_log()
    {
        $this->db->select_max('id');
        $val = $this->db->get($this->tableName)->row_array();
        $val = $val['id'];
        return $val;
    }

    public function insert($userid=null, $date=null, $time=null, $activity=null, $com=0, $desc='')
    {
        $logs = array('userid' => $userid, 'date' => $date, 'time' => $time, 'activity' => $activity, 'component_id' => $com,
                      'description' => $desc);
        $this->db->insert($this->tableName, $logs);
    }
}

/* End of file Property.php */