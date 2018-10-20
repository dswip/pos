<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends Custom_Model
{
    private $logs;
    
    function __construct()
    {
        parent::__construct();
        $this->logs = new Log_lib();
        $this->com = new Components();
        $this->com = $this->com->get_id('main');
    }
    
    
    protected $table = 'admin_menu';
    protected $field = array('id', 'parent_id', 'name', 'modul', 'url', 'menu_order', 'class_style', 'id_style', 
                             'icon', 'target', 'parent_status');
    protected $com;
    
    function get_last_ar_between($val1,$val2)
    {
        $this->db->select('SUM(amount) AS amount');
        $this->db->from('sales');
        $this->db->where("dates BETWEEN (NOW() - INTERVAL ".$val1." DAY) AND (NOW() - INTERVAL ".$val2." DAY) ");
        $this->db->where('confirmation', 0);
        $this->db->where('deleted', null);
        return $this->db->get(); 
    }

    function get_last_ar($val1)
    {
        $this->db->select('SUM(amount) AS amount');
        $this->db->from('sales');
        $this->db->where("dates <= (NOW() - INTERVAL ".$val1." DAY)");
        $this->db->where('confirmation', 0);
        $this->db->where('deleted', null);
        return $this->db->get();
    }

    function get_ar_list()
    {
        $this->db->select('id, dates, cust_id, amount');
        $this->db->from('sales');
//        $this->db->where('approved', 1);
//        $this->db->where('currency', 'IDR');
        $this->db->where('confirmation', 0);
        $this->db->where('deleted', null);
        return $this->db->get();
    }

    // ============== purchase ===================================

    function get_last_ap_between($val1,$val2)
    {
        $this->db->select('SUM(p2) AS total');
        $this->db->from('purchase');
        $this->db->where("dates BETWEEN (NOW() - INTERVAL ".$val1." DAY) AND (NOW() - INTERVAL ".$val2." DAY) ");
        $this->db->where('approved', 1);
        $this->db->where('currency', 'IDR');
        $this->db->where('status', 0);
        $this->db->where('deleted', null);
        return $this->db->get();
    }

    function get_last_ap($val1)
    {
        $this->db->select('SUM(p2) AS total');
        $this->db->from('purchase');
        $this->db->where("dates <= (NOW() - INTERVAL ".$val1." DAY)");
        $this->db->where('approved', 1);
        $this->db->where('currency', 'IDR');
        $this->db->where('status', 0);
        $this->db->where('deleted', null);
        return $this->db->get();
    }

    function get_ap_list()
    {
        $this->db->select('no, dates, vendor, p2');
        $this->db->from('purchase');
        $this->db->where('approved', 1);
        $this->db->where('currency', 'IDR');
        $this->db->where('status', 0);
        $this->db->where('deleted', null);
        return $this->db->get();
    }

    // ===================== check in ========================================

    function checkin()
    {
        $this->db->select('check_no, no, bank, currency, dates, due, amount');
        $this->db->from('ar_payment');
//        $this->db->where("dates BETWEEN '".setnull($start)."' AND '".setnull($end)."'");
        $this->db->where('approved', 1);
        $this->db->where('check_no IS NOT NULL', null, false);

        return $this->db->get();
    }


    function checkout($table=null)
    {
        $this->db->select('check_no, no, bank, currency, dates, due, amount');
        $this->db->from($table);
//        $this->db->where("dates BETWEEN '".setnull($start)."' AND '".setnull($end)."'");
        $this->db->where('approved', 1);
        $this->db->where('check_no IS NOT NULL', null, false);

        return $this->db->get();
    }

    function get_min_product()
    {
        $this->db->select('product.id, product.sku, product.manufacture, product.category, product.currency, product.name,
                           stock.qty, product.unit, product.price');
        $this->db->from('product,stock');
        $this->db->where('product.id = stock.product_id');
        $this->db->where('stock.qty <=', 1);
        $this->db->where('product.deleted', NULL);
        $this->db->where('product.publish', 1);
        $this->db->order_by('product.name', 'asc');
        $this->db->where('deleted', null);
        return $this->db->get();
    }

          

}

?>