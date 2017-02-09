$(document).ready(function(){

	$("#processLogout").click(function(){

		var user_id = localStorage.getItem('user_id');
			
		$.ajax({
			url : '../controller/ctrl_logout.php',
			method : 'POST',
			data : {
				'user_id' : user_id
			},
			success: function(response) {
				if (response === "OK") {
					location.href = "../";
				}
			}
		});

	});

});
