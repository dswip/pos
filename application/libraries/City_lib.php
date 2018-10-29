<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_lib extends Custom_model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = 'kabupaten';
    }

    private $ci;
       
    private function splits($val)
    {
      $res = explode(",",$val); 
      return $res[0];
    }
    
    // ==================================== API ==============================
    
    private function get_city()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
//          CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
          CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: eb7f7529d68f6a2933b5a042ffeeac9d"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {return "cURL Error #:" . $err;} 
        else {  return $response; }
    }
    
    function combo_province()
    {
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Wilayah -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['province']] = $row['province'];}
        return $data;
    }
    
    function combo_city()
    {
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Kabupaten / Kota -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['city_id']] = $row['city_name'];}
        return $data;
    }
    
     function combo_city_combine()
    {
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Kabupaten / Kota -- ";
        if ($datax)
        {
          foreach ($datax['rajaongkir']['results'] as $row)
          {$data[$row['city_id'].'|'.$row['city_name']] = $row['city_name'];}
        }
        return $data;
    }
    
    function combo_city_db()
    {
//        $this->db->select('nama');
        $val = $this->db->get($this->tableName)->result();
        foreach($val as $row){$data['options'][$row->id] = $row->nama;}
        return $data;
    }
    
    function combo_city_name()
    {
        $json = $this->get_city();
        $datax = json_decode($json, true);
        $data['options'][""] = " -- Pilih Kabupaten / Kota -- ";
        foreach ($datax['rajaongkir']['results'] as $row)
        {$data[$row['city_name']] = $row['city_name'];}
        return $data;
    }
    
    function get_cost_fee($ori,$dest,$courier='jne',$weight=1000)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$ori."&destination=".$dest."&weight=".$weight."&courier=".$courier,
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: eb7f7529d68f6a2933b5a042ffeeac9d"
        ),
      ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) 
        { 
//            echo "cURL Error #:" . $err; 
            return 0;
        }
        else 
        { 
          $data = json_decode($response, true); 
//          $paket = $data['rajaongkir']['results'][0]['costs'][4]['service']; 
//          $harga = intval($data['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value']); 
          $json = $data['rajaongkir']['results'][0]['costs'];
          
          $datax = null;
          for ($i=0; $i<count($json); $i++)
          {
            $paket = $json[$i]['service']; 
            $harga = intval($json[$i]['cost'][0]['value']); 
            $datax[$i] = $paket.'|'.$harga;
          }
          return $datax;
        }
    }
    
    // mengahasilkan combo box ongkir
    function get_ongkir_combo($ori,$dest, $courier='jne')
    {
        $hasil = $this->get_cost_fee($ori, $dest, $courier);
        $datax = null;
        $datax[''] = '--';
        if ($hasil)
        {
          foreach ($hasil as $res){ $paket = explode('|', $res); $datax[$res] = $paket[0]; }
          $js = "class='form-control' id='cpackage' tabindex='-1' style='min-width:100px;' "; 
	  return form_dropdown('cpackage', $datax, isset($default['package']) ? $default['package'] : '', $js);
        }
    }
    
    function get_province_based_city($city,$type='id')
    {
       $this->db->where('id', $city);
       $val = $this->db->get($this->tableName)->row(); 
       if ($type == 'id'){ return $val->id_prov; }
    }
    
    function get_name($id)
    {
      $this->db->where('id', $id);
      $val = $this->db->get($this->tableName)->row();   
      return $val->nama;
    }
    
    function import()
    {
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'attendance_import';
	$data['form_action_import'] = site_url($this->title.'/import_process');
        $data['error'] = null;
	
//        $this->form_validation->set_rules('cmonth', 'Period Month', 'required|callback_valid_period['.$this->input->post('tyear').']');
        $this->form_validation->set_rules('cparent', 'Account Category', 'required|callback_valid_year');
        $this->form_validation->set_rules('userfile', 'Import File', '');
        
        if ($this->form_validation->run($this) == TRUE)
        {
             // ==================== upload ========================
            
            $config['upload_path']   = './uploads/';
            $config['file_name']     = 'account';
            $config['allowed_types'] = '*';
//            $config['allowed_types'] = 'csv';
            $config['overwrite']     = TRUE;
            $config['max_size']	     = '1000';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            
            if ( !$this->upload->do_upload("userfile"))
            { 
               $data['error'] = $this->upload->display_errors(); 
               $this->session->set_flashdata('message', "Error imported!");
               echo 'error|'.$data['error'];
            }
            else
            { 
               // success page 
              $this->import_account($this->input->post('cparent'),$config['file_name'].'.csv');
              $info = $this->upload->data(); 
              $this->session->set_flashdata('message', "One $this->title data successfully imported!");
              echo 'true|CSV Successful Uploaded';
            }                
        }
        else { $this->session->set_flashdata('message', "Error imported!"); echo 'error|'.validation_errors(); }
       // redirect($this->title);
        
    }
    
    private function import_customer($parent,$filename)
    {
        $stts = null;
        $this->load->helper('file');
//        $csvreader = new CSVReader();
        $csvreader = $this->load->library('csvreader');
        $filename = './uploads/'.$filename;
        
        $result = $csvreader->parse_file($filename);
        
        foreach($result as $res)
        {
           if(isset($res['CODE']) && isset($res['NAME']))
           {
              if ($this->valid_code($res['CODE']) == TRUE)
              {
                $account = array('name' => $res['NAME'],
                             'code' => $res['CODE'],
                             'category' => $this->account->get_category($parent),
                             'parent_id' => $parent,
                             'description' => $res['NAME'],
                             'publish' => 1,
                             'created' => date('Y-m-d H:i:s'));
            
                $this->Account_model->add($account);
              }
           }              
        }
    }


}

/* End of file Property.php */