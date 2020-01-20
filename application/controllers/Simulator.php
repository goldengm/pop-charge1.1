<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simulator extends CI_Controller {

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

	public function index()
	{
		return 'ok';
	}

	public function cabinetInfo() {
		$input = json_decode(file_get_contents('php://input'),true); 
		$sign = $input['sign'];
		$stationNo = $input['body']['stationSn'][0];

		$list = [];
		$powerBank = ['powerBankSn'=>'PF1907010000001', 'electricQuantity'=>83, 'slotNum'=>1, 'curTradeNo'=>null];
		$list[] = $powerBank;
		$powerBank = ['powerBankSn'=>'aww2019030233', 'electricQuantity'=>100, 'slotNum'=>2, 'curTradeNo'=>null];
		$list[] = $powerBank;
		$powerBank = ['powerBankSn'=>'PF1907010000003', 'electricQuantity'=>83, 'slotNum'=>3, 'curTradeNo'=>null];
		$list[] = $powerBank;
		$powerBank = ['powerBankSn'=>'NULL', 'electricQuantity'=>1, 'slotNum'=>4, 'curTradeNo'=>null];
		$list[] = $powerBank;
		$powerBank = ['powerBankSn'=>'NULL', 'electricQuantity'=>1, 'slotNum'=>5, 'curTradeNo'=>null];
		$list[] = $powerBank;
		$powerBank = ['powerBankSn'=>'NULL', 'electricQuantity'=>1, 'slotNum'=>6, 'curTradeNo'=>null];
		$list[] = $powerBank;

		$bodyData = ["lastupline"=>null, "lastActive"=>"2019-09-04 10:38:38", "signalStrength"=>null, "isOnline"=>0,
			"list"=>$list, "slotTotal"=>6, "lac"=>null, "slotStatus"=>"121111", "versions"=>null, "lastdownline"=>"2019-09-16 23:40:38",
			"imei"=>null, "topic"=>"/root/", "ci"=>null, "stationSn"=>"T1219071904", "status"=>1];
		$data = ["msg"=>"1", "code"=>"200", "sign"=>"efe1d563a3abf8558f32f573a4fd8cbe", "body"=>[$bodyData]];

		echo json_encode($data);
	}


}
