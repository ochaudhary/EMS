<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	// admin login reture data using email id
	public function checkUser($email){
		$this->db->where('email', $email);
		return $row = $this->db->get('user')->row_array();
	}

	//User Data
	function authorized(){
		$user = $this->session->userdata('user');
		if(!empty($user)){
			return true;
		}else{
			return false;
		}
	}

	//Register
	function register($data){
		if($this->db->insert('user',$data)){
			return True;
		}else{
			return False;
		}
	}

	// Event Created
	function createevent($adEvent){
		if($this->db->insert('createevent',$adEvent)){
			return True;
		}else{
			return False;
		}
	}

	//List of Event fetch
	function eventlist(){
		$query = $this->db->get('createevent');
		return $query;
	}

	//Edit or update Event
	function updateevent($updateEvent, $eventid){
		$this->db->where('id', $eventid);
		$udateevent = $this->db->update('createevent', $updateEvent);
		if($udateevent){
			return True;
		}else{
			return False;
		}
	}

	//Delete Event
	function delevent($delid){
		$this->db->where('id', $delid);
		$this->db->delete('createevent');

		$this->db->where('eventid', $delid);
		$udateevent = $this->db->delete('usernotify');
		if($udateevent){
			return True;
		}else{
			return False;
		}
	}

	//insert into column in usernotify to User
	public function notifyUser(){
		$this->db->select('id');
		$this->db->from('createevent');
		$query = $this->db->get();
		foreach($query->result() as $row){
			$eventID = $row->id;
			$this->db->select('id');
			$this->db->from('user');
			$queryuser = $this->db->get();
			foreach($queryuser->result() as $rowuser){
				$userID = $rowuser->id;
				$usernotify = array(
					'userid' 		=> $userID,
					'eventid ' 		=> $eventID,
				);
				$this->db->select('*');
				$this->db->from('usernotify');
				$this->db->where('userid', $userID);
				$this->db->where('eventid', $eventID);
				$query = $this->db->get();
				if ($query->num_rows() == 0)
				{
					$this->db->insert('usernotify',$usernotify);
				}
			}
		}
	}

	public function sendnotifyUser(){
		$this->db->select('*');
		$this->db->from('usernotify');
		$this->db->where('eventstatus', 0);
		$query = $this->db->get();
		return $query->result();
	}

	public function userdetail($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		return $row = $this->db->get('user')->row_array();
	}

	public function eventdetail($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		return $row = $this->db->get('createevent')->row_array();
	}

	public function updatenotify($eventid, $userid){
		$date = new DateTime();
		$date = $date->format('Y-m-d ');
		$updateEvent = array(
			'eventstatus' 	=> 1,
			'date'	 		=> $date
		);
		$this->db->where('eventid', $eventid);
		$this->db->where('userid', $userid);
		$this->db->update('usernotify', $updateEvent);
	}

	public function getRows($id = 0){
		$this->db->select('*');
		$this->db->from('usernotify');
		$this->db->where('eventstatus !=', 0);
		if($id != 0){
			$this->db->where('userid', $id);
		}
		$query = $this->db->get();
		return $query->result();

	}

	public function getuserRows($id = 0){
		return 1;
	}
}
