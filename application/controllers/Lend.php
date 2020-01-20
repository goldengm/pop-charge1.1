<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lend extends CI_Controller {

	public function index()
	{
		$sign = $this->input->get('sign');
		$stationSn = $this->input->get('stationSn');
		$this->load->view('layouts/header', ['title' => 'Lend A Power Bank.']);
		$this->load->view('lend/page_content', compact('sign', 'stationSn'));
		$this->load->view('layouts/footer');
	}

	public function doLend() {
		$input = json_decode(file_get_contents('php://input'),true); 
		$curTradeNo = $input['body']['tradeNo'];
		$powerBankNo = $input['body']['powerBankSn'];
		$slotNum = $input['body']['slotNum'];
		$msg = $input['body']['msg'];
		$lendDate = date('Y-m-d H:i:s', strtotime('now'));

		$query = $this->db->query('SELECT * FROM powerBanks WHERE powerBankNo=?', [$powerBankNo]);
		$row = $query->row_array();
		if (isset($row)) {
			$this->db->query('UPDATE powerBanks SET slotNum=?, curTradeNo=?, msg=?, lendDate=? WHERE powerBankNo=?', 
				[$slotNum, $curTradeNo, $msg, $lendDate, $powerBankNo]
			);
		} else {
			$this->db->query('INSERT INTO powerBanks(powerBankNo, slotNum, curTradeNo, msg, lendDate) VALUES(?, ?, ?, ?, ?)', 
				[$powerBankNo, $slotNum, $curTradeNo, $msg, $lendDate]
			);
		}
	}

	public function checkDoneLend() {
		$input = json_decode(file_get_contents('php://input'),true); 
		$curTradeNo = $input['tradeNo'];

		$query = $this->db->query('SELECT * FROM powerBanks WHERE curTradeNo=?', [$curTradeNo]);
		$row = $query->row_array();
		if (isset($row)) {
			if (time() - strtotime($row['lendDate']) < 15 * 60) {
				echo json_encode(['result'=>true]);
				return;
			}
			echo json_encode(['result'=>false]);
		} else {
			echo json_encode(['result'=>false]);
		}		
	}

	
}
