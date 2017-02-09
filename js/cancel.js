function CashController ($scope, $http) {

	$scope.manage = {
		id : "",
		client : "",
		time : "",
		total : ""
	};

	$http.get('../controller/getBuyesTodayAllUsersNG.php').
	success(function(response){
		$scope.listGestion = response;
	});

	var $OnProcessCancel = false;

	$scope.applyCancel = function() {
		if (!$OnProcessCancel) {
			$OnProcessCancel = true;

			$(".group-action").css({"display" : "none"});
            $(".showMessageSending").css({"display" : "block"});

			var $id = $scope.manage.id;

			$http.post('../controller/manageCancel.php', {
				"id" : $id
			}).
			success(function(response){
				if (response === "OK") {
					$http.get('../controller/getBuyesTodayAllUsersNG.php').
						success(function(response){
							$(".table-responsive tbody tr:last").remove();
							$scope.listGestion = response;

							$(".showMessageSending").css({"display" : "none"});
			                $(".showMessageSuccessfull").css({"display" : "block"});
			                  setTimeout(function(){
			                      $(".showMessageSuccessfull").fadeOut(800);
			                      $("#modalManageCancel").modal("toggle");
			                      $OnProcessCancel = false;
			                }, 4000);
					});
				} else {

					$(".showMessageSending").css({"display" : "none"});
                    $(".showMessageFail").html(response);
                    $(".showMessageFail").css({"display" : "block"});
                    setTimeout(function(){
                        $(".showMessageFail").fadeOut(800);
                        $("#modalManageCancel").modal("toggle");
                        $OnProcessCancel = false;
                    }, 6000);
				}
			});

		}
	};

	$("#modalManageCancel").on('show.bs.modal', function(event){
       
       $(".resultProcessCancel").css({"display" : "none"});
       $(".btnDismissCancel").css({"display" : "inline"});
       $(".btnConfirmCancel").css({"display" : "inline"});

       $(".group-action").css({"display" : "block"});

       var $control = $(event.relatedTarget);
       var $id = $control.data('id');
       var $name = $control.data('name');
       var $time = $control.data('time');
       var $total = $control.data('total');
       var $modal = $(this);

       $scope.manage.id = $id;
       $scope.manage.client = $name;
       $scope.manage.time = $time;
       $scope.manage.total = $total;

       $modal.find('.modal-body span#name').text($name);
       $modal.find('.modal-body span#time').text($time);
       $modal.find('.modal-body span#total').text("$ " + $total);
    });

    

    $('form').on('submit',function(e){
      e.preventDefault();
    });

}