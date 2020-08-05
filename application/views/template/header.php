<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Management System</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark">
	<div class="container">
		<div class="navbar-header">
			<?php
				if(isset($user['adminstatus'])){
					if($user['adminstatus'] == 'enable'){
						$mainlink = base_url().'user/admindashboard';
					}else{
						$mainlink = base_url().'user/userdashboard';
					}
				}else{
					$mainlink = base_url();
				}
			?>
			<a class="navbar-brand" href="<?php echo $mainlink;?>">EMS</a>
		</div>
		<ul class="nav navbar-nav navbar-right">
			<?php if(isset($user)){
				?>
					<li class="userName">Welcome, <?php echo $user['name'];?></li>
					<li><a href="<?php echo base_url();?>user/logout">Logout</a></li>
				<?php
			}else{
				?>
					<li><a href="<?php echo base_url();?>"> Login</a></li>
				<?php
			}
			?>
		</ul>
	</div>
</nav>

