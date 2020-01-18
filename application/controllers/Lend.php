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

	
}
