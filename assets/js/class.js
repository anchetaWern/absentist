$('.drop-student').click(function(){

	var self = $(this);
	var student_id = self.data('id');
	var student_name = self.data('name');

	BootstrapDialog.confirm({
	    title: 'Drop Student',
	    message: 'Are you sure you want to drop ' + student_name + '?',
	    type: BootstrapDialog.TYPE_WARNING, 
	    buttonLabel: 'Yup!', 
	    callback: function(result){
	        if(result){
	        	$.post(
	        		'/student/drop',
	        		{
	        			'id': student_id
	        		},
	        		function(response){
	        			if(response.type === 'ok'){
	        				self.parents('tr').fadeOut();
	        			}
	        		}
	        	);
	        }
	    }
	});
        

});