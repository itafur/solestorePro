$(document).ready(function(){

	var $idUser = $("#ID_SESSION").text();

	//alert($idUser);

	$.ajax({
		url : '../controller/buyesTodayByUser.php',
		type : 'POST',
		data : {
			'user_id' : $idUser
		},
		success:function(response){
			$("#resultBuyesToday").empty();
			$("#resultBuyesToday").html(response);
		}
	});

	$("#BuyId").on("click", function(){
		var data_id = '';
		if (typeof $(this).data('id') !== 'undefined') {
			data_id = $(this).data('id');
		}
		$("#idBuy").val(data_id);
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
		//modal.find('.modal-title').text('Detalle de Compra ' + value);
		//modal.find('.modal-body input').val(value);
	});

});