$(document).ready(function() {

	$('#printButton').click(function(){
		$("#printContent").show();
		window.print();
	});

	$(".panel-title").on("change","input[name='check']",function() {
		var id = $(this).attr('id');
		if(this.checked) {
			$('.' + id).each(function(){
				$(this).prop('checked', true);
			});
		} else {
			$('.' + id).each(function(){
				$(this).prop('checked', false);
			});
		}
	});
});
