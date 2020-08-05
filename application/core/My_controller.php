<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_controller extends CI_Controller {
	function render($view, $data){
		$this->load->view('templates/header');
		$this->load->view($view, $data);
		$this->load->view('templates/footer');
	}
}
