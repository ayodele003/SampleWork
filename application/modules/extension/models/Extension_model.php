<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Extension_model extends CI_Model {       
	function __construct(){            
    parent::__construct();
    $this->load->database();
		$this->user_id =isset($this->session->get_userdata()['user_details'][0]->users_id)?$this->session->get_userdata()['user_details'][0]->users_id:'1';
	} 
	

	/**
      * This function is used to Insert Record in table
      * @param : $table - table name in which you want to insert record 
      * @param : $data - record array 
      */
	public function insertRow($table, $data){
	  	$this->db->insert($table, $data);
	  	return  $this->db->insert_id();
	}

	/**
      * This function is used to Update Record in table
      * @param : $table - table name in which you want to update record 
      * @param : $col - field name for where clause 
      * @param : $colVal - field value for where clause 
      * @param : $data - updated array 
      */
  	public function updateRow($table, $col, $colVal, $data) {
  		$this->db->where($col,$colVal);
		$this->db->update($table,$data);
		return true;
  	}
  	
   /**
     * This function is used to select data form table  
     */
	public function get_data_by($tableName='', $value='', $colum='',$condition='') {	
		if( (!empty($value)) && (!empty($colum)) ) { 
			$this->db->where($colum, $value);
		}
		$this->db->select('*');
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
  	}

  	public function delete_extn_db_action($data) {
  		/*----------  Remove From Menu  ----------*/
  		$this->db->where('menu_name', $data->name)->delete('wpb_c_modules');

  		/*----------  Remove Permissions  ----------*/
  		$per = $this->get_data_by('permission');
  		if(is_array($per) && !empty($per)) {
			foreach ($per as $perkey => $pervalue) {
				$rec = json_decode($pervalue->data, 1);
				unset($rec[$data->name]);
				$perdata = array("data" => json_encode($rec));
				$this->em->updateRow('permission', 'id', $pervalue->id, $perdata);
			}
	    }

	    /*----------  Remove table of module  ----------*/
	    $this->load->dbforge();
	    $tbls = explode(',', $data->db_tables);
	    foreach ($tbls as $key => $value) {
	    	$this->dbforge->drop_table($value,TRUE);
	    }


	    /*----------  Remove Dependencies  ----------*/
	    if(isset($data->rm_queries) && $data->rm_queries != '') {
	    	$qry = explode(';', $data->rm_queries);
	    	foreach ($qry as $key => $value) {
	    		$this->db->query($value);
	    	}
	    }

	    /*----------  Remove Record from extension table  ----------*/
	    $this->db->where('name', $data->name)->delete('wpb_extension');

	    return true;
  	}

  	public function check_enable_status($name) {
        return $this->db->where('name', $name)
                        ->where('status', 1)
                        ->get('wpb_extension')->result();
    }
}?>