<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Auth_model');
		//$this->sendnotifyUser();
	}

	// Landing Page
	public function index()
	{
		if($this->Auth_model->authorized() == true){
			redirect(base_url().'user/admindashboard');
		}
		$this->load->view('template/header');
		$this->load->view('signin');
		$this->load->view('template/footer');
	}

	//Login
	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == true){
			$email = $this->input->post('email');
			$user = $this->Auth_model->checkUser($email);

			if(!empty($user)){
				$password = $this->input->post('password');
				if(password_verify($password, $user['password']) == true){
					$sarray['id'] = $user['id'];
					$sarray['name'] = $user['name'];
					$sarray['email'] = $user['email'];
					$sarray['adminstatus'] = $user['adminstatus'];
					$this->session->set_userdata('user',$sarray);
					if($user['adminstatus'] == 'enable'){
						redirect(base_url().'user/admindashboard');
					}else{
						redirect(base_url().'user/userdashboard');
					}
				}else{
					$this->session->set_flashdata('msg', 'Incorrect Email id or Password!');
					redirect(base_url().'');
				}
			}else{
				$this->session->set_flashdata('msg', 'Incorrect Email id or Password!');
				redirect(base_url().'');
			}
		}else{
			$this->load->view('template/header');
			$this->load->view('signin');
			$this->load->view('template/footer');
		}
	}

	// Register User
	public function register()
	{
		if($this->Auth_model->authorized() == True){
			redirect(base_url().'user/userdashboard');
		}
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == true){
			$email = $this->input->post('email');
			$user = $this->Auth_model->checkUser($email);

			if(!empty($user)){
				$this->session->set_flashdata('msg', 'Email Already Exist!');
				redirect(base_url().'user/register');
			}else{
				$registerdata = array(
					'name' 		=> $this->input->post('name'),
					'company' 	=> $this->input->post('company'),
					'email' 	=> $this->input->post('email'),
					'mobile' 	=> $this->input->post('mobile'),
					'password'	=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				);
				//$regUser = $this->Auth_model->register($registerdata);

				$api_url = base_url()."api/registerapi";
				$this->load->library('curl');
				$username = 'admin';
				$password = '1234';
				$apikey	= 'om@12345';
				$this->curl->create($api_url);
				$this->curl->option(CURLOPT_BUFFERSIZE, 10);
				$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
				$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
				$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey)));
				$this->curl->options(array(CURLOPT_POST => 1));
				$this->curl->options(array(CURLOPT_POSTFIELDS => $registerdata));
				$this->curl->option('buffersize', 10);
				$this->curl->http_login($username, $password);
				$result = $this->curl->execute();
				if($result){
					$user = $this->Auth_model->checkUser($email);
					$sarray['id'] = $user['id'];
					$sarray['name'] = $user['name'];
					$sarray['email'] = $user['email'];
					$sarray['mobile'] = $user['mobile'];
					$sarray['adminstatus'] = $user['adminstatus'];
					$this->session->set_userdata('user',$sarray);
					if($user['adminstatus'] == 'enable'){
						redirect(base_url().'user/admindashboard');
					}else{

						//Send Welcome Kit
						$this->notifyUser();
						$this->sendnotifyUser();
						$this->session->set_flashdata('msg', 'Welcome to EMS board.');
						redirect(base_url().'user/userdashboard');
					}
				}else{
					$this->session->set_flashdata('msg', 'Email Already Exist!');
					redirect(base_url().'user/register');
				}
			}
		}else{
			$this->load->view('template/header');
			$this->load->view('register');
			$this->load->view('template/footer');
		}
	}

	// Access to admin dashboard
	function admindashboard()
	{
		if($this->Auth_model->authorized() == false){
			$this->session->set_flashdata('msg', 'Your are not logged In');
			redirect(base_url().'');
		}
		$user = $this->session->userdata('user');
		$eventlist = $this->Auth_model->eventlist();
		$data['user'] = $user;
		$data['eventlist'] = $eventlist;
		$this->load->view('template/header', $data);
		$this->load->view('admin/admindashboard', $data);
		$this->load->view('template/footer', $data);
	}

	// Access to user dashboard
	function userdashboard()
	{
		if($this->Auth_model->authorized() == false){
			$this->session->set_flashdata('msg', 'Your are not logged In');\
			redirect(base_url().'');
		}
		$user = $this->session->userdata('user');
		$data['user'] = $user;

		$api_url = base_url()."api/registerapi";
		$this->load->library('curl');
		$username = 'admin';
		$password = '1234';
		$apikey	= 'om@12345';
		$this->curl->create($api_url);
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
		$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
		$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey)));
		$this->curl->option('buffersize', 10);
		$this->curl->http_login($username, $password);
		$result = $this->curl->execute();
		$this->curl->close();
		$data['useractlist'] = $result;

		$this->load->view('template/header', $data);
		$this->load->view('users/userdashboard', $data);
		$this->load->view('template/footer', $data);
	}

	function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url().'');
	}

	function addevent(){
		if($this->Auth_model->authorized() == false){
			$this->session->set_flashdata('msg', 'Your are not logged In');\
				redirect(base_url().'');
		}
		$this->form_validation->set_rules('eventname', 'Event Name', 'required');
		$this->form_validation->set_rules('eventday', 'Event Day', 'required');
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('eventinformation', 'Event Information', 'required');

		if($this->form_validation->run() == true){
			$datetext=$this->input->post('eventdate');
			$newDate = date("Y-m-d", strtotime($datetext));
			$adEvent = array(
				'eventname' 		=> $this->input->post('eventname'),
				'eventday' 			=> $this->input->post('eventday'),
				'subject' 			=> $this->input->post('subject'),
				'eventinformation' 	=> $this->input->post('eventinformation'),
				'createdby' 		=> $this->input->post('createdby'),
			);
			$api_url = base_url()."api/userapi";
			$this->load->library('curl');
			$username = 'admin';
			$password = '1234';
			$apikey	= 'om@12345';
			$this->curl->create($api_url);
			$this->curl->option(CURLOPT_BUFFERSIZE, 10);
			$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
			$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
			$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey)));
			$this->curl->options(array(CURLOPT_POST => 1));
			$this->curl->options(array(CURLOPT_POSTFIELDS => $adEvent));
			$this->curl->option('buffersize', 10);
			$this->curl->http_login($username, $password);
			$result = $this->curl->execute();
			$this->notifyUser();
			echo $result;
			$this->curl->close();
			/*$user = $this->Auth_model->createevent($adEvent);
			if($user == True){
				$this->notifyUser();
			}else{
				echo 2;
			}
			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);*/
		}else{
			echo 'Error Found Validation Failed!';
		}
	}

	// Edit Event
	public function updateevent(){
		if($this->Auth_model->authorized() == false){
			$this->session->set_flashdata('msg', 'Your are not logged In');\
				redirect(base_url().'');
		}
		$this->form_validation->set_rules('eventname', 'Event Name', 'required');
		$this->form_validation->set_rules('eventday', 'Event Day', 'required');
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('eventinformation', 'Event Information', 'required');

		if($this->form_validation->run() == true){
			$datetext=$this->input->post('eventdate');
			$newDate = date("Y-m-d", strtotime($datetext));
			$eventid = $this->input->post('eventid');
			$updateEvent = array(
				'id' 				=> $eventid,
				'eventname' 		=> $this->input->post('eventname'),
				'eventday' 			=> $this->input->post('eventday'),
				'subject' 			=> $this->input->post('subject'),
				'eventinformation' 	=> $this->input->post('eventinformation'),
			);
			$api_url = base_url()."api/userapi";
			$this->load->library('curl');
			$username = 'admin';
			$password = '1234';
			$apikey	= 'om@12345';
			$this->curl->create($api_url);
			$this->curl->option(CURLOPT_BUFFERSIZE, 10);
			$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
			$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
			$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey, 'Content-Type: application/x-www-form-urlencoded')));
			$this->curl->options(array(CURLOPT_CUSTOMREQUEST => "PUT"));
			$this->curl->options(array(CURLOPT_POSTFIELDS => http_build_query($updateEvent)));
			$this->curl->option('buffersize', 10);
			$this->curl->http_login($username, $password);
			$result = $this->curl->execute();
			echo $result;
			$this->curl->close();
			/*
			$updateevent = $this->Auth_model->updateevent($updateEvent, $eventid);
			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);*/
		}else{
			echo 'Error Found Validation Failed!';
		}
	}

	// Delete Event
	public function deleteevent($delid){
		$api_url = base_url()."api/userapi/".$delid;
		$this->load->library('curl');
		$username = 'admin';
		$password = '1234';
		$apikey	= 'om@12345';
		$this->curl->create($api_url);
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
		$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
		$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey)));
		$this->curl->options(array(CURLOPT_CUSTOMREQUEST => "DELETE"));
		$this->curl->options(array(CURLOPT_RETURNTRANSFER => 1));
		$this->curl->option('buffersize', 10);
		$this->curl->http_login($username, $password);
		$result = $this->curl->execute();
		echo $result;
		$this->curl->close();
		//$this->Auth_model->delevent($delid);
	}

	// Notification to user as per the event created by admin
	public function notifyUser(){
		$usernotify = $this->Auth_model->notifyUser();
	}

	// Send email to user as per admin event set to Cron Jobs
	public function sendnotifyUser(){
		$todaydate = new DateTime();
		$datetoday = $todaydate->format('Y-m-d');
		$sendnotify = $this->Auth_model->sendnotifyUser();
		//print_r($sendnotify);
		foreach ($sendnotify as $row){
			$userdetail = $this->Auth_model->userdetail($row->userid);
			$username 	= $userdetail['name'];
			$useremail	= $userdetail['email'];
			$userdate	= $userdetail['createddate'];

			$eventdetail = $this->Auth_model->eventdetail($row->eventid);
			$eventname 			= $eventdetail['eventname'];
			$eventday 			= $eventdetail['eventday'];
			$subject 			= $eventdetail['subject'];
			$eventinformation 	= $eventdetail['eventinformation'];

			$date = strtotime($userdate);
			$date = strtotime("+".$eventday." day", $date);
			$date = date('Y-m-d', $date);
			if($datetoday == $date){
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'smtp.gmail.com',
					'smtp_port' => 587,
					'smtp_user' => 'ochaudhary88@gmail.com',
					'smtp_pass' => 'mynameisom',
					'mailtype' => 'html',
					'wordwrap' => TRUE
				);
				$this->load->library('email', $config);

				$this->email->set_newline("\r\n");

				$this->email->from('ochaudhary88@gmail.com', 'Om');
				$this->email->to($useremail);

				$this->email->subject($subject);

				//bydefault notify as 1 due to issue in email localhost
				//$this->Auth_model->updatenotify($row->eventid, $row->userid);
				$this->email->message($eventinformation);
				if (!$this->email->send()){
					show_error($this->email->print_debugger());
					echo 'Email Failed';
				}else{
					echo 'E-mail has been sent!';
					$this->Auth_model->updatenotify($row->eventid, $row->userid);
				}
			}
		}
	}

	public function userlist(){
		if($this->Auth_model->authorized() == false){
			$this->session->set_flashdata('msg', 'Your are not logged In');
			redirect(base_url().'');
		}
		$user = $this->session->userdata('user');
		$eventlist = $this->Auth_model->eventlist();
		$data['user'] = $user;
		$data['eventlist'] = $eventlist;

		$api_url = base_url()."api/userapi";
		$this->load->library('curl');
		$username = 'admin';
		$password = '1234';
		$apikey	= 'om@12345';
		$this->curl->create($api_url);
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
		$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
		$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey)));
		$this->curl->option('buffersize', 10);
		$this->curl->http_login($username, $password);
		$result = $this->curl->execute();
		$this->curl->close();
		$data['userlistspi'] = $result;
		$this->load->view('template/header', $data);
		$this->load->view('admin/userlist', $data);
		$this->load->view('template/footer', $data);
	}

	function useractivity()
	{
		if($this->Auth_model->authorized() == false){
			$this->session->set_flashdata('msg', 'Your are not logged In');\
				redirect(base_url().'');
		}

		$user = $this->session->userdata('user');
		$data['user'] = $user;

		$api_url = base_url()."api/registerapi";
		$this->load->library('curl');
		$username = 'admin';
		$password = '1234';
		$apikey	= 'om@12345';
		$this->curl->create($api_url);
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
		$this->curl->options(array(CURLOPT_HTTPAUTH => CURLAUTH_ANY));
		$this->curl->options(array(CURLOPT_HTTPHEADER => array("X-API-KEY: ".$apikey)));
		$this->curl->option('buffersize', 10);
		$this->curl->http_login($username, $password);
		$result = $this->curl->execute();
		$this->curl->close();
		$data['useractlist'] = $result;
		$this->load->view('template/header', $data);
		$this->load->view('users/useractivity', $data);
		$this->load->view('template/footer', $data);
	}

	// Api fetch
	public function apifetch(){
		$api_url = base_url()."api/userapi";
		$this->load->library('curl');
		$username = 'admin';
		$password = '1234';
		$this->curl->create($api_url);
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
		$this->curl->option('buffersize', 10);
		$this->curl->http_login($username, $password);

		// Post - If you do not use post, it will just run a GET request
		//$post = array('foo'=>'bar');
		//$this->curl->post($post);

		$result = $this->curl->execute();
		$data['userlistspi'] = $result;
		$this->curl->close();
	}
}
