function CashController ($scope, $http) {

	$scope.client = {
		id : "",
		fullname : "",
		saldo : "",
		abono : "",
		typeAbono : ""
	};

	$http.get('../controller/getCashListClient.php').
	success(function(response){
		$scope.clientes = response;
	});

	$scope.isMoroso = function(saldo) {
		if (saldo > 0) {
			return true;
		}
		else
		{
			return false;
		}
	};

	var $activePay = true;

	$scope.registerPay = function() {
		var $typeAbonoId = $('input:radio[name=typeAbono]:checked').val();
		var $id = $scope.client.id;
		var $valueSaldo = $scope.client.saldo + "";
		var $dataSaldo = ($valueSaldo.indexOf(".") != -1) ? $valueSaldo.replace(".","") : $valueSaldo;
		var $saldo = parseInt($dataSaldo);
		var $abono = parseInt($scope.client.abono);

		if ($activePay) {
			$activePay = false;
			if ($typeAbonoId == 1) {
			// Enviar petición como pago completo
				$(".close").css({"display" : "none"});
				$("#group-action").css({"display" : "none"});
            	$("#showMessageSending").css({"display" : "block"});
				$http.post('../controller/registerPay.php', {
					"id" : $id,
					"abono" : $saldo,
					"complete" : 1
				}).
				success(function(response){
					if (response === "OK") {
						$http.get('../controller/getCashListClient.php').
						success(function(response){
							$scope.clientes = response;

							$("#showMessageSending").css({"display" : "none"});
				            $("#showMessageSuccessfull").css({"display" : "block"});

		                    setTimeout(function(){
		                        $("#showMessageSuccessfull").fadeOut(800);
		                        $("#modalPayRegister").modal("toggle");
		                    }, 3000);
						});
					} else {
						$("#showMessageSending").css({"display" : "none"});
	                    $("#showMessageFail").html("No ha sido posible crear la compra");
	                    $("#showMessageFail").css({"display" : "block"});
	                    setTimeout(function(){
	                    	$(".close").css({"display" : "block"});
	                        $("#showMessageFail").fadeOut(800);
	                    }, 3000);
					}
				});
			} else if ($typeAbonoId == 0) {
				if ($abono !== "") {
					if (!isNaN($abono)) {
						if ($abono > 0) {
							if ($abono <= $saldo) {
								if ($abono == $saldo) {
									// Enviar petición como pago completo
									$(".close").css({"display" : "none"});
									$("#group-action").css({"display" : "none"});
            						$("#showMessageSending").css({"display" : "block"});
									$http.post('../controller/registerPay.php', {
										"id" : $id,
										"abono" : $abono,
										"complete" : 1
									}).
									success(function(response){
										if (response === "OK") {
											$http.get('../controller/getCashListClient.php').
											success(function(response){
												$scope.clientes = response;

												$("#showMessageSending").css({"display" : "none"});
									            $("#showMessageSuccessfull").css({"display" : "block"});

							                    setTimeout(function(){
							                        $("#showMessageSuccessfull").fadeOut(800);
							                        $("#modalPayRegister").modal("toggle");
							                    }, 3000);
											});
										} else {
											$("#showMessageSending").css({"display" : "none"});
						                    $("#showMessageFail").html("No ha sido posible crear la compra");
						                    $("#showMessageFail").css({"display" : "block"});
						                    setTimeout(function(){
						                    	$(".close").css({"display" : "block"});
						                        $("#showMessageFail").fadeOut(800);
						                    }, 3000);
										}
									});
								} else {
									// Enviar petición como pago parcial
									$(".close").css({"display" : "none"});
									$("#group-action").css({"display" : "none"});
            						$("#showMessageSending").css({"display" : "block"});
									$http.post('../controller/registerPay.php', {
										"id" : $id,
										"abono" : $abono,
										"complete" : 0
									}).
									success(function(response){
										if (response === "OK") {
											$http.get('../controller/getCashListClient.php').
											success(function(response){
												$scope.clientes = response;

												$("#showMessageSending").css({"display" : "none"});
									            $("#showMessageSuccessfull").css({"display" : "block"});

							                    setTimeout(function(){
							                        $("#showMessageSuccessfull").fadeOut(800);
							                        $("#modalPayRegister").modal("toggle");
							                    }, 3000);
											});
										} else {
											$("#showMessageSending").css({"display" : "none"});
						                    $("#showMessageFail").html("No ha sido posible crear la compra");
						                    $("#showMessageFail").css({"display" : "block"});
						                    setTimeout(function(){
						                    	$(".close").css({"display" : "block"});
						                        $("#showMessageFail").fadeOut(800);
						                    }, 3000);
										}
									});									
								}
							} else {
								$activePay = true;
								$("#showMessageFail").html("El abono es superior a la deuda");
                    			$("#showMessageFail").css({"display" : "block"});
					            setTimeout(function(){
			                        $("#showMessageFail").fadeOut(800);
			                    }, 3000);
							}
						} else {
							$activePay = true;
							$("#showMessageFail").html("El abono debe ser mayor que cero");
                    			$("#showMessageFail").css({"display" : "block"});
					            setTimeout(function(){
			                        $("#showMessageFail").fadeOut(800);
			                    }, 3000);
						}
					} else {
						$activePay = true;
						$("#showMessageFail").html("El abono debe ser numérico");
                    			$("#showMessageFail").css({"display" : "block"});
					            setTimeout(function(){
			                        $("#showMessageFail").fadeOut(800);
			                    }, 3000);
					}
				} else {
					$activePay = true;
					$("#showMessageFail").html("No ha ingresado ningún abono");
        			$("#showMessageFail").css({"display" : "block"});
		            setTimeout(function(){
                        $("#showMessageFail").fadeOut(800);
                    }, 3000);
				}
			} else {
				$activePay = true;
			}
		}

	};

	$("#modalPayRegister").on('show.bs.modal', function(event){
       var $control = $(event.relatedTarget);
       var $id = $control.data('id');
       var $fullname = $control.data('name');
       var $saldo = $control.data('saldo');
       var $modal = $(this);

       $scope.client.id = $id;
       $scope.client.fullname = $fullname;
       $scope.client.saldo = $saldo;

       $('input:radio[name=typeAbono]').attr('checked',false);
       $('input:radio[name=typeAbono]')[0].checked = true;
       $("#contentComplete").html("<label class='control-label'>Suma a pagar = $ " + $scope.client.saldo + "</label>");
       $("#contentComplete").css({"display" : "block"});
       $("#contentPartial").css({"display" : "none"});
       $("#group-action").css({"display" : "block"});
       $(".close").css({"display" : "block"});

       $activePay = true;

       $modal.find('.modal-body input#fullname').val($fullname);
       $modal.find('.modal-body input#saldo').val($saldo);
    });

    $('input[name=typeAbono]').on('change', function(){
    	var $typeAbonoId = $('input:radio[name=typeAbono]:checked').val();

    	if ($typeAbonoId == 1) {
    		$("#contentPartial").css({"display" : "none"});
    		$("#contentComplete").css({"display" : "block"});

    		$("#contentComplete").html("<label class='control-label'>Suma a pagar = $ " + $scope.client.saldo + "</label>");
    	} else {
    		$("#contentComplete").css({"display" : "none"});
    		$("#contentPartial").css({"display" : "block"});

    		$scope.client.abono = "";
    		$("#abono").val("");
    		$("#abono").focus();
    	}
    });

    $('form').on('submit',function(e){
      e.preventDefault();
    });

}