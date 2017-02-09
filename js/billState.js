function CashController ($scope, $http) {

	$http.get('../controller/getBuyesMonthByDay.php').
	success(function(response){
		$scope.buyes = response;
		$(".loading").css({"display":"none"});
	});

    $('form').on('submit',function(e){
      e.preventDefault();
    });

}