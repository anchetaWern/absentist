$('.claim-card').click(function(){

	var self = $(this);
	var id = self.data('id');
	$.post(
		'/claim',
		{
			'id': id,
			'status': 'has_card'
		},
		function(response){
			
			if(response.type === 'success'){
				self.parents('tr').remove();
				
				if($('.table tbody tr').length === 0){
					$('.table').remove();
				}

			}

		}
	);
});