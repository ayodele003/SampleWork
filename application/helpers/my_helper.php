<?php
/**
*@if(CheckPermission('crm', 'read'))
**/
 function CheckPermission($moduleName="", $method=""){
	 $CI = get_instance();
	$moduleName = strtolower(str_replace(' ', '_', $moduleName));
    $permission = isset($CI->session->get_userdata()['user_details'][0]->user_type)?$CI->session->get_userdata()['user_details'][0]->user_type:'';
    //print_r($permission);die;
    if(isset($permission) && $permission != "" ) 
	{
		
        if($permission == 'admin' || $permission == 'Admin') 
		{
          return true;
        } 
		else 
		{	
			$getPermission = array();
			$getPermission = json_decode(getRowByTableColomId('permission',$permission,'user_type','data'));
			
			
			if (isset($getPermission->$moduleName)) 
			{	
			 
			  if(isset($moduleName) && isset($method) && $moduleName != "" && $method != "" )
			  {		
			  		
			  	   	$method_arr = explode(',',$method);
			  	   	foreach($method_arr as $method_item){ 
				   	if(isset($getPermission->$moduleName->$method_item))
				   	{  
						return $getPermission->$moduleName->$method_item;
					} else {
						//return 0;		
					}
				   
				} 
				//return 0;
              } 
			  else
			  {
                return 0;
              }
			}
			else{return 0;}
       }
    } 
	else 
	{
      return 0;
    }
  }

	function setting_all($keys='')
	{  
		$CI = get_instance();
		if(!empty($keys)){
			$CI->db->select('*');
			$CI->db->from('setting');
			$CI->db->where('keys' , $keys);
			$query = $CI->db->get();
			$result = $query->row();
			if(!empty($result)){
				 $result = $result->value;
				return $result;
			}
			else
			{
				return false;
			}
		}
		else{
			$CI->load->model('setting/setting_model');
			$setting= $CI->setting_model->get_setting();
			return $setting;
		}
		
	}


	function settings() {
		$CI = get_instance();
		$CI->load->model('setting/setting_model');
		$setting= $CI->setting_model->get_setting();
		$result = []; 
		foreach ($setting as $key => $value) {
			$result[$value->keys] = $value->value;
		}
		return $result;
	}

	function getRowByTableColomId($tableName='',$id='',$colom='id',$whichColom='')
	{  
		if($colom == 'id' && $tableName != 'users') {
			$colom = $tableName.'_id';
		}
		$CI = get_instance();
		$CI->db->select('*');
		$CI->db->from($tableName);
		$CI->db->where($colom , $id);
		$query = $CI->db->get();
		$result = $query->row();
			if(!empty($result))
			{	
				if(!empty($whichColom)){
				 $result = $result->$whichColom;
				 return $result;
				}
				else
				{
					return $result;
				}
			}
			else
			{
				return false;
			}
	
	}


	function getOptionValue($keys='')
	{  
		$CI = get_instance();
		$CI->db->select('*');
		$CI->db->from('setting');
		$CI->db->where('keys' , $keys);
		$query = $CI->db->get();
		
		if(!empty($query->row())){return $result = $query->row()->value;}else{return false;}

	}
	
	function getNameByColomeId($tableName='',$id='',$colom='id')
	{ 
		if($colom == 'id') {
			$colom = $tableName.'_id';
		} 
		$CI = get_instance();
		$CI->db->select($colom);
		$CI->db->from($tableName);
		$CI->db->where($tableName.'_id' , $id);
		$query = $CI->db->get();
		return $result = $query->row();

	}
	
	function selectBoxDynamic($field_name='', $tableName='setting',$colom='value',$selected='',$attr='',$whereCol='',$whereVal='')
	{   
		$add_per = 0;
		if(!CheckPermission($tableName, 'all_read') || !CheckPermission($tableName, 'all_update') || !CheckPermission($tableName, 'all_delete')) {
			$add_per = 1;
		}
		$CI = get_instance();
		$CI->db->select('*');
		$CI->db->from($tableName);
		if(!empty($whereCol) && !empty($whereVal)){
			$CI->db->where($whereCol, $whereVal);
		}
		if($add_per == 1) {
			$CI->db->where('user_id', $CI->session->get_userdata()['user_details'][0]->users_id);	
		}
		$query = $CI->db->get();
		if($query->num_rows() > 0) {
		   $catlog_data = $query->result();
		   $res = '';
			$res .='<select class="form-control" id="'.$field_name.'" name="'.$field_name.'" '.$attr.' >';
			$res .= '<option value=""></option>';
				foreach ($catlog_data as $catlogData){ 
				 $select_this = '';
				 	$tab_id = $tableName.'_id';
					if($catlogData->$tab_id == $selected){	$select_this = ' selected ';}
					$res .='<option value="'.$catlogData->$tab_id.'"  '.$select_this.' >'.$catlogData->$colom.'</option>';
				}
			$res .='</select>';
		}
		else 
		{
			$catlog_data = '';
			$res = '';
			$res .='<select class="form-control" id="'.$field_name.'" name="'.$field_name.'" '.$attr.' >';
			$res .= '<option value=""></option>';
			$res .='</select>';
		}
		return $res;
	}

	function MultipleSelectBoxDynamic($field_name='', $tableName='setting',$colom='value',$selected='',$attr='',$whereCol='',$whereVal='')
	{
		$add_per = 0;
		if(!CheckPermission($tableName, 'all_read') || !CheckPermission($tableName, 'all_update') || !CheckPermission($tableName, 'all_delete')) {
			$add_per = 1;
		} 
		$selected = explode(',', $selected);  
		$CI = get_instance();
		$CI->db->select('*');
		$CI->db->from($tableName);
		if(!empty($whereCol) && !empty($whereVal)){
			$CI->db->where($whereCol, $whereVal);
		}
		if($add_per == 1) {
			$CI->db->where('user_id', $CI->session->get_userdata()['user_details'][0]->users_id);	
		}
		$query = $CI->db->get();
		if($query->num_rows() > 0) {
		   $catlog_data = $query->result();
		   $res = '';
			$res .='<select multiple="multiple" class="form-control" id="'.$field_name.'" name="'.$field_name.'[]" '.$attr.' >';
			$res .= '<option value="">Select</option>';
				foreach ($catlog_data as $catlogData){ 
				 $select_this = '';
				 	$tab_id = $tableName.'_id';
					if(in_array($catlogData->$tab_id, $selected)){	$select_this = ' selected ';}
					$res .='<option value="'.$catlogData->$tab_id.'"  '.$select_this.' >'.$catlogData->$colom.'</option>';
				}
			$res .='</select>';
		}
		else 
		{
			$catlog_data = '';
			$res = '';
			$res .='<select class="form-control" id="'.$field_name.'" name="'.$field_name.'" '.$attr.' >';
			$res .='</select>';
		}
		return $res;
	}
		
/*	function fileUpload()
	{	
		$CI =& get_instance();
     	$CI->load->library('email');
		foreach($_FILES as $name => $fileInfo)
		{
			$filename=$_FILES[$name]['name'];
			$tmpname=$_FILES[$name]['tmp_name']; 
			$exp=explode('.', $filename);
			$ext=end($exp);
			$newname=  $exp[0].'_'.time().".".$ext; 
			$config['upload_path'] = 'assets/images/';
			$config['upload_url'] =  base_url().'assets/images/';
			$config['allowed_types'] = "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp";
			$config['max_size'] = '2000000'; 
			$config['file_name'] = $newname;
			$CI->load->library('upload', $config);
			move_uploaded_file($tmpname,"assets/images/".$newname);
			return $newname;
		}
	}*/
	
  function is_login(){ 
      if(isset($_SESSION['user_details'])){
          return true;
      }else{
         redirect( base_url().'user/login', 'refresh');
      }
  }
  function form_safe_json($json) {
    $json = empty($json) ? '[]' : $json ;
    $search = array('\\',"\n","\r","\f","\t","\b","'") ;
    $replace = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "&#039");
    $json = str_replace($search,$replace,$json);
    return strip_tags($json);
}
/*	function CallAPI($method, $url, $data = false)
  {   
	  $curl = curl_init();
	  switch ($method)
	  {   
		  case "POST":
			  curl_setopt($curl, CURLOPT_POST, 1);
			  if ($data)
				  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			  break;
		  case "PUT":
			  curl_setopt($curl, CURLOPT_PUT, 1);
			  break;
		  default:
			  if ($data)
				  $url = sprintf("%s?%s", $url, http_build_query($data));
	  }
	  curl_setopt($curl, CURLOPT_HTTPHEADER, array());
	  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	  curl_setopt($curl, CURLOPT_USERPWD, "");
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  $result = curl_exec($curl);
	  curl_close($curl);
	  return $result;
  }*/
   	function getDataByid($tableName='',$columnValue='',$colume='')
	{  
		$CI = get_instance();
		$CI->db->select('*');
		$CI->db->from($tableName);
		$CI->db->where($colume , $columnValue);
		$query = $CI->db->get();
		return $result = $query->row();
	}
	function getAllDataByTable($tableName='',$columnValue='*',$colume='')
	{  
		$CI = get_instance();
		$CI->db->select($columnValue);
		$CI->db->from($tableName);
		$query = $CI->db->get();
		if($query->num_rows() > 0) {
		   $catlog_data = $query->result();
			return $catlog_data;
		}else {return false;}
	}

	/*function ajx_dataTable($table='',$columns=array(),$Join_condition='', $where = '')
	{

		$table = $table;
    	$primaryKey = $table.'_id';
		$CI = get_instance();
		$CI->load->database();
		$CI->load->library('Ssp');
    	
			if(empty($columns))
			{
				$columns = array(
					array( 'db' => 'name', 'dt' => 0 ),	
					array( 'db' => $table.'_id',  'dt' => 1 )
					);
			}
			$sql_details = array(
				'user' => $CI->db->username,
				'pass' => $CI->db->password,
				'db'   => $CI->db->database,
				'host' => $CI->db->hostname
			);


		
		$output_arr = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $Join_condition, $where);
		
		foreach ($output_arr['data'] as $key => $value) 
		{
				$id = $output_arr['data'][$key][count($output_arr['data'][$key])  - 1];
				$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] = '';
				if(CheckPermission($table, "own_update")){
				$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a sty id="btnEditRow" class="modalButton mClass"  href="javascript:;" type="button" data-src="'.$id.'" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>';
				}
				if(CheckPermission($table, "own_delete")){
				$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<a data-toggle="modal" class="mClass" style="cursor:pointer;"  data-target="#cnfrm_delete" title="delete" onclick="setId('.$id.')"><i class="fa fa-trash-o" ></i></a>';}

		
			$result = getTemplatesByModule($CI->uri->segment(1));
			if(is_array($result) && !empty($result)) {
				$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<div class="btn-group"><a id="btnEditRow" class="mClass dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  href="javascript:;" type="button" data-src="" title="Edit"><i class="fa fa-download" data-id=""></i></a><ul class="dropdown-menu">';
				    foreach ($result as $value) {
					$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .= '<li><a href="#">'.$value->template_name.'</a></li>';    	
				    }
				$output_arr['data'][$key][count($output_arr['data'][$key])  - 1] .=  '</ul> </div>';
			}
		}
		echo json_encode($output_arr);
    }*/

	  function getTemplatesByModule($module){
	  	$CI = get_instance();
	  	$CI->db->select('*');
	  	$CI->db->from('templates');
	  	$CI->db->where('module', $module);
	  	$qr = $CI->db->get();
	  	return $qr->result();
	  }

	function search_in_array_obj($arr, $arrKey, $sVal) {
	  	if(!empty($arr)) {
	    	foreach ($arr as $arkey => $arValue) {
	      		if($sVal == $arValue->$arrKey) {
	        		return true;
	      		}
	    	}    
	  	}
	}


	function get_custom_fields($crud, $rel_crd_id = NULL){
		$html = '';
		$cf_val = array();
		$CI = get_instance();
		$res = $CI->db->select('*')
					  ->where('rel_crud', $crud)
					  ->where('status', 'active')
					  ->get('custom_fields')
					  ->result();
		if($rel_crd_id) {
			$cf_val = $CI->db->select('*')
					  ->where('rel_crud_id', $rel_crd_id)
					  ->get('cf_values')
					  ->result();
		}
		if($res) {
			$html .= '<div class="row">';
			$html .= '<div class="col-md-12">';
			$html .= '<h4> '.lang("custom_fields").' </h4>';
			$html .= '<hr>';
			$html .= '</div>';

			foreach ($res as $rkey => $rvalue) {
				$ls = '';
				$required = '';
				if($rvalue->required == 1) {
					$ls = '<span class="text-red">*</span>';
					$required = 'required';
				}
				$html .= '<div class="col-md-12">';
				$html .= '<div class="form-group form-float">';
				
				$v = '';
				if(!empty($cf_val)) {
					foreach ($cf_val as $cfvkey => $cfvvalue) {
						if($cfvvalue->cf_id == $rvalue->custom_fields_id) {
							$v = $cfvvalue->value;
							break;
						}
					}
				}
				if($rvalue->type == 'text' || $rvalue->type == 'numbers' || $rvalue->type == 'date' || $rvalue->type == 'email') {
					$rvalue->type = $rvalue->type == 'numbers'?'number':$rvalue->type;
					$html .= '<div class="form-line">';
					$html .= '<input type="'.$rvalue->type.'" name="mkacf['.$rvalue->custom_fields_id.']" class="form-control" '.$required.' value="'.$v.'" />';
					$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
					$html .= '</div>';
					
				} else if($rvalue->type == 'text_area') {
					$html .= '<div class="form-line">';
					$html .= '<textarea name="mkacf['.$rvalue->custom_fields_id.']" class="form-control" '.$required.' >'.$v.'</textarea>';
					$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
					$html .= '</div>';
				} else if($rvalue->type == 'options') {
					$html .= '<div class="form-line">';
					$html .= '<select class="form-control" name="mkacf['.$rvalue->custom_fields_id.']" '.$required.' >';
					$html .= '<option value=""></option>';
					$opt = explode(',', $rvalue->options);
					if(is_array($opt) && !empty($opt)) {
						foreach ($opt as $opkey => $opvalue) {
							$opvalue = trim($opvalue);
							$selected = '';
							if($v == $opvalue) {
								$selected = 'selected="selected"';
							}
							$html .= '<option value="'.$opvalue.'" '.$selected.' >'.ucfirst(lang(strtolower($crud).'_'.get_lang($opvalue))).'</option>';
						}
					}
					$html .= '</select>';
					$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
					$html .= '</div>';
				} else if($rvalue->type == 'checkbox') {
					$opt = explode(',', $rvalue->options);
					if(is_array($opt) && !empty($opt)) {
						$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
						foreach ($opt as $opkey => $opvalue) {
							$opvalue = trim($opvalue);
							$checked = '';
							if(in_array($opvalue, explode(',', $v))) {
								$checked = 'checked';
							}
							$html .= '<div class="checkbox">';
							$html .= '<input type="checkbox" id="mka_'.$opvalue.'" value="'.$opvalue.'" name="mkacf['.$rvalue->custom_fields_id.'][]" '.$checked.' '.$required.' class="check_box '.$required.'"   >';
							$html .= '<label for="mka_'.$opvalue.'">'.ucfirst(lang(strtolower($crud).'_'.get_lang($opvalue))).'</label>';
							$html .= '</div>';
						}
					}
				} else if($rvalue->type == 'radio') {
					$opt = explode(',', $rvalue->options);
					if(is_array($opt) && !empty($opt)) {
						$html .= '<label class="form-label">'.ucfirst(lang(get_lang($crud).'_'.get_lang($rvalue->name))).' '.$ls.'</label>';
						foreach ($opt as $opkey => $opvalue) {
							$opvalue = trim($opvalue);
							$checked = '';
							if($opvalue == $v) {
								$checked = 'checked';
							}
							$html .= '<div class="radio">';
							$html .= '<input type="radio" id="mka_r_'.$opvalue.'" value="'.$opvalue.'" name="mkacf['.$rvalue->custom_fields_id.']" '.$checked.' '.$required.'>';
							$html .= '<label for="mka_r_'.$opvalue.'">'.ucfirst(lang(strtolower($crud).'_'.get_lang($opvalue))).'</label>';
							$html .= '</div>';
							$required = '';
						}
					}
				}
				
				$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div>';
		}
		echo $html;
	}

	function get_cf($crud) {
		$CI = get_instance();
		$res = $CI->db->select('*')
					  ->where('rel_crud', $crud)
					  ->where('status', 'active')
					  ->where('show_in_grid', '1')
					  ->get('custom_fields')
					  ->result();

		return $res;	
	}


	function mka_base() {
		return str_replace('index.php/', '', base_url());
	}

	function get_lang($str) {
	    $str = strtolower($str);
	    return $str = str_replace(' ', '_', $str);
    }

    function custom_menus() {
    	$CI = get_instance();
    	$menus = $CI->db->select('*')
    					->where('status', '1')
    					->get('wpb_c_modules')
    					->result();
    	$mka = '';
    	foreach ($menus as $key => $value) {
    		$cl = 'not-active';
    		if($CI->router->class == $value->slug) {
    			$cl = 'active';
    		}
    		$mka .= '<li class="'.$cl.'"> 
                        <a href="'.base_url().$value->slug.'"> 
                        <i class="'.$value->icon.'"></i>   
                        <span>'.$value->menu_name.'</span></a>
                    </li>';	
    	}
    	return $mka;
    }

    function char_limit($string, $length) {
  		if(strlen($string) <= $length) {
    		return $string;
  		} else {
    		$y = substr($string,0,$length) . '...';
    		return $y;
  		}
	}

	function get_operator($opt) {
		switch ($opt) {
	    	case 'equal_to':
	        	return '=';
	        	break;
	    	case 'greater_then':
	        	return '>';
	        	break;
	    	case 'greater_then_equal_to':
	        	return '>=';
	        	break;
	        case 'less_then':
	        	return '<';
	        	break;
	        case 'less_then_equal_to':
	        	return '<=';
	        	break;
	        case 'not_equal_to':
	        	return '!=';
	        	break;
	    	default:
	    		return '=';    	
		}	

	}

	function generateRandomNumber($length = 10, $str = FALSE) {
	    $characters = '0123456789';
		if($str === TRUE) {
			$characters .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

?>