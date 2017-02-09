function StatisticsRealTimeController($scope, $http, $interval) {

	$scope.information = {
		buyesToday : "0",
		cashSalesToday : "0",
		usersConnected : "0",
		productsAgotados : "0"
	};

	var interval = $interval(function(){
		$scope.run();
	}, 10000);

	$scope.$on('$routeChangeStart', function(){
		$interval.cancel(interval);
	});

	$scope.run = function() {
		$http.get('../controller/getStatisticsRealTime.php').
		success(function(response){
			$scope.statistics = response[0];
			$scope.information.buyesToday = $scope.statistics.buyesToday;
			$scope.information.cashSalesToday = ($scope.statistics.cashSalesToday === null) ? "0" : $scope.statistics.cashSalesToday;
			$scope.information.usersConnected = $scope.statistics.usersConnected;
			$scope.information.productsAgotados = $scope.statistics.productsAgotados;
		});
	};

	$scope.run();

	$("#modalShowBuyesToday").on('show.bs.modal', function(event){
		var $control = $(event.relatedTarget);
		var $modal = $(this);

		$http.get('../controller/getListProductsExhausted.php').
		success(function(response){
			$modal.find('.modal-body').html(response);
		});
	});

	$("#modalShowUsersConnected").on('show.bs.modal', function(event){
		var $control = $(event.relatedTarget);
		var $modal = $(this);

		$http.get('../controller/getListUserConnected.php').
		success(function(response){
			$modal.find('.modal-body').html(response);
		});
	});

	$("#modalShowTodayBuyes").on('show.bs.modal', function(event){
		var $control = $(event.relatedTarget);
		var $modal = $(this);

		$http.get('../controller/getBuyesTodayAllUsers.php').
		success(function(response){
			$modal.find('.modal-body').html(response);
		});
	});

	$("#modalDetail").on('show.bs.modal', function(event){
		
		var $control = $(event.relatedTarget);
		var $value = $control.data('id');
		var $modal = $(this);

		$.ajax({
			url : '../controller/getDetailById.php',
			type : 'POST',
			data : {
				'idBuy' : $value,
			},
			success:function(response){
				$modal.find('.modal-body').html(response);
			}	
		});
	});

}