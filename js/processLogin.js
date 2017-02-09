$(document).ready(function(){

	$("#btnAccess").on("click", function(e){

			initializeMessage();

			$username = $("#username").val();
			$password = $("#password").val();

			if ($username != "" && $password != "") {
				$("#showMessageLoginConecting").css({"display" : "block"});
				$.ajax({
					url : 'controller/ctrl_login.php',
					type : 'POST',
					data : {
						'username' : $username,
						'password' : $password
					},
					success:function(response){
						var statusError = response.statusResponse;
						var dataUser = response.dataUser;

						if (dataUser != null) {
							localStorage.setItem("user_id", dataUser[0].user_id);
							localStorage.setItem("user_fullname", dataUser[0].user_fullname);
							localStorage.setItem("user_email", dataUser[0].user_email);
						}

						$("#showMessageLoginConecting").css({"display" : "none"});
						switch (statusError)
						{
							case "UP":
								// Redireccionar a la pantalla principal
								location.href = "app/principal";	
								break;
							case "UPR":
								// Redireccionar a la pantalla de registro de compra
								location.href = "app/purchase";
								break;
							case "UPS":
								// Redireccionar a la pantalla de registro de venta
								location.href = "app/sale";
								break;
							case "DOWN":
								$("#showMessageLoginIncorrect").css({"display" : "block"});
								setTimeout(function(){ 
									$("#showMessageLoginIncorrect").fadeOut(1200);
								}, 2000);
								break;
							case "FAIL":
								$("#showMessageLoginFail").css({"display" : "block"});	
								setTimeout(function(){ 
									$("#showMessageLoginFail").fadeOut(1200);
								}, 2000);
								break;
							case "BLOCKED":
								$("#showMessageLoginBlocked").css({"display" : "block"});
								setTimeout(function(){ 
									$("#showMessageLoginBlocked").fadeOut(1200);
								}, 4000);
								break;
						}
					}
				});
			}
			else
			{
				$("#showMessageLoginEmpty").css({"display" : "block"});
				setTimeout(function(){ 
							$("#showMessageLoginEmpty").fadeOut(1200);
						}, 2000);
			}

		return false;
	});

	function initializeMessage() {
		$("#showMessageLoginConecting").css({"display" : "none"});
		$("#showMessageLoginIncorrect").css({"display" : "none"});
		$("#showMessageLoginEmpty").css({"display" : "none"});
		$("#showMessageLoginBlocked").css({"display" : "none"});
		$("#showMessageLoginFail").css({"display" : "none"});
	};
	
	$("#username").focus();

});