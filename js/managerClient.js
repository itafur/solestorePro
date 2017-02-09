$(document).ready(function(){

	$("#btnAddClient").on('click', function(){
		
		var $fullname = $("#fullname").val();
		var $email = $("#email").val();
		var $username = $("#username").val();
		var $password = $("#password").val();
		var $confirmPassword = $("#confirmPassword").val();

		if ($fullname != "" && $email != "" && $username != "" && $password != "" && $confirmPassword != "") {
			if ($password !== $confirmPassword) {
				$("#oculto").html("Las contraseñas No coinciden");
				$("#oculto").css({"display" : "inline", "color" : "red"});
				setTimeout(function(){
									$("#oculto").fadeOut(800);
							}, 3000);
			}
			else {
				$.ajax({
					url : '../controller/createClient.php',
					type : 'POST',
					data : {
						'fullname' : $fullname,
						'email' : $email,
						'username' : $username,
						'password' : $password
					},
					success:function(response){
						$("#oculto").html(response);
						if (response == "Creado exitosamente") {
							$("#oculto").css({"display" : "inline", "color" : "green"});
							setTimeout(function(){
									$("#oculto").fadeOut(800);
									$("#modalNewClient").modal("toggle");
							}, 6000);								
						}
						else {
							$("#oculto").css({"display" : "inline", "color" : "red"});
							setTimeout(function(){
									$("#oculto").fadeOut(800);
							}, 3000);
						}
					},
					error:function(xhr, status){

					}
				});
			}
		}
		else {
			alert("Debe diligenciar todos los campos");		
		}


		return false;
	});

	$("#modalNewClient").on('show.bs.modal', function(event){
		$("#fullname").val("");
		$("#email").val("");
		$("#username").val("");
		$("#password").val("");
		$("#confirmPassword").val("");
	});

});