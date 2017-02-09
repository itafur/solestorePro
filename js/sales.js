$(document).ready(function(){
	
	var json;
	var jsonClient;
	var options = "<option value='0'>-- SELECCIONE UNA OPCIÓN --</option>";
	var clientList = "";
	var $userID = "0";
	var $userEmail = "";
	var $fullname = "";
	
	$.ajax({
		url : '../controller/getUserListClient.php',
		dataType : "json",
		success: function(responseC)
		{
			jsonClient = responseC;

			$.each(responseC, function(index){
                    var id = responseC[index].id;
                    var fullname = responseC[index].nombre;

                    clientList += "<option value='" + id + "'>" + fullname + "</option>";
                })

			$("#clients").html(clientList);
		}
	});

	$.ajax({
		url : '../controller/getProductsActive.php',
		dataType : "json",
		success: function(responseP)
		{
			json = responseP.data;

			if (json != null) {
				$.each(json, function(index){
                    var code = json[index].code;
                    var name = json[index].name;
                    var stock = json[index].stock;

                    options += "<option value='" + code + "'>" + name + " (" + stock + ")</option>";
                })

                $(".showWindowForBuy").css({"display" : "block"});
				$(".showWindowEmpty").css({"display" : "none"});

				$("#productos").html(options);
			} else {
				$(".showWindowForBuy").css({"display" : "none"});
				$(".showWindowEmpty").css({"display" : "block"});
			}
		}
	});

	var $activeBuy = true;

	$sumatory = 0;
		

	$("#btnAddProduct").on('click', function(){
		var $code = $("#productos").val();
		var $text = $("#productos option:selected").text();
		var $count = $("#cantidad").val();
		var flagCreate = true;

		$text = $text.substring(0, $text.indexOf("(")); 

		if ($code !== "0") {
			if ($count != "" && !isNaN($count)) 
			{
				if ($count > 0) 
				{
					var indexer = json.map(function(d){ return d['code']; }).indexOf($code);
					var $price = json[indexer].price;
					var $stock = parseInt(json[indexer].stock);
					var $subTotal = $price * $count;
					var $total = 0;

					$("#tableDetails tbody tr:last").remove();

					if ($count <= $stock) {
						$("#tableDetails tbody tr").each(function(index){
							var id = $(this).find("td:first").text();

				     		if (id == $code) {
				     			flagCreate = false;
				     		}
						})
					}
					else
					{
						flagCreate = false;
					}
					//

					if (flagCreate === true)
					{
						$sumatory += $subTotal;
						$("#tableDetails tbody").append("<tr><td>" + $code + "</td><td>" + $text + "</td><td>" + $count + "</td><td>$" + $price + "</td><td>$" + $subTotal + "</td><td><a href='' class='delete'><span class='glyphicon glyphicon-trash colorRed'></span></a></td></tr>");
					}
					$("#tableDetails tbody").append("<tr><td colspan='3'></td><td>TOTAL:</td><td colspan='2'><label class='supText'>$" + $sumatory + "</label></td></tr>");
				}
			}
		}

		return false;
	});

	$("#tableDetails tbody").on("click", ".delete", function(e){
		e.preventDefault();
		$("#tableDetails tbody tr:last").remove();
		var indexTableRow = $(this).parents('td').parents('tr').prevAll().length;
		var $valueSubTotal = $("#tableDetails tbody tr:eq(" + indexTableRow + ")").children('td:eq(4)').text();
		var $subTotal = parseInt($valueSubTotal.substring(1));
		$sumatory -= $subTotal;
		$("#tableDetails tbody tr:eq(" + indexTableRow + ")").remove();
		$("#tableDetails tbody").append("<tr><td colspan='3'></td><td>TOTAL:</td><td colspan='2'><label class='supText'>$" + $sumatory + "</label></td></tr>");
	});

	
	$("#productos").change(function(){
		var value = $("#productos").val();
		$("#cantidad").val("");
		if (value === "0") {
			$("#regionProduct").addClass("has-error");
		} else {
			$("#regionProduct").removeClass("has-error");
			$("#cantidad").focus();
		}
	});

	$("#clients").change(function(){
		var value = $("#clients").val();
		if (value === "0") {
			$("#regionClient").addClass("has-error");
		} else {
			$("#regionClient").removeClass("has-error");
		}
	});
	
	$("#clients").change(function(){
	    var id = $("#clients option:selected").val();
	    var fullname = $("#clients option:selected").text();
	    setUserId(id);
	    setUserEmail(id);
	    setUserFullname(fullname);
	});

	$("#openModal").on('click', function(){
		var $total = $("#tableDetails tbody tr:last").children("td:eq(2)").text().substring(1);
		if ($total != "" && $total > 0) {
		    if ($userID !== undefined && $userID !== "0") {
    			$activeBuy = true;
    			$("#group-action").css({"display" : "block"});
    			$("#confirmBuy").modal('toggle');
		    }
		}
		return false;
	});

	function product(id, item, count, subtotal)
	{
		this.codigo = id;
		this.item = item;
		this.cantidad = count;
		this.subtotal = subtotal;
	}
	
	function setUserId(id)
    {
        $userID = id;
    }

    function setUserEmail(id) {
    	if (jsonClient != null && jsonClient !== "") {

    		var objectUser = $(jsonClient).filter(function(i, n){
        			return n.id == id;
        		});

    		$userEmail = objectUser[0].email;
    	}
    }

    function setUserFullname(fullname) {
    	$fullname = fullname;
    }

	$("#toConfirmBuy").on('click',function(){

		if ($activeBuy) 
		{
			$("#group-action").css({"display" : "none"});
            $("#showMessageSending").css({"display" : "block"});
			$activeBuy = false;
			$removeGrid = false;
			var $idUser = $userID;
			var $total = $("#tableDetails tbody tr:last").children("td:eq(2)").text().substring(1);
			var $countProducts = $("#tableDetails tbody tr").length - 1;
			var ListaProducts = [];

			$("#tableDetails tbody tr").each(function(index){
				var $idItem = $(this).find("td:first").text();
				var $nameItem = $(this).find("td:eq(1)").text();
				var $countItem = $(this).find("td:eq(2)").text();
				var $subTotalItem = $(this).find("td:eq(4)").text().substring(1);

				if ($idItem !== "") {
					ListaProducts.push(new product($idItem, $nameItem, $countItem, $subTotalItem));
				}
			})

			var $productsJSON = JSON.stringify(ListaProducts);

			// Operación Ajax para enviar petición http a web service crear compra
			$.ajax({
				url : '../controller/createCompra.php',
				type : 'POST',
				data : {
					'user_id' : $idUser,
					'fullname' : $fullname,
					'email' : $userEmail,
					'total' : $total,
					'productsCount' : $countProducts,
					'listProducts' : $productsJSON
				},
				success:function(response){
					if (response !== "OK")
					{
						$("#showMessageSending").css({"display" : "none"});
	                    $("#showMessageFail").html(response);
	                    $("#showMessageFail").css({"display" : "block"});
	                    setTimeout(function(){
	                        $("#showMessageFail").fadeOut(800);
	                        $("#confirmBuy").modal("toggle");
	                    }, 6000);
				    }
				    else
				    {
				    	$("#productos").empty().append('whatever');
				    	//
				    	$.ajax({
							url : '../controller/getProductsActive.php',
							dataType : "json",
							success: function(response2)
							{
								json = response2.data;

								if (json != null) {

									$("#clients").val("0");

									$("#productos").append("<option value='0'>-- SELECCIONE UNA OPCIÓN --</option>");

									$.each(json, function(index){
					                    var code = json[index].code;
					                    var name = json[index].name;
					                    var stock = json[index].stock;

					                    $("#productos").append("<option value='" + code + "'>" + name + " (" + stock + ")</option>");
					                });

									$(".showWindowForBuy").css({"display" : "block"});
									$(".showWindowEmpty").css({"display" : "none"});
								} else {
									$(".showWindowForBuy").css({"display" : "none"});
									$(".showWindowEmpty").css({"display" : "block"});
								}

								$("#showMessageSending").css({"display" : "none"});
			                    $("#showMessageSuccessfull").css({"display" : "block"});
								$sumatory = 0;
						    	setTimeout(function(){
										$("#showMessageSuccessfull").fadeOut(800);
										$("#cantidad").val("");
										$("#tableDetails tbody tr").remove();
										$("#regionClient").addClass("has-error");
										$("#regionProduct").addClass("has-error");
										$("#confirmBuy").modal("toggle");
								}, 3000);								
							}
						});
				    }
				},
				error:function(xhr, status){
					$("#showMessageSending").css({"display" : "none"});
                    $("#showMessageFail").html("No ha sido posible crear la compra");
                    $("#showMessageFail").css({"display" : "block"});
                    setTimeout(function(){
                        $("#showMessageFail").fadeOut(800);
                        $("#confirmBuy").modal("toggle");
                    }, 6000);
				}
			});
		}
		
	});

	

});