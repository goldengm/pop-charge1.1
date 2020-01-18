<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PowerBank_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	public function insert($data) { 
		if ($this->db->insert("power_bank_logs", $data)) { 
			return true; 
		} 
    } 

    public function delete($powerBankNo) {
    	if ($this->db->delete('power_bank_logs', 'power_bank_no='.$powerBankNo)) {
    		return true;
    	}
    }

}