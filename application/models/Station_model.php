<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Station_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	public function insert($stationNo, $data) { 
		if ($this->db->insert("stations", $data)) { 
			return true; 
		} 
    } 

    public function delete($stationNo) {
    	if ($this->db->delete('stations', 'stationNo='.$stationNo)) {
    		return true;
    	}
    }

}