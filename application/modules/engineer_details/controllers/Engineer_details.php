<?php defined("BASEPATH") OR exit("No direct script access allowed");
class Engineer_details extends CI_Controller {
  	function __construct() {
	    parent::__construct();
	    $this->load->model("Engineer_details_model"); 
	    $this->lang->load(strtolower('Engineer_details'), setting_all('language'));
		if(true==1){
			is_login(); 
			$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
		}else{ 	
			$this->user_id =1;
		}
  	}
  	/**
      * This function is used to view page
      */
  	public function index() {   
  		if(CheckPermission("engineer_details", "all_read,own_read")){
  			$con = '';
  			
			$data["view_data"]= $this->Engineer_details_model->get_data($con);
			if($con == '') {
				$this->load->view("include/header");
			}
			$data["obj"] = $this;
			$this->load->view("index",$data);
			if($con == '') {
				$this->load->view("include/footer");
			}
		} else {
			$art_msg['msg'] = lang('you_do_not_have_permission_to_access'); 
			$art_msg['type'] = 'warning'; 
			$this->session->set_userdata('alert_msg', $art_msg);
            redirect( base_url().'user/profile', 'refresh');
		}
  	}


  	public function get_filter_html($ajax = 0) {
  		$filter_coo = '';
  		if(isset($_COOKIE[strtolower('Engineer_details_filter')])) {
  			$filter_coo = json_decode($_COOKIE[strtolower('Engineer_details_filter')]);
  		}
  		$html = '';
  		if($ajax == 1) {
  			echo $html; exit;
  		} else {
  			return $html;
  		}
  	}


  	public function get_filter_dropdown_options($field, $rel_table, $rel_col, $selected) {
  		$res = $this->Engineer_details_model->get_filter_dropdown_options($field, $rel_table, $rel_col);
  		$option = '';
  		if(isset($res) && is_array($res) && !empty($res)) {
  			foreach ($res as $key => $value) {
  				if($rel_table != '') {
  					$col = $rel_table.'_id';
  					$se = '';
  					if($selected == $value->$col) {
  						$se = 'selected';
  					}
  					$option .= '<option '.$se.' value="'.$value->$col.'">'.char_limit(ucfirst($value->$rel_col), 30).'</option>';	
  				} else {
  					$se = '';
  					if($selected == $value->$field) {
  						$se = 'selected';
  					}
  					$option .= '<option '.$se.' value="'.$value->$field.'">'.char_limit(ucfirst($value->$field), 30).'</option>';
  				}
  			}
  		}
  		return $option;
  	}
  	

  	/**
      * This function is used to Add and update data
      */
	public function add_edit() {	
		$data = $this->input->post();
		$postoldfiles = array();
		foreach ($data as $okey => $ovalue) {
    		if(strstr($okey, "wpb_old_")) {
			$postoldfiles[$okey]=$ovalue;
    		}
		}
		foreach ($_FILES as $fkey => $fvalue) {
			$config['upload_path'] = 'assets/images/';
			$config['upload_url'] =  base_url().'assets/images/';
			$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
			$config['max_size'] = 5000; 
			$this->load->library('upload', $config);
			foreach($fvalue['name'] as $key => $fileInfo) {
				if(!empty($_FILES[$fkey]['name'][$key])){
					$filename = str_replace(' ', '_', $_FILES[$fkey]['name'][$key]);
					$tmpname=$_FILES[$fkey]['tmp_name'][$key]; 
					$exp=explode('.', $filename);
					$ext=end($exp);
					$newname =  strtolower($exp[0]).'_'.time().".".$ext; 

					$_FILES['mka_file']['name']     = $newname;
					$_FILES['mka_file']['type']     = $_FILES[$fkey]['type'][$key];
					$_FILES['mka_file']['tmp_name'] = $_FILES[$fkey]['tmp_name'][$key];
					$_FILES['mka_file']['error']    = $_FILES[$fkey]['error'][$key];
					$_FILES['mka_file']['size']     = $_FILES[$fkey]['size'][$key];
					if ( $this->upload->do_upload('mka_file')) {
						$newfiles[$fkey][]=$newname;
			        }
				}
				else{
					$newfiles[$fkey]='';
			
				}
			}
			if(!empty($postoldfiles)) {

				if(!empty($postoldfiles['wpb_old_'.$fkey])){
					$oldfiles = $postoldfiles['wpb_old_'.$fkey];
				}
				else{
					$oldfiles = array();
				}
				if(!empty($newfiles[$fkey])){
					$all_files = array_merge($oldfiles,$newfiles[$fkey]);	
				}
				else{
					$all_files = $postoldfiles['wpb_old_'.$fkey];
				}
					
			}
			else{
				$all_files = $newfiles[$fkey];
			}
			if(is_array($all_files) && !empty($all_files)) {
				$data[$fkey] = implode(',', $all_files);
			}
		}
		if($this->input->post('id')) {
			foreach ($postoldfiles as $pkey => $pvalue) {
				unset($data[$pkey]);		
			}
			unset($data['submit']);
			unset($data['save']);
			unset($data['id']);

			if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
                if(!empty($custom_fields)) {
                    foreach ($custom_fields as $cfkey => $cfvalue) {
                    	if(is_array($cfvalue)) {
                    		$custom_fields[$cfkey] = implode(',', $cfvalue);
                    		$cfvalue = implode(',', $cfvalue);
                    	}
                        $qr = "SELECT * FROM `cf_values` WHERE `rel_crud_id` = '".$this->input->post('id')."' AND `cf_id` = '".$cfkey."'";
                        $cf_data = $this->Engineer_details_model->getQrResult($qr);
                        if(is_array($cf_data) && !empty($cf_data)) {
                            $d = array(
                                        "value" => $custom_fields[$cf_data[0]->cf_id],
                                    );
                            $this->Engineer_details_model->updateRow('cf_values', 'cf_values_id', $cf_data[0]->cf_values_id, $d);
                        } else {
                            $d = array(
                                    "rel_crud_id" => $this->input->post('id'),
                                    "cf_id" => $cfkey,
                                    "curd" => 'engineer_details',
                                    "value" => $cfvalue,
                                );
                            $this->Engineer_details_model->insertRow('cf_values', $d);
                        }
                    }
                }
            }
			
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}
			$this->Engineer_details_model->updateRow('engineer_details', 'engineer_details_id', $this->input->post('id'), $data);
      		echo $this->input->post('id'); 
			exit;
		} else { 
			unset($data['submit']);
			unset($data['save']);
			$data['user_id']=$this->user_id;
			if(isset($data['mkacf'])) {
                $custom_fields = $data['mkacf'];
                unset($data['mkacf']);
            }
			foreach ($data as $dkey => $dvalue) {
				if(is_array($dvalue)) {
					$data[$dkey] = implode(',', $dvalue); 
				}
			}
			$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			$last_id = $this->Engineer_details_model->insertRow('engineer_details', $data);
			if(!empty($custom_fields)) {
                foreach ($custom_fields as $cfkey => $cfvalue) {
                	if(is_array($cfvalue)) {
                		$cfvalue = implode(',', $cfvalue);
                	}
                    $d = array(
                                "rel_crud_id" => $last_id,
                                "cf_id" => $cfkey,
                                "curd" => 'engineer_details',
                                "value" => $cfvalue,
                            );
                    $this->Engineer_details_model->insertRow('cf_values', $d);
                }
            }
            echo $last_id;
			exit;
			/*$this->session->set_flashdata('message', 'Your data inserted Successfully..');
			redirect('engineer_details');*/
		}
	}
	
	/**
      * This function is used to show popup for add and update
      */
	public function get_modal() {
		if($this->input->post('id')){
			$data['data']= $this->Engineer_details_model->Get_data_id($this->input->post('id'));
      		echo $this->load->view('add_update', $data, true);
	    } else {
	      	echo $this->load->view('add_update', '', true);
	    }
	    exit;
	}
	
	/**
      * This function is used to delete multiple records form table
      * @param : $ids is array if record id
      */
  	public function delete($ids) {
		$idsArr = explode('-', $ids);
		foreach ($idsArr as $key => $value) {
			$this->Engineer_details_model->delete_data($value);		
		}
		echo json_encode($idsArr); 
		exit;
		//redirect(base_url().'engineer_details', 'refresh');
  	}
  	/**
      * This function is used to delete single record form table
      * @param : $id is record id
      */
  	public function delete_data($id) { 
		$this->Engineer_details_model->delete_data($id);
		$art_msg['msg'] = lang('your_data_deleted_successfully'); 
		$art_msg['type'] = 'warning'; 
		$this->session->set_userdata('alert_msg', $art_msg);
	    redirect('engineer_details');
  	}
	/**
      * This function is used to create data for server side datatable
      */
  	public function ajx_data(){
		$primaryKey = 'engineer_details_id';
		$table 		= 'engineer_details';
		$joinQuery  =   "FROM `engineer_details` ";
		$columns 	= array(
array( 'db' => 'engineer_details.engineer_details_id AS engineer_details_id', 'field' => 'engineer_details_id', 'dt' => 0 ),
array( 'db' => 'engineer_details.engineer_details_engineer_first_name_ AS engineer_details_engineer_first_name_', 'field' => 'engineer_details_engineer_first_name_', 'dt' => 1 ),
array( 'db' => 'engineer_details.engineer_details_engineer_last_name AS engineer_details_engineer_last_name', 'field' => 'engineer_details_engineer_last_name', 'dt' => 2 ),
array( 'db' => 'engineer_details.engineer_details_engineer_email AS engineer_details_engineer_email', 'field' => 'engineer_details_engineer_email', 'dt' => 3 ),
array( 'db' => 'engineer_details.engineer_details_engineer_number AS engineer_details_engineer_number', 'field' => 'engineer_details_engineer_number', 'dt' => 4 ),
array( 'db' => 'engineer_details.engineer_details_location AS engineer_details_location', 'field' => 'engineer_details_location', 'dt' => 5 ),
);

			error_reporting(E_ALL);
			ini_set('display_errors', 1);
	        $cf = get_cf('engineer_details');
	        if(is_array($cf) && !empty($cf)) {
	            foreach ($cf as $cfkey => $cfvalue) {
	                array_push($columns, array( 'db' => "cf_values_".$cfkey.".value AS cfv_".$cfkey, 'field' => "cfv_".$cfkey, 'dt' => count($columns) ));
	                $joinQuery  .=  " LEFT JOIN `cf_values` AS cf_values_".$cfkey."  ON  `engineer_details`.`engineer_details_id` = `cf_values_".$cfkey."`.`rel_crud_id` AND `cf_values_".$cfkey."`.`cf_id` =  '".$cfvalue->custom_fields_id."' ";
	            }
	        }
			array_push($columns, array( 'db' => 'engineer_details.engineer_details_id AS engineer_details_id', 'field' => 'engineer_details_id', 'dt' => count($columns) ));
		$where = '';
		$j = 0;
		if(strpos($joinQuery, 'JOIN') > 0) {
			$j = 1;
		}
		$where = SSP::mkaFilter( $_GET, $columns, $j);
		$where = SSP::column_mka_filter($_GET, $where);
		if($this->input->get('dateRange')) {
			$date = explode(' - ', $this->input->get('dateRange'));
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`$table`.`".$this->input->get('columnName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		
		if(CheckPermission($table, "all_read")){}
		else if(CheckPermission($table, "own_read") && CheckPermission($table, "all_read")!=true){
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."`$table`.`user_id`=".$this->user_id." ";
		}

		

		if(trim($where) == 'WHERE') {
			$where = '';
		}
		
		$group_by = "";
		$mka_hiving_va = "";
		if($mka_hiving_va != '') {
			$and = 'WHERE ';
			if($where != '') {
				$and = ' AND ';
			}
			$where .= $and."($mka_hiving_va)";
		}

		$limit = SSP::limit( $_GET, $columns );
		$order = SSP::mkaorder( $_GET, $columns, $j );
		$col = SSP::pluck($columns, 'db', $j);
		if(trim($where) == 'WHERE' || trim($where) == 'WHERE ()') {
			$where = '';
		}
		$query = "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." ".$joinQuery." ".$where." ".$group_by." ".$order." ".$limit." ";
		$query_without_limit = "SELECT count('*') AS c ".$joinQuery." ".$where." ";
		$res = $this->db->query($query);
		$res = $res->result_array();
		$recordsTotal = $this->db->query($query_without_limit)->row()->c;
		$res = SSP::mka_data_output($columns, $res, $j);

		$output_arr['draw'] 			= intval( $_GET['draw'] );
		$output_arr['recordsTotal'] 	= intval( $recordsTotal );
		$output_arr['recordsFiltered'] 	= intval( $recordsTotal );
		$output_arr['data'] 			= $res;
		//$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $group_by, $having);
		foreach ($output_arr['data'] as $key => $value) 
		{
			$output_arr['data'][$key][0] = '
					<input type="checkbox" name="selData" id="mka_'.$key.'" value="'.$output_arr['data'][$key][0].'">
					<label for="mka_'.$key.'"></label>
				';
			$key_id = @array_pop(array_keys($output_arr['data'][$key]));
			$id = $output_arr['data'][$key][$key_id];
			$output_arr['data'][$key][$key_id] = '';
			
			if(CheckPermission($table, "all_update")){
			$output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
			}else if(CheckPermission($table, "own_update") && (CheckPermission($table, "all_update")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id');
				if($user_id->user_id==$this->user_id){
			$output_arr['data'][$key][$key_id] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="'.lang('edit').'"><i class="material-icons">mode_edit</i></a>';
				}
			}
			
			if(CheckPermission($table, "all_delete")){
			$output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons col-red font-20">delete</i></a>';}
			else if(CheckPermission($table, "own_delete") && (CheckPermission($table, "all_delete")!=true)){
				$user_id =getRowByTableColomId($table,$id,'id');
				if($user_id->user_id==$this->user_id){
			$output_arr['data'][$key][$key_id] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="'.lang('delete').'" onclick="setId('.$id.', \''.$table.'\')"><i class="material-icons col-red font-20">delete</i></a>';
				}
			}
			
		}
		echo json_encode($output_arr);
  	}
  	/**
      * This function is used to filter list view data by date range
      */
  	public function getFilterdata(){
  		$where = '';
		if($this->input->post('dateRange')) {
			$date = explode(' - ', $this->input->post('dateRange'));
			$where = " DATE_FORMAT(`engineer_details`.`".$this->input->post('colName')."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`engineer_details`.`".$this->input->post('colName')."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' ";
		}
		$data["view_data"]= $this->Engineer_details_model->get_data($where);
		echo $this->load->view("tableData",$data, true);
		die;
  	}

  	public function set_filter_cookie() {
  		if(!empty($this->input->post(strtolower('Engineer_details_filter')))) {
  			setcookie(strtolower('Engineer_details_filter'), json_encode($this->input->post(strtolower('Engineer_details_filter'))), time() + (86400 * 30 * 365), "/");
  		}
  	}


  	public function get_grid_info_box_val() {
		$result = array();
  		if(is_array($this->input->get('request')) && !empty($this->input->get('request'))) {
  			foreach ($this->input->get('request') as $rkey => $rvalue) {
  				if(isset($rvalue['con_field']))
  				$con_field    	= json_decode(str_replace('@m@', '"', $rvalue['con_field']));
  				if(isset($rvalue['con_operator']))
  				$con_operator 	= json_decode(str_replace('@m@', '"', $rvalue['con_operator']));
  				if(isset($rvalue['con_value']))
  				$con_value    	= json_decode(str_replace('@m@', '"', $rvalue['con_value']));
  				if(isset($rvalue['relation']))
  				$relation    	= json_decode(str_replace('@m@', '"', $rvalue['relation']));
  				if(isset($rvalue['relation_table']))
  				$relation_table = json_decode(str_replace('@m@', '"', $rvalue['relation_table']));
  				if(isset($rvalue['relation_from']))
  				$relation_from  = json_decode(str_replace('@m@', '"', $rvalue['relation_from']));
  				if(isset($rvalue['relation_where']))
  				$relation_where = json_decode(str_replace('@m@', '"', $rvalue['relation_where']));
  				$where = '';
  				$join = '';

  				if(!CheckPermission($rvalue['table'], 'all_read') || !CheckPermission($rvalue['table'], 'all_update') || !CheckPermission($rvalue['table'], 'all_delete')) {
					$where = " `".$rvalue['table']."`.`user_id` = '".$this->session->get_userdata()['user_details'][0]->users_id."' AND";
				}

  				if($con_field[0] != '') {
  					foreach ($con_field as $cfkey => $cfvalue) {
  						if(isset($relation[$cfkey]) && $relation[$cfkey] == 'yes') {
  							$join .= " JOIN `".$relation_table[$cfkey]."` ON `".$relation_table[$cfkey]."`.`".$relation_table[$cfkey]."_id` = `".$rvalue['table']."`.`".$relation_from[$cfkey]."` ";
  							$where .= " `".$relation_table[$cfkey]."`.`".$relation_where[$cfkey]."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";
  						} else {
  							$where .= " `".$rvalue['table']."`.`".$cfvalue."` ".get_operator($con_operator[$cfkey])." '".$con_value[$cfkey]."' AND";	
  						}
  					}
  				}

  				if(is_array($this->input->get('request_filter')) && !empty($this->input->get('request_filter'))) {
  					foreach ($this->input->get('request_filter') as $fkey => $fvalue) {
  						if($fvalue != 'all') {
	  						$fkey = explode('___', $fkey);
	  						if($fkey[2] == 'filter_date') {
	  							$date = explode(' - ', $fvalue);
	  							$where .= " DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') >= '".date('Y/m/d', strtotime($date[0]))."' AND  DATE_FORMAT(`".$fkey[0]."`.`".$fkey[1]."`, '%Y/%m/%d') <= '".date('Y/m/d', strtotime($date[1]))."' AND";
	  						} else {
	  							$where .= " `".$fkey[0]."`.`".$fkey[1]."` =  '".$fvalue."' AND";
	  						}
  						}
  					}
  				}

  				if(strpos($where, ' AND') > 0) {
  					$where = substr_replace($where, '', -3);
  				}
  				if($where != '') {
  					$where = 'WHERE '.$where;
  				}
  				if($rvalue['action'] == 'count') {
  					$qr = "SELECT count(*) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
  				} else if($rvalue['action'] == 'sum') {
  					$qr = "SELECT SUM(`".$rvalue['sum_field']."`) AS 'mka_num' FROM `".$rvalue['table']."` ".$join." ".$where." ";
  				}
				$res = $this->Engineer_details_model->getQrResult($qr);
				$result[$rvalue['return_id']] = 0;
				if($res[0]->mka_num != '') {
					$result[$rvalue['return_id']] = $res[0]->mka_num;
				}
  			}
  		}
  		echo json_encode($result);
  		exit;
  	}
}
?>