$('.dateselect').datepicker({
	format: 'mm/dd/yyyy',
	startDate: '+1d'
});

// Create event using ajax
$('#createEventBtn').click(function(e){
	e.preventDefault();
	var error = 0;
	var eventname = $("#eventname").val();
	var eventday = $("#eventday").val();
	var subject = $("#subject").val();
	var eventinfo = $("#eventinfo").val();
	if(eventname == ''){
		$('.inputNameErr').html('Event Name Required');
		error = 1;
	}else{
		$('.inputNameErr').empty();
	}
	if(subject == ''){
		$('.inputLocErr').html('Event Name Required');
		error = 1;
	}else{
		$('.inputLocErr').empty();
	}
	if(eventday == ''){
		$('.inputDateErr').html('Event Name Required');
		error = 1;
	}else{
		$('.inputDateErr').empty();
	}
	if(eventinfo == ''){
		$('.inputInfoErr').html('Event Name Required');
		error = 1;
	}else{
		$('.inputInfoErr').empty();
	}
	if(error == 0){
		$.ajax({
			type: "POST",
			url: 'addevent',
			data: $('#createEvent').serialize(),
			dataType: 'json',
			success: function(response){
				//$('input[name=csrf_test_name]').val(response.token);
				alert('Event Created Successfully');
				$('#createEvent')[0].reset();
				$('.note-editable').empty();
				$('#addEvent').modal('hide');
				$('#eventTable').load(location.href +" #eventTable>*","");
			},
			error: function(data){
				alert('Error Found Jquery!');
			}
		});
	}
});

// Update Event
function updateEvent(editId) {
	//e.preventDefault();
	//var editId = $(this).attr('data');
	var error = 0;
	var eventname = $("#eventnameedit_" + editId).val();
	var eventlocation = $("#eventlocationedit_" + editId).val();
	var dateselect = $(".dateselectedit_" + editId).val();
	var eventinfo = $("#eventinfoedit_" + editId).val();
	if (eventname == '') {
		$('.inputNameErr').html('Event Name Required');
		error = 1;
	} else {
		$('.inputNameErr').empty();
	}
	if (eventlocation == '') {
		$('.inputLocErr').html('Event Name Required');
		error = 1;
	} else {
		$('.inputLocErr').empty();
	}
	if (dateselect == '') {
		$('.inputDateErr').html('Event Name Required');
		error = 1;
	} else {
		$('.inputDateErr').empty();
	}
	if (eventinfo == '') {
		$('.inputInfoErr').html('Event Name Required');
		error = 1;
	} else {
		$('.inputInfoErr').empty();
	}
	if (error == 0) {
		$.ajax({
			type: "POST",
			url: 'updateevent',
			data: $('#updateEvent_'+editId).serialize(),
			dataType: 'json',
			success: function (response) {
				//$('input[name=csrf_test_name]').val(response.token);
				alert('Event Updated Successfully');
				$('#editEvent_' + editId).modal('hide');
				$('#eventTable').load(location.href + " #eventTable>*", "");
			},
			error: function (data) {
				alert('Error Found Jquery!');
			}
		});
	}
}

$('.delEventBtn').click(function(){
	var delid = $(this).attr('data');
	$.ajax({
		type: "GET",
		url: 'deleteevent/'+delid,
		success: function(data){
			alert('Event Deleted Successfully');
			$('#delEvent_'+delid).modal('hide');
			$('tr#eventRow_'+delid).css('background-color', '#ccc');
			$('tr#eventRow_'+delid).fadeOut('slow');
			//$('#eventTable').DataTable().ajax.reload();
		},
		error: function(data){
			alert('Error Found Jquery!');
		}
	});
});

