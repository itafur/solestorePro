function CashController ($scope, $http) {

	$scope.client = {
		totalBuyes : 0,
		totalSaldos : 0,
		dateStart : "",
		dateFinish : "",
		msg : ""
	};

	$scope.downloadReportBuyes = function() {
		if ($scope.client.dateStart !== "" && $scope.client.dateFinish !== "") {
			location.href = "../controller/reportBuyesExport.php?dateStart="+$scope.client.dateStart+"&dateFinish="+$scope.client.dateFinish;
		}
		else
		{
			$(".messageError").css({"display" : "block"});
			$scope.client.msg = "Debe ingresar la fecha inicial y final";
		}
	};

	$scope.consultBuyesByRange = function() {
		if ($scope.client.dateStart !== "" && $scope.client.dateFinish !== "") {
			$(".messageError").css({"display" : "none"});
			$("#showLoading").css({"display" : "block"});

			$scope.clientes = "";

			$http.post('../controller/reportBuyes.php', {
				"dateStart" : $scope.client.dateStart,
				"dateFinish" : $scope.client.dateFinish
			}).
			success(function(response){
				if (response !== "null") {
					$scope.clientes = response;
					$scope.client.totalBuyes = getTotalBuyes();
					$scope.client.totalSaldos = getTotalSaldos();
				}
				else
				{
					$scope.client.totalBuyes = 0;
					$scope.client.totalSaldos = 0;
				}
				$("#showLoading").css({"display" : "none"});
			});
		}
		else
		{
			$(".messageError").css({"display" : "block"});
			$scope.client.msg = "Debe ingresar la fecha inicial y final";
		}
	};

	function getTotalBuyes() {
		var $total = 0;
		for (var i = 0; i < $scope.clientes.length; i++) {
			var $client = $scope.clientes[i];
			$total += parseInt($client.totalBuyes); 
		};
		return $total;
	};

	function getTotalSaldos() {
		var $total = 0;
		for (var i = 0; i < $scope.clientes.length; i++) {
			var $client = $scope.clientes[i];
			$total += parseInt($client.totalCredit); 
		};
		return $total;
	};

	$scope.itsHaveSaldo = function(totalBuyes)
	{
		if (totalBuyes > 0) {
			return false;
		}
		else
		{
			return true;
		}
	};

	$('form').on('submit',function(e){
      e.preventDefault();
    });

}