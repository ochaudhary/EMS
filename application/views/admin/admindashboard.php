<?php
	if($user['adminstatus'] != 'enable'){
		$this->session->unset_userdata('user');
		redirect(base_url().'');
	}
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<main role="main" class="flex-shrink-0">
	<div class="container">
		<h2 class="text-center">Admin Panel</h2>
		<a href="" class="btn btn-info addbtn" data-toggle="modal" data-target="#addEvent">Add Event</a>
		<a href="<?php echo base_url().'user/userlist'?>" class="btn btn-info addbtn">User List</a>
		<table id="eventTable" class="table table-striped table-bordered" style="width:100%">
			<thead>
			<tr>
				<th>No</th>
				<th>Event Name</th>
				<th>Event Day</th>
				<th>Event Subject</th>
				<th>Event Body</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$i = 1;
			foreach($eventlist->result() as $row){
				if($row->eventday == 0){
					$eventday = 'Same Day';
				}else{
					$eventday = $row->eventday;
				}
				?>
				<tr id="eventRow_<?php echo $row->id;?>">
					<td><?php echo $i;?></td>
					<td><?php echo $row->eventname;?></td>
					<td><?php echo $eventday;?></td>
					<td><?php echo $row->subject;?></td>
					<td><?php echo $row->eventinformation;?></td>
					<td><a href="javascript:;" data-toggle="modal" data-target="#editEvent_<?php echo $row->id;?>">Edit</a></td>
					<td><a href="javascript:;" data-toggle="modal" data-target="#delEvent_<?php echo $row->id;?>">Delete</a></td>
				</tr>
				<?php
				$i++;
			}
			?>
			</tbody>
		</table>
	</div>
</main>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- Add Event -->
<div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Create New Event</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body eventAddForm text-center">
				<?php echo form_open('user/addevent', 'id=createEvent');?>
				<?php
				$msgErr = $this->session->flashdata('msg');
				if($msgErr !=''){
					echo '<p class="inputErr">'.$msgErr.'</p>';
				}
				?>
				<div class="row">
					<div class="col-12">
						<input type="text" value="<?php echo set_value('eventname')?>" id="eventname" class="fadeIn second" name="eventname" placeholder="Enter event name">
						<p class="inputErr inputNameErr"><?php echo strip_tags(form_error('eventname'))?></p>
					</div>
					<div class="col-md-6 col-12">
						<input type="number" value="<?php echo set_value('eventday')?>" id="eventday" class="fadeIn second" name="eventday" placeholder="Enter event day">
						<p class="inputErr inputLocErr"><?php echo strip_tags(form_error('eventday'))?></p>
					</div>
					<div class="col-md-6 col-12">
						<input type="text" value="<?php echo set_value('subject')?>" id="subject" class="fadeIn second" name="subject" placeholder="Enter event subject">
						<p class="inputErr inputLocErr"><?php echo strip_tags(form_error('subject'))?></p>
					</div>
					<div class="col-12">
						<textarea value="<?php echo set_value('eventinformation')?>" id="eventinfo" class="fadeIn second" name="eventinformation" placeholder="Enter email body"></textarea>
						<p class="inputErr inputInfoErr"><?php echo strip_tags(form_error('eventinfo'))?></p>
					</div>
					<input type="hidden" value="<?php echo $user['id'];?>" name="createdby">
				</div>
				<button id="createEventBtn" class="btn btn-info addbtn">Create Event</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal for Update and Delete Event -->
<?php
foreach($eventlist->result() as $row){
?>

<!-- Modal for Update Event -->
<div class="modal fade" id="editEvent_<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="editEventModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Update Event</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body eventAddForm text-center">
				<?php echo form_open('user/updateevent', 'id=updateEvent_'.$row->id);?>
				<?php
				$msgErr = $this->session->flashdata('msg');
				if($msgErr !=''){
					echo '<p class="inputErr">'.$msgErr.'</p>';
				}
				?>
				<div class="row">
					<div class="col-12">
						<input type="text" value="<?php echo $row->eventname; ?>" id="eventnameedit_<?php echo $row->id;?>" class="fadeIn second" name="eventname" placeholder="Enter event name">
						<p class="inputErr inputNameErr"><?php echo strip_tags(form_error('eventname'))?></p>
					</div>
					<div class="col-md-6 col-12">
						<input type="text" value="<?php echo $row->eventday; ?>" id="eventdaydit_<?php echo $row->id;?>" class="fadeIn second" name="eventday" placeholder="Enter day">
						<p class="inputErr inputLocErr"><?php echo strip_tags(form_error('eventday'))?></p>
					</div>
					<div class="col-md-6 col-12">
						<input type="text" value="<?php echo $row->subject; ?>" placeholder="Enter event subject" name="subject" class="dateselect subjectedit_<?php echo $row->id;?>" id='subjectedit_<?php echo $row->id;?>' >
						<p class="inputErr inputDateErr"><?php echo strip_tags(form_error('subject'))?></p>
					</div>
					<div class="col-12">
						<textarea value="<?php echo set_value('eventinformation')?>" id="eventinfoedit_<?php echo $row->id;?>" class="fadeIn second eventinfo" name="eventinformation" placeholder="Enter event body"><?php echo $row->eventinformation; ?></textarea>
						<p class="inputErr inputInfoErr"><?php echo strip_tags(form_error('eventinformation'))?></p>
					</div>
					<input type="hidden" value="<?php echo $row->id;?>" name="eventid">
				</div>
				<button type="button" id="editEventBtn" onclick="updateEvent(<?php echo $row->id;?>)" class="btn btn-info addbtn editEventBtn">Update Event</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!-- Modal for Delete Event -->
<div class="modal fade" id="delEvent_<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="delEventModalLabel_<?php echo $row->id;?>" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Delete Event</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body eventAddForm text-center">
				Are sure you want to delete event of <strong><?php echo $row->eventname?></strong>.<br><br>
				<button id="delEventBtn" data="<?php echo $row->id;?>" class="btn btn-info addbtn delEventBtn">Delete Event</button>
			</div>
		</div>
	</div>
</div>

<?php
}
?>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
	$('#eventList').DataTable();
	$(document).ready( function() {
		$("#eventinfo").summernote({
			placeholder: 'Email Content',
			tabsize: 2,
			height: 120,
		});
		$(".eventinfo").summernote({
			placeholder: 'Email Content',
			tabsize: 2,
			height: 120,
		});
	});
</script>

