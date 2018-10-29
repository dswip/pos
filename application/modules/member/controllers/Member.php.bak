<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'libraries/rest/REST_Controller.php');
class Member extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('table');
        
        $this->load->model('Member_model', 'model', TRUE);

//        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

//        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
//        $this->role = new Role_lib();
        $this->city = new City_lib();
        $this->disctrict = new District_lib();
    }

    private $properti, $modul, $title, $customer, $city, $disctrict;
    private $role;

    function index_get()
    {
       if(!$search){ $result = $this->model->get_last($this->modul['limit'])->result();}
        else {$result = $this->model->search($cat,$publish)->result(); }
    
        $output = null;
        if ($result){
                
         foreach($result as $res)
         {   
           $output[] = array ($res->id, $res->first_name, $res->last_name, $res->type, $res->address, $res->shipping_address, 
                                  $res->phone1, $res->phone2, $res->fax, $res->email, $res->password, $res->website, $this->city->get_name($res->city),
                                  $res->region, $res->zip, $res->notes, 
                                  base_url().'images/customer/'.$res->image, $res->status , tglin($res->joined)
                                 );
         }
         $response = 
          [
              'status' => 'success',
              'data' => $output
          ];
        }
        else
        {
            $response = 
            [
                'status' => 'failed',
                'message_code' => 'empty_data'
            ];
        }
        $this->response($response,REST_Controller::HTTP_OK); 
    }
    
    public function register()
    {
        
    }

    public function getdatatable($search=null,$cat='null',$publish='null')
    {
        if(!$search){ $result = $this->model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->model->search($cat,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
	   $output[] = array ($res->id, $res->first_name, $res->last_name, $res->type, $res->address, $res->shipping_address, 
                              $res->phone1, $res->phone2, $res->fax, $res->email, $res->password, $res->website, $this->city->get_name($res->city),
                              $res->region, $res->zip, $res->notes, 
                              base_url().'images/customer/'.$res->image, $res->status , tglin($res->joined)
                             );
	 } 
         
        $this->output
         ->set_status_header(200)
         ->set_content_type('application/json', 'utf-8')
         ->set_output(json_encode($output))
         ->_display();
         exit;  
        }
    }

    function get_last()
    {
//        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Customer Manager');
        $data['h2title'] = 'Customer Manager';
        $data['main_view'] = 'customer_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['city'] = $this->city->combo_city_db();
        $data['array'] = array('','');
        
	// ---------------------------------------- //
 
        $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = "<li><span><b>";
        $config['cur_tag_close'] = "</b></span></li>";

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Image', 'Type', 'Name', 'Email', 'City', 'Joined', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
            
        // Load absen view dengan melewatkan var $data sbgai parameter
//	$this->load->view('template', $data);
        $this->response($data,REST_Controller::HTTP_OK);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->model->get_by_id($uid)->row();
       if ($val->status == 0){ $lng = array('status' => 1); }else { $lng = array('status' => 0); }
       $this->model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function delete_all($type='soft')
    {
      if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
      
        $cek = $this->input->post('cek');
        $jumlah = count($cek);

        if($cek)
        {
          $jumlah = count($cek);
          $x = 0;
          for ($i=0; $i<$jumlah; $i++)
          {
             if ($type == 'soft') { $this->model->delete($cek[$i]); }
             else { $this->remove_img($cek[$i],'force');
                    $this->attribute_customer->force_delete_by_customer($cek[$i]);
                    $this->model->force_delete($cek[$i]);  }
             $x=$x+1;
          }
          $res = intval($jumlah-$x);
          //$this->session->set_flashdata('message', "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!");
          $mess = "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!";
          echo 'true|'.$mess;
        }
        else
        { //$this->session->set_flashdata('message', "No $this->title Selected..!!"); 
          $mess = "No $this->title Selected..!!";
          echo 'false|'.$mess;
        }
      }else{ echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
      
    }

    function delete_uid($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
            $this->model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function add()
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['currency'] = $this->currency->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tfname', 'SKU', 'required');
        $this->form_validation->set_rules('tlname', 'Name', 'required');
        $this->form_validation->set_rules('ctype', 'Customer Type', 'required');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tphone1', 'Phone 1', 'required');
        $this->form_validation->set_rules('tphone2', 'Phone 2', '');
        $this->form_validation->set_rules('temail', 'Email', 'required|valid_email|callback_valid_email');
        $this->form_validation->set_rules('twebsite', 'Website', '');
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('cdistrict', 'District', 'required');
        $this->form_validation->set_rules('tzip', 'Zip', '');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/customer/';
            $config['file_name'] = split_space($this->input->post('tfname').'_'.waktuindo());
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $customer = array('first_name' => strtolower($this->input->post('tfname')), 
                                  'last_name' => strtolower($this->input->post('tlname')),
                                  'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                                  'shipping_address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                                  'email' => $this->input->post('temail'), 'password' => 'password', 
                                  'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                                  'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                                  'zip' => $this->input->post('tzip'), 'joined' => date('Y-m-d H:i:s'),
                                  'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                
                $customer = array('first_name' => strtolower($this->input->post('tfname')), 
                                  'last_name' => strtolower($this->input->post('tlname')),
                                  'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                                  'shipping_address' => $this->input->post('taddress'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                                  'email' => $this->input->post('temail'), 'password' => 'password', 
                                  'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                                  'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                                  'zip' => $this->input->post('tzip'), 'joined' => date('Y-m-d H:i:s'),
                                  'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }

            $this->model->add($customer);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/customer/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    private function split_array($val)
    { return implode(",",$val); }
   

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'customer_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));
        $data['source'] = site_url($this->title.'/getdatatable');

        $data['city'] = $this->city->combo_city_db();
        $data['district'] = $this->disctrict->combo_district_db(null);
        $data['array'] = array('','');
        
        $customer = $this->model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $customer->id);
        
        $data['default']['fname'] = $customer->first_name;
        $data['default']['lname'] = $customer->last_name;
        $data['default']['type'] = $customer->type;
        $data['address'] = $customer->address;
        $data['shipping'] = $customer->shipping_address;
        $data['default']['phone1'] = $customer->phone1;
        $data['default']['phone2'] = $customer->phone2;
        $data['default']['email'] = $customer->email;
        $data['default']['password'] = $customer->password;
        $data['default']['website'] = $customer->website;
        $data['default']['city'] = $customer->city;
        $data['default']['district'] = $customer->region;
        $data['default']['zip'] = $customer->zip;
        $data['default']['image'] = base_url().'images/customer/'.$customer->image;

        $this->load->view('template', $data);
    }
    
    function image_gallery($pid=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_image/'.$pid);
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $result = $this->model->get_by_id($pid)->row();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No', 'Name', 'Image');
        
        for ($i=1; $i<=5; $i++)
        {   
            switch ($i) {
                case 1:$url = $result->url1; break;
                case 2:$url = $result->url2; break;
                case 3:$url = $result->url3; break;
                case 4:$url = $result->url4; break;
                case 5:$url = $result->url5; break;
            }
            
            if ($url){ if ($result->url_upload == 1){ $url = base_url().'images/customer/'.$url; } }
            
            $image_properties = array('src' => $url, 'alt' => 'Image'.$i, 'class' => 'img_customer', 'width' => '60', 'title' => 'Image'.$i,);
            $this->table->add_row
            (
               $i, 'Image'.$i, !empty($url) ? img($image_properties) : ''
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view('customer_image', $data);
    }
    
    function valid_image($val)
    {
        if ($val == 0)
        {
            if (!$this->input->post('turl')){ $this->form_validation->set_message('valid_image','Image Url Required..!'); return FALSE; }
            else { return TRUE; }            
        }
    }
    
    function add_image($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Customer Manager');
            $data['h2title'] = 'Customer Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cname', 'Image Attribute', 'required|');
            $this->form_validation->set_rules('userfile', 'Image Value', '');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $result = $this->model->get_by_id($pid)->row();
                if ($result->url_upload == 1)               
                {
                    switch ($this->input->post('cname')) {
                    case 1:$img = "./images/customer/".$result->url1; break;
                    case 2:$img = "./images/customer/".$result->url2; break;
                    case 3:$img = "./images/customer/".$result->url3; break;
                    case 4:$img = "./images/customer/".$result->url4; break;
                    case 5:$img = "./images/customer/".$result->url5; break;
                  }
                  @unlink("$img"); 
                }
                
                    $config['upload_path'] = './images/customer/';
                    $config['file_name'] = split_space($result->name.'_'.$this->input->post('cname'));
                    $config['allowed_types'] = 'jpg|gif|png';
                    $config['overwrite']  = true;
                    $config['max_size']   = '1000';
                    $config['max_width']  = '30000';
                    $config['max_height'] = '30000';
                    $config['remove_spaces'] = TRUE;

                    $this->load->library('upload', $config);
                    
                    if ( !$this->upload->do_upload("userfile")) // if upload failure
                    {
                        $attr = array('url'.$this->input->post('cname') => null, 'url_upload' => 1);
                    }
                    else {$info = $this->upload->data();
                         $attr = array('url'.$this->input->post('cname') => $info['file_name'], 'url_upload' => 1); 
                    } 
                
                $this->model->update($pid, $attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function attribute($pid=null,$category=null)
    {        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_attribute/'.$pid);
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['attributes'] = $this->attribute->combo($category);  
        $result = $this->attribute_customer->get_list($pid)->result();
        
        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No','Attribute', 'Value', '#');
        
        $i = 0;
        foreach ($result as $res)
        {
            $this->table->add_row
            (
                ++$i, $this->attribute_list->get_name($res->attribute_id), $res->value,
                anchor('#','<span>delete</span>',array('class'=> 'btn btn-danger btn-sm text-danger', 'id' => $res->id, 'title' => 'delete'))
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view('customer_attribute', $data);
    }
    
    function add_attribute($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Customer Manager');
            $data['h2title'] = 'Customer Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cattribute', 'Attribute List', 'required|maxlength[100]|callback_valid_attribute['.$pid.']');
            $this->form_validation->set_rules('tvalue', 'Attribute Value', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $attr = array('customer_id' => $pid, 'attribute_id' => $this->input->post('cattribute'), 'value' => $this->input->post('tvalue'));
                $this->attribute_customer->add($attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function valid_email($val)
    {
        if ($this->model->valid('email',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_email','Email registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_email($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->model->validating('email',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_email', "Email registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    // Fungsi update untuk mengupdate db
    function update_process($param=0)
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Customeristrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'customer_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation

        $this->form_validation->set_rules('tfname', 'SKU', 'required');
        $this->form_validation->set_rules('tlname', 'Name', 'required');
        $this->form_validation->set_rules('ctype', 'Customer Type', 'required');
        $this->form_validation->set_rules('taddress', 'Address', 'required');
        $this->form_validation->set_rules('tphone1', 'Phone 1', 'required');
        $this->form_validation->set_rules('tphone2', 'Phone 2', '');
        $this->form_validation->set_rules('temail', 'Email', 'required|valid_email|callback_validating_email');
        $this->form_validation->set_rules('twebsite', 'Website', '');
        $this->form_validation->set_rules('ccity', 'City', 'required');
        $this->form_validation->set_rules('cdistrict', 'District', 'required');
        $this->form_validation->set_rules('tzip', 'Zip', '');
            
        if ($this->form_validation->run($this) == TRUE)
        {
            // start update 1
            $config['upload_path'] = './images/customer/';
            $config['file_name'] = split_space($this->input->post('tfname').'_'.waktuindo());
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();

                $customer = array('first_name' => strtolower($this->input->post('tfname')), 
                              'last_name' => strtolower($this->input->post('tlname')),
                              'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                              'shipping_address' => $this->input->post('tshipping'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                              'email' => $this->input->post('temail'), 'password' => 'password', 
                              'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                              'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                              'zip' => $this->input->post('tzip'));

            }
            else
            {
                $info = $this->upload->data();

                $customer = array('first_name' => strtolower($this->input->post('tfname')), 
                              'last_name' => strtolower($this->input->post('tlname')),
                              'type' => $this->input->post('ctype'), 'address' => $this->input->post('taddress'),
                              'shipping_address' => $this->input->post('tshipping'), 'phone1' => $this->input->post('tphone1'), 'phone2' => $this->input->post('tphone2'),
                              'email' => $this->input->post('temail'), 'password' => 'password', 
                              'website' => $this->input->post('twebsite'), 'region' => $this->input->post('cdistrict'),
                              'city' => $this->input->post('ccity'), 'state' => $this->city->get_province_based_city($this->input->post('ccity')),
                              'zip' => $this->input->post('tzip'), 'image' => $info['file_name']);
            }

            $this->model->update($this->session->userdata('langid'), $customer);
            $this->session->set_flashdata('message', "One $this->title has successfully updated!");
            redirect($this->title.'/update/'.$this->session->userdata('langid'));

            // end update 1
        }
        else{ $this->session->set_flashdata('message', validation_errors());
              redirect($this->title.'/update/'.$this->session->userdata('langid'));
            }
        
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function ajaxcombo_district()
    {
        $cityid = $this->input->post('value');
        if ($cityid != null){
            $district = $this->disctrict->combo_district_db($cityid);
            $js = "class='select2_single form-control' id='cdistrict' tabindex='-1' style='width:100%;' "; 
            echo form_dropdown('cdistrict', $district, isset($default['district']) ? $default['district'] : '', $js);
        }
    }
    
    // ====================================== CLOSING ======================================
    function reset_process(){ $this->model->closing(); } 
   

}

?>