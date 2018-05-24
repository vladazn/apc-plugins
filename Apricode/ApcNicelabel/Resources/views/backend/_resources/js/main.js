$(document).ready(function() {

	$(".datepicker").datepicker();

	$("#labelFormSubmit").click(function(e) {
		e.preventDefault();
		$('#labelForm').ajaxSubmit({
			success: function(){
				$.jnoty('Table successfully updated', {
					header: 'Success',
					theme: 'jnoty-success'
				});
		    }
       	});
	});
});
