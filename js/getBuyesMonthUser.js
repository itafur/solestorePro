function buyesMonthController ($scope, $http) {

	var $idUser = $("#ID_SESSION").text();

	$scope.buyData = {
		count : "0",
		saldo : 0
	};

	$http.post('../controller/buyesMonthByUser.php', {
		"user_id" : $idUser
	}).
	success(function(response){
		if (response != "null") {
			$scope.buyData.saldo = response.saldo;
			$scope.buyData.count = response.buyes.length;
			$scope.buyes = response.buyes;
		}
		else
		{
			$scope.buyes = "";
		}
	});

	$scope.showPayesDones = function() {
		$http.post('../controller/lastThreePayesByUser.php', {
		"user_id" : $idUser
		}).
		success(function(response) {
			$(".btn-show-pay").css({"display" : "none"});
			$(".tablePay").css({"display" : "block"});
			if (response != "null") {
				$scope.payes = response;
			}
			else
			{
				$scope.payes = "";
			}
		});
	};

	$scope.payedComplete = function(payedComplete) {
		if (payedComplete == 1) {
			return true;
		} else {
			return false;
		}
	};

	$("#modalDetail").on('show.bs.modal', function(event){
		
		var $control = $(event.relatedTarget);
		var $value = $control.data('id');
		var $modal = $(this);

		$(".loading").css({"display" : "block"});

		$.ajax({
			url : '../controller/getDetailById.php',
			type : 'POST',
			data : {
				'idBuy' : $value,
			},
			success:function(response){
				$(".loading").css({"display" : "none"});
				$modal.find('.modal-body').html(response);
			}
		});
	});


	$('form').on('submit',function(e){
      e.preventDefault();
    });

}