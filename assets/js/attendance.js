$('.mark-student').click(function(){

	var self = $(this);
	var type = self.data('type');
	var classname = self.data('class');

	self.parents('tr').toggleClass(classname);
});

$('.filter').click(function(){

	var self = $(this);
	var value = self.val();
	var classname = self.data('class');

	if(value !== 'all'){
		$('#students-table tr.all').hide();
	}

	$('#students-table tr.' + classname).show();
});

$('#update-attendance').click(function(){

	var class_id = $(this).data('classid');

	var date = $('#date').val();

	var students = {
		'excused': [],
		'absent': []
	};

	$('#students-table tr.success').each(function(){
	  var self = $(this);
	  var student_id = self.find('td:first').data('studentid');
	  students.excused.push(student_id);
	});

	$('#students-table tr.warning').each(function(){
	  var self = $(this);
	  var student_id = self.find('td:first').data('studentid');
	  students.absent.push(student_id);
	});	

	$.post(
		'/attendance',
		{
			'date': date,
			'class_id': class_id,
			'students': students
		},
		function(response){

			if(response.type == 'success'){
				$('#students-table tr.success').removeClass('success');
				$('#students-table tr.warning').removeClass('warning');

				BootstrapDialog.alert({
					type: BootstrapDialog.TYPE_SUCCESS,
		            title: 'Updated',
		            message: response.text
		        });
			}

		}
	);

});