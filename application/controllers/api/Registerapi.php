<?php

require APPPATH.'libraries/REST_Controller.php';

class Registerapi extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Auth_model');
	}

	//Insert Data
	public function index_post(){
		$data = array();
		$data['name'] = $this->post('name');
		$data['company'] = $this->post('company');
		$data['email'] = $this->post('email');
		$data['mobile'] = $this->post('mobile');
		$data['password'] = $this->post('password');
		if($data != ''){
			$eventinsert = $this->Auth_model->register($data);
			if($eventinsert){
				$this->response(array(
					'status' 	=> True,
					'message' 	=> 'Event Created!'
				), REST_Controller::HTTP_OK);
			}else{
				$this->response(array(
					'status' 	=> FALSE,
					'message' 	=> 'Error found while event created'
				), REST_Controller::HTTP_NOT_FOUND);
			}
		}else{
			$this->response(array(
				'status' 	=> FALSE,
				'message' 	=> 'Page Not Found!'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	//Select Data
	public function index_get($id = 0){
		$user = $this->Auth_model->getuserRows($id);

		if(!empty($user))
		{
			$this->response($user, REST_Controller::HTTP_OK);
		}else{
			$this->response(array(
				'status' 	=> FALSE,
				'message' 	=> 'User not found!'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	//Update Data
	public function index_put(){
		
	}

	//Delete Data
	public function index_delete($id){
		
	}

}
