<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturnBattery extends CI_Controller {

	public function index()
	{
	}

	public function doReturn() {
        $curTradeNo = $this->input->get('tradeNo');
        $returnDate = date('Y-m-d H:i:s', strtotime('now'));

		$query = $this->db->query('SELECT * FROM powerBanks WHERE curTradeNo=?', [$curTradeNo]);
		$row = $query->row_array();
		if (isset($row)) {
			$this->db->query('UPDATE powerBanks SET returnDate=? WHERE curTradeNo=?', 
				[$returnDate, $curTradeNo]
			);
		}

		$this->load->view('layouts/header', ['title' => 'You have returned battery.']);
		$this->load->view('return/thankyou');
        $this->load->view('layouts/footer');
	}

}
