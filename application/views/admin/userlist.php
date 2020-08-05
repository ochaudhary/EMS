<?php
if($user['adminstatus'] != 'enable'){
	$this->session->unset_userdata('user');
	redirect(base_url().'');
}
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<main role="main" class="flex-shrink-0">
	<div class="container">
		<h2 class="text-center">User Activity Using API</h2>
		<a href="<?php echo base_url().'user/admindashboard'?>" class="btn btn-info addbtn">Event Page</a>
		<?php
		if(isset($userlistspi)){
			$arr = json_decode($userlistspi, true);
			if($arr != ''){
				$i = 1;
				foreach ($arr as $row){
					$date=@date_create($row['date']);
					$date = date_format($date,"Y/m/d H:s A");
					echo "<p>$i. User-ID = $row[userid] logged in Event-ID = $row[eventid] on $date using API </p> ";
					$i++;
				}
			}
		}else{
			echo '<p>No activity</p>';
		}
		?>
	</div>
</main>
