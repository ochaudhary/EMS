<?php

require APPPATH.'libraries/REST_Controller.php';

class Userapi extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Auth_model');
	}

	//Insert Data
	public function index_post(){
		$data = array();
		$data['eventname'] = $this->post('eventname');
		$data['eventday'] = $this->post('eventday');
		$data['subject'] = $this->post('subject');
		$data['eventinformation'] = $this->post('eventinformation');
		$data['createdby'] = $this->post('createdby');
		if($data != ''){
			$eventinsert = $this->Auth_model->createevent($data);
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
		//$this->Auth_model->apiselect($data);
	}

	//Select Data
	public function index_get($id = 0){
		$user = $this->Auth_model->getRows($id);

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
		$data = array();
		$evenID = $this->put('id');
		$data['eventname'] = $this->put('eventname');
		$data['eventday'] = $this->put('eventday');
		$data['subject'] = $this->put('subject');
		$data['eventinformation'] = $this->put('eventinformation');
		if($data != ''){
			$eventinsert = $this->Auth_model->updateevent($data, $evenID);
			if($eventinsert){
				$this->response(array(
					'status' 	=> True,
					'message' 	=> 'Event Updated!'
				), REST_Controller::HTTP_OK);
			}else{
				$this->response(array(
					'status' 	=> FALSE,
					'message' 	=> 'Error found while event updating'
				), REST_Controller::HTTP_NOT_FOUND);
			}
		}else{
			$this->response(array(
				'status' 	=> FALSE,
				'message' 	=> 'Page Not Found!'
			), REST_Controller::HTTP_NOT_FOUND);
		}
		//$updateevent = $this->Auth_model->updateevent($updateEvent, $eventid);
	}

	//Delete Data
	public function index_delete($id){
		$delevent = $this->Auth_model->delevent($id);

		if($delevent)
		{
			$this->response(array(
				'status' 	=> TRUE,
				'message' 	=> 'Event Deleted!'
			), REST_Controller::HTTP_OK);
		}else{
			$this->response(array(
				'status' 	=> FALSE,
				'message' 	=> 'Event not found!'
			), REST_Controller::HTTP_NOT_FOUND);
		}
	}

	//Register Data
	public function register_post(){
		echo 1234;
	}
}
