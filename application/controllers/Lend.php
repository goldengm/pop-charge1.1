<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lend extends CI_Controller {

	public function index()
	{
		$stationSn = $this->input->get('stationSn');
		$this->load->view('layouts/header', ['title' => 'Lend A Power Bank.']);
		$this->load->view('lend/page_content', compact('stationSn'));
		$this->load->view('layouts/footer');
	}
}
