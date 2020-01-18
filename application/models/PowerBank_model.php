<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PowerBank_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	public function insert($data) { 
		if ($this->db->insert("powerBanks", $data)) { 
			return true; 
		} 
    } 

    public function delete($powerBankNo) {
    	if ($this->db->delete('powerBanks', 'powerBankNo='.$powerBankNo)) {
    		return true;
    	}
    }

}