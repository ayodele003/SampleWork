<?php defined("BASEPATH") OR exit("No direct script access allowed");

class Setting extends CI_Controller {

  	function __construct() {
	    parent::__construct();
	    //Checking user is login or not 
	    is_login();
	    $this->load->model("Setting_model");
	    $this->lang->load('settings', setting_all('language'));
  	}

  /**
   	* Load Setting view page
   	*/
	public function index() {   
		$result =array();
	    $this->load->view('include/header');
		$data['result'] = $this->Setting_model->get_setting();
		$result = []; 
		foreach ($data['result'] as $key => $value) {
			$result[$value->keys] = $value->value;	
		}
		if(setting_all('UserModules')=='yes') {
			if(isset($this->session->get_userdata()['user_details'][0]->user_type) && $this->session->get_userdata()['user_details'][0]->user_type=='admin') {
				$data['result'] = $result;
				$this->load->view('index',$data); 
			}
		}	else {
			$data['result'] = $result;
			$this->load->view('index',$data); 
		}
	    $this->load->view('include/footer');
	}

  /**
   	* This function is used to update setting
   	*/
	 function edit_setting() {	
		$data =array();
		$data = $this->input->post();
		if(isset($data['user_type']) && is_array($data['user_type']) && !empty($data['user_type'])) {
			$data['user_type'] = json_encode($data['user_type']);
		}
		
		if(!empty($_FILES['logo']['name'])){
			$newname=$this->uploadFile('logo');
			if(!$newname) {
				redirect( base_url().'setting', 'refresh');
			}
			$data['logo'] = strtolower(str_replace(' ', '_', $newname));
		} else { 
			if($this->input->post('fileOldlogo')) {
				$data['logo'] = $this->input->post('fileOldlogo');
			}
		}
		if(!empty($_FILES['favicon']['name'])){	
			$newname=$this->uploadFile('favicon'); 
			if(!$newname) {
				redirect( base_url().'setting', 'refresh');
			}
			$data['favicon'] = strtolower(str_replace(' ', '_', $newname));
		} else {
			if($this->input->post('fileOldfavicon')) {
				$data['favicon'] = $this->input->post('fileOldfavicon');
			}
		}
		if(!isset($data['register_allowed'])) {
			$data['register_allowed'] = 0;
		}

		if(!isset($data['admin_approval'])) {
			$data['admin_approval'] = 0;
		}

		if(isset($data['user_type_name'])) {
			if(is_array($data['user_type_name']) && !empty($data['user_type_name'])) {
				foreach ($data['user_type_name'] as $utkey => $utvalue) {
					$this->Setting_model->updateRow('permission', 'id', $utkey, array('user_type'=>$utvalue));			
				}
			}

			unset($data['user_type_name']);
		}

		if(isset($data['new_mka'])) {
			$permissiona = $this->Setting_model->get_adm_permissions();
			if(is_array($data['new_mka']) && !empty($data['new_mka'])) {
				foreach ($data['new_mka'] as $nutkey => $nutvalue) {
					$inst_data = array(
							'user_type' => $nutvalue,
							'data' => $permissiona->data
						);
					$this->Setting_model->insertRow('permission', $inst_data);
				}
			}
			unset($data['new_mka']);
		}

		if(isset($data['rm_user_type'])) {
			if(is_array($data['rm_user_type']) && !empty($data['rm_user_type'])) {
				foreach ($data['rm_user_type'] as $rutkey => $rutvalue) {
					$this->Setting_model->delete('permission', 'id', $rutvalue);
				}
			}
			unset($data['rm_user_type']);
		}

		foreach($data as $key=>$value)
		{
			$this->Setting_model->updateRow('setting', 'keys', $key, array('value'=>$value));
		}

		$art_msg['msg'] = lang('your_data_updated_successfully'); 
		$art_msg['type'] = 'success'; 
		$this->session->set_userdata('alert_msg', $art_msg);
		if($this->input->post('mail_setting')){
			redirect( base_url().'setting#emailSetting', 'refresh');
		} else {
			redirect( base_url().'setting', 'refresh');
		}
	}

	/**
	  * This function is used to Upload file
	  * @param $fielName : This is input name from form
	  * @return fileName by which file is uploaded on server
	  */
	public function uploadFile($fielName) {
		//echo '<pre>';print_r($fielName); die;
		$filename                = str_replace(' ', '_', $_FILES[$fielName]['name']);
		$tmpname                 = $_FILES[$fielName]['tmp_name']; 
		$exp                     = explode('.', $filename);
		$ext                     = end($exp);
		$newname                 =  strtolower($exp[0]).'_'.time().".".$ext; 
		$config['upload_path']   = 'assets/images/';
		$config['upload_url']    =  base_url().'assets/images/';
		$config['allowed_types'] = "gif|jpg|jpeg|png|ico";
		$config['max_size']      = 5000; 
		$config['file_name']     = $newname;
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($fielName)) {
            $art_msg['msg'] = $this->upload->display_errors(); 
			$art_msg['type'] = 'success'; 
			$this->session->set_userdata('alert_msg', $art_msg);
			return FALSE;
        }
		return $newname;
	}
	
	

  	/**
	  * This function is used to add new user type
	  * @return: true if update successfuly
	  */
	public function add_user_type() {
		echo $this->Setting_model->add_user_type();
		exit;
	}

	/**
	  * This function is used to update user permissions
	  * @return: true if update successfuly
	  */

	public function permission() {	
		$data =array();
		$dataa = $this->input->post('data');
		foreach($dataa as $key=>$value)
		{
			$key = str_replace('_SPACE_', ' ', $key);
			$arr = array();
			foreach ($value as $vkey => $vvalue) {
				$vkey = str_replace('_SPACE_', ' ', $vkey);
				$arr[$vkey] = $vvalue;
			}
			$this->Setting_model->updateRow('permission', 'user_type', $key, array('data'=>json_encode($arr)));
		}
		$art_msg['msg'] = lang('your_data_updated_successfully'); 
		$art_msg['type'] = 'success'; 
		$this->session->set_userdata('alert_msg', $art_msg);
		redirect( base_url().'setting#permissionSetting', 'refresh');
	}

	public function ajax_data() {
		$primaryKey = 'custom_fields_id';
		$table 		= 'custom_fields';
		$columns 	= array(
			array( 'db' => 'custom_fields_id', 'dt' => 0 ),
			array( 'db' => 'name', 'dt' => 1 ),
			array( 'db' => 'type', 'dt' => 2 ),
			array( 'db' => 'rel_crud', 'dt' => 3 ),
			array( 'db' => 'status', 'dt' => 4 ),
			array( 'db' => 'create_date', 'dt' => 5 )
			);
		$joinQuery 	=  "FROM `custom_fields` ";
		$where = '';
		$j = 0;
		if(strpos($joinQuery, 'JOIN') > 0) {
			$j = 1;
		}
		$where = SSP::mkaFilter( $_GET, $columns, $j);
		
		$group_by = "";
		$having = "";

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::order( $_GET, $columns, $j );
		$col = SSP::pluck($columns, 'db', $j);

		$query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$having." ".$order." ".$limit." ";
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->select("count('custom_fields') AS c")->get('custom_fields')->row()->c;
		$res = SSP::data_output($columns, $res, $j);

		$output_arr['draw'] 			= intval( $_GET['draw'] );
		$output_arr['recordsTotal'] 	= intval( $recordsTotal );
		$output_arr['recordsFiltered'] 	= intval( $recordsTotal );
		$output_arr['data'] 			= $res;
		//$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $group_by, $having);
		foreach ($output_arr['data'] as $key => $value) 
		{
			$id = $output_arr['data'][$key][0];
			//$output_arr['data'][$key][0] = '<input type="checkbox" name="selData" value="'.$output_arr['data'][$key][0].'">';
			$arr_keys = array_keys($output_arr['data'][$key]);

			$output_arr['data'][$key][end($arr_keys)] = '';
			$output_arr['data'][$key][end($arr_keys)] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-toggle="modal"  data-target="#custom_fields_modal" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons font-20">mode_edit</i></a>';
			
			
			$output_arr['data'][$key][end($arr_keys)] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \'setting\')"><i class="material-icons col-red font-20">delete</i></a>';
			
		}
		echo json_encode($output_arr);
	}

	public function custom_field() {
		if($this->input->post('id')) {
			$data = array(
					"rel_crud" => $this->input->post('crud_nmae'),
					"name" => $this->input->post('field_name'),
					"type" => $this->input->post('type'),
					"required" => $this->input->post('required'),
					"options" => $this->input->post('options'),
					"status" => $this->input->post('status'),
					"show_in_grid" => $this->input->post('show_in_grid')
				);
			$old_res = $this->getCustomFieldById($this->input->post('id'));
			if($this->Setting_model->updateRow('custom_fields', 'custom_fields_id', $this->input->post('id'), $data)) {
				$this->UpdateCustomFieldLang($old_res, $this->input->post('field_name'), $this->input->post('crud_nmae'));
				$this->session->set_flashdata('message', lang('your_data_updated_successfully').'..');
			}	
		} else {
			$data = array(
					"rel_crud" => $this->input->post('crud_nmae'),
					"name" => $this->input->post('field_name'),
					"type" => $this->input->post('type'),
					"required" => $this->input->post('required'),
					"options" => $this->input->post('options'),
					"status" => $this->input->post('status'),
					"show_in_grid" => $this->input->post('show_in_grid')
				);
			if($this->Setting_model->insertRow('custom_fields', $data)) {
				$this->setCustomFieldLang($this->input->post('field_name'), $this->input->post('crud_nmae'));
				$art_msg['msg'] = lang('your_data_added_successfully'); 
				$art_msg['type'] = 'success'; 
				$this->session->set_userdata('alert_msg', $art_msg);
			}
		}
		redirect(base_url().'/setting#custom-fields-div');
		
	}

	public function get_modal() {
		$data['result'] = $this->Setting_model->get_setting();
		$result = []; 
		foreach ($data['result'] as $key => $value) {
			$result[$value->keys] = $value->value;	
		}
		$data['result'] = $result;
		if($this->input->post('id')){
			$data['data']= $this->Setting_model->Get_data_id($this->input->post('id'));
      		echo $this->load->view('add_update', $data, true);
	    } else {
	      	echo $this->load->view('add_update', $data, true);
	    }
	    exit;
	}

	public function delete($ids) {
		$idsArr = explode('-', $ids);
		foreach ($idsArr as $key => $value) {
			$this->Setting_model->delete_data($value);		
		}
		echo json_encode($idsArr); 
		exit;
  	}

  	public function switchLang($language = "") {
        $language = ($language != "") ? $language : "english";
        $this->Setting_model->updateRow('setting', 'keys', 'language', array('value' => $language));
        redirect($_SERVER['HTTP_REFERER']);
        /*echo 1;
        exit;*/
    }

    public function get_lang_module_options() {
    	$langFile_path = realpath(dirname(dirname(dirname(dirname(__FILE__))))).'/language/english';
    	$files = array_diff(scandir($langFile_path), array('.', '..', 'index.html'));
    	$html = '<option value=""></option>';
    	foreach ($files as $value) {
    		$html .= '<option value="'.strtolower(str_replace('_lang.php', '', $value)).'">'.ucfirst(str_replace('_lang.php', '', $value)).'</option>';	
    	}
    	echo $html;
    	die;
    }

    public function set_theme_color_cookie() {	
		if($this->input->post('theme_color')){  
            $this->load->helper('cookie');
            $cookie = array(
                    'name'   => 'theme_color',
                    'value'  => $this->input->post('theme_color'),
                    'expire' => 86400*7,
                    'path' => '/', 
                    'secure' => False
                    );
           set_cookie($cookie);

           echo "1";
           exit;              
   		}else{
   			echo "0";
   			exit;
   		}
	}

	public function setCustomFieldLang() {	
		$lang_var = '';
		if($this->input->post('options') != '') {
			$opt = explode(',', $this->input->post('options'));
			foreach ($opt as $key => $value) {
				$lang_var .= '$lang[\''.get_lang($this->input->post('crud_nmae').'_'.trim($value)).'\'] = \''.trim($value).'\';'.PHP_EOL;
			}
		}
		$lang_var .= '$lang[\''.get_lang(trim($this->input->post('crud_nmae'))).'_'.get_lang(trim($this->input->post('field_name'))).'\'] = \''.$this->input->post('field_name').'\';'.PHP_EOL;
		$Path = realpath(dirname(dirname(dirname(dirname(__FILE__))))).'/language/english';
		$g_lang = file_get_contents($Path.'/custom_field_lang.php');
		$lg = $lang_var.'/*mka_custom_variables*/';
		$g_lang = str_replace('/*mka_custom_variables*/', $lg, $g_lang);
		file_put_contents($Path.'/custom_field_lang.php', $g_lang);
	}

	public function getCustomFieldById($id) {	
		$this->db->select('*');
		$this->db->from('custom_fields');
		$this->db->where('custom_fields_id' , $id);
		$query = $this->db->get();
		return $result = $query->row();
	}

	public function UpdateCustomFieldLang($old_result, $field_name, $crud_name) {	
		$lang_var = '$lang[\''.get_lang(trim($crud_name)).'_'.get_lang(trim($field_name)).'\'] = \''.$field_name.'\';';
		$lg = '$lang[\''.get_lang(trim($old_result->rel_crud)).'_'.get_lang(trim($old_result->name)).'\'] = \''.$old_result->name.'\';';
		$Path = realpath(dirname(dirname(dirname(dirname(__FILE__))))).'/language/english';
		$g_lang = file_get_contents($Path.'/custom_field_lang.php');
		$g_lang = str_replace($lg, $lang_var, $g_lang);
		file_put_contents($Path.'/custom_field_lang.php', $g_lang);
		
		if($this->input->post('options') != '') {
			$opt = explode(',', $this->input->post('options'));
			$old = explode(',', $old_result->options);
			$lang_var = '';
			$lg = '';
			foreach ($opt as $key => $value) {
				$Path = realpath(dirname(dirname(dirname(dirname(__FILE__))))).'/language/english';
				$g_lang = file_get_contents($Path.'/custom_field_lang.php');
				$m = '';
				if(isset($old[$key])) {
					$lg = '$lang[\''.get_lang(trim($this->input->post('crud_nmae'))).'_'.get_lang(trim($old[$key])).'\'] = \''.trim($old[$key]).'\';';
				} else {
					$lg = '/*mka_custom_variables*/';
					$m = PHP_EOL.$lg;
				}
				$lang_var = '$lang[\''.get_lang($this->input->post('crud_nmae').'_'.trim($value)).'\'] = \''.trim($value).'\';'.$m;
				
				$g_lang = str_replace($lg, $lang_var, $g_lang);
				file_put_contents($Path.'/custom_field_lang.php', $g_lang);
			}
		}
	}

	public function get_api_key() {
		echo generateRandomNumber(15).time();
		die;
	}

	public function remove_tokens() {
		$this->Setting_model->remove_tokens();
		echo '1';
		exit;
	}
}
?>