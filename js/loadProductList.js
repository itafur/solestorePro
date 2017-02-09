function ControllerGroser($scope, $http){

	$scope.product ={
      code : "",
      product : "",
      price_unitary : "0",
      stock : "0",
      enabled : "1"
    };

    $http.get('../controller/getProductsList.php').
    success(function(response){
        $scope.products = response;
        $scope.totalGroser = getTotal();
    });
    
    function getTotal() {
      var total = 0;

      if (typeof($scope.products) !== "undefined") {
          for (var i = 0; i < $scope.products.length; i++) {
            var product = $scope.products[i];
            total += (product.price_unitary * product.stock);
          };
      };
      
      return total;
    };

    $scope.deleteProduct = function() {
      var id = $scope.product.code;

      $(".close").css({"display" : "none"});
      $(".group-action").css({"display" : "none"});
      $(".showMessageSending").css({"display" : "block"});

        $http.post('../controller/deleteProduct', {
            "id" : id
        })
        .success(function(response){
           if (response === "OK") {

                  $http.get('../controller/getProductsList.php').
                  success(function(response){
                      $scope.products = response;
                      $scope.totalGroser = getTotal();

                      $(".showMessageSending").css({"display" : "none"});
                      $(".showMessageSuccessfull").css({"display" : "block"});
                      setTimeout(function(){
                          $(".showMessageSuccessfull").fadeOut(800);
                          $("#modalProductDelete").modal("toggle");
                      }, 3000);

                  });

           } else {
              $(".showMessageSending").css({"display" : "none"});
              $(".showMessageFail").html(response);
              $(".showMessageFail").css({"display" : "block"});
              setTimeout(function(){
                  $(".showMessageFail").fadeOut(800);
                  $("#modalProductDelete").modal("toggle");
              }, 6000);
           }    
        });      

    };

    $scope.supplyProduct = function() {
        $code = $scope.product.code;
        $cantidad = $scope.product.stock;

        if ($cantidad !== "") {
            if (!isNaN($cantidad)) {
                if ($cantidad > 0) {

                    $(".close").css({"display" : "none"});
                    $(".group-action").css({"display" : "none"});
                    $(".showMessageSending").css({"display" : "block"});

                     $http.post('../controller/supplyStockProduct.php',
                     {
                        "code" : $code,
                        "stock" : $cantidad
                     }).
                     success(function(response){
                        if (response === "1") {
                            $http.get('../controller/getProductsList.php').
                            success(function(response){
                                $scope.products = response;
                                $scope.totalGroser = getTotal();

                                $(".showMessageSending").css({"display" : "none"});
                                $(".showMessageSuccessfull").css({"display" : "block"});
                                setTimeout(function(){
                                    $(".showMessageSuccessfull").fadeOut(800);
                                    $("#modalShopSupply").modal("toggle");
                                }, 3000);

                            });
                        } else if (response === "0") {
                            $(".showMessageSending").css({"display" : "none"});
                            $(".showMessageFail").html(response);
                            $(".showMessageFail").css({"display" : "block"});
                            setTimeout(function(){
                                $(".showMessageFail").fadeOut(800);
                                $("#modalShopSupply").modal("toggle");
                            }, 6000);
                        }
                     });
                } else {
                    $(".showMessageFail").html("El valor de cantidad debe ser superior a cero");
                    $(".showMessageFail").css({"display" : "block"});
                    setTimeout(function(){
                        $(".showMessageFail").fadeOut(800);
                    }, 3000);
                }
            } else {
                $(".showMessageFail").html("El campo cantidad debe ser numérico");
                $(".showMessageFail").css({"display" : "block"});
                setTimeout(function(){
                    $(".showMessageFail").fadeOut(800);
                }, 3000);
            }
        } else {
            $(".showMessageFail").html("Digite una cantidad");
            $(".showMessageFail").css({"display" : "block"});
            setTimeout(function(){
                $(".showMessageFail").fadeOut(800);
            }, 3000);
        }
    };

    $scope.updateProduct = function() {
        $code = $scope.product.code;
        $name = $scope.product.product;
        $price = $scope.product.price_unitary;
        $stock = $scope.product.stock;
        $enabled = $("#enabledUpdate").val();

        if ($code !== "" && $name !== "" && $price !== "" && $stock !== "") {
            if (!isNaN($price) && !isNaN($stock)) {

                $(".close").css({"display" : "none"});
                $(".group-action").css({"display" : "none"});
                $(".showMessageSending").css({"display" : "block"});

                $http.post('../controller/updateProduct.php',
                 {
                    "code" : $code,
                    "name" : $name,
                    "price" : $price,
                    "stock" : $stock,
                    "enabled" : $enabled
                 }).success(function(response){
                      if (response === "1") {
                          $http.get('../controller/getProductsList.php').
                          success(function(response){
                              $scope.products = response;
                              $scope.totalGroser = getTotal();

                              $(".showMessageSending").css({"display" : "none"});
                              $(".showMessageSuccessfull").css({"display" : "block"});
                              setTimeout(function(){
                                  $(".showMessageSuccessfull").fadeOut(800);
                                  $("#modalEditProduct").modal("toggle");
                              }, 3000);

                          });
                      } else if (response === "0") {
                          $(".showMessageSending").css({"display" : "none"});
                          $(".showMessageFail").html(response);
                          $(".showMessageFail").css({"display" : "block"});
                          setTimeout(function(){
                              $(".showMessageFail").fadeOut(800);
                              $("#modalEditProduct").modal("toggle");
                          }, 6000);
                      }
                 });
            } else {
                $(".showMessageFail").html("Los campos precio unitario y cantidad deben ser númericos");
                $(".showMessageFail").css({"display" : "block"});
                setTimeout(function(){
                    $(".showMessageFail").fadeOut(800);
                }, 3000);
            }
        } else {
            $(".showMessageFail").html("Debe diligenciar todos los campos");
            $(".showMessageFail").css({"display" : "block"});
            setTimeout(function(){
                $(".showMessageFail").fadeOut(800);
            }, 3000);
        }
    }

    $scope.addProduct = function() {
        $name = $scope.product.product;
        $price_unitary = $scope.product.price_unitary;
        $stock = $scope.product.stock;
        $enabled = $("#enabled").val();

        if ($name !== "" && $price_unitary !== "" && $stock !== "") {
            if (!isNaN($price_unitary) && !isNaN($stock)) {

              $(".close").css({"display" : "none"});
              $(".group-action").css({"display" : "none"});
              $(".showMessageSending").css({"display" : "block"});

               $http.post('../controller/createProduct.php',
               {
                  "name" : $name,
                  "price" : $price_unitary,
                  "stock" : $stock,
                  "enabled" : $enabled
               }).success(function(response){
                  if (response == "Creado exitosamente") {
                      
                      $http.get('../controller/getProductsList.php').
                      success(function(response){
                          $scope.products = response;
                          $scope.totalGroser = getTotal();

                          $(".showMessageSending").css({"display" : "none"});
                          $(".showMessageSuccessfull").css({"display" : "block"});
                          setTimeout(function(){
                              $(".showMessageSuccessfull").fadeOut(800);
                              $("#modalNewProduct").modal("toggle");
                          }, 3000);

                      });
                      
                  } else {
                        $(".showMessageSending").css({"display" : "none"});
                        $(".showMessageFail").html(response);
                        $(".showMessageFail").css({"display" : "block"});
                        setTimeout(function(){
                            $(".showMessageFail").fadeOut(800);
                            $("#modalNewProduct").modal("toggle");
                        }, 6000);
                  }
               });
            } else {
                $(".showMessageFail").html("Los campos precio unitario y cantidad deben ser númericos");
                $(".showMessageFail").css({"display" : "block"});
                setTimeout(function(){
                    $(".showMessageFail").fadeOut(800);
                }, 3000);
            }
        } else {
            $(".showMessageFail").html("Debe diligenciar todos los campos");
            $(".showMessageFail").css({"display" : "block"});
            setTimeout(function(){
                $(".showMessageFail").fadeOut(800);
            }, 3000);
        }
    }

    $("#modalEditProduct").on('show.bs.modal', function(event){
      var $control = $(event.relatedTarget);
      var $id = $control.data('id');
      var $productName = $control.data('product');
      var $price = $control.data('price');
      var $stock = $control.data('stock');
      var $enabled = ($control.data('enabled') === "SI") ? "1" : "0";
      var $modal = $(this);

      $(".close").css({"display" : "block"});
      $(".group-action").css({"display" : "block"});

      $scope.product.code = $id;
      $scope.product.product = $productName;
      $scope.product.price_unitary = $price;
      $scope.product.enabled = $enabled;

      $modal.find('.modal-body input#product').val($productName);
      $modal.find('.modal-body input#price').val($price);
      $modal.find('.modal-body input#stock').val($stock);
      $modal.find('.modal-body select#enabledUpdate').val($enabled);
    });

    $("#modalShopSupply").on('show.bs.modal', function(event){
      var $control = $(event.relatedTarget);
      var $id = $control.data('id');
      var $productName = $control.data('product');
      var $modal = $(this);

      $(".close").css({"display" : "block"});
      $(".group-action").css({"display" : "block"});

      $scope.product.stock = "0";
      $scope.product.code = $id;
      $scope.product.product = $productName;

      $modal.find('.modal-body input#product').val($productName);
      $modal.find('.modal-body input#cantidad').val("0");
    });

    $("#modalNewProduct").on('show.bs.modal', function(event){
       var $modal = $(this);

       $(".close").css({"display" : "block"});
       $(".group-action").css({"display" : "block"});

       $scope.product.code = "";
       $scope.product.product = "";
       $scope.product.price_unitary = "0";
       $scope.product.stock = "0";
       $scope.product.enabled = "1";

       $modal.find('.modal-body input#code').val("");
       $modal.find('.modal-body input#product').val("");
       $modal.find('.modal-body input#price').val("0");
       $modal.find('.modal-body input#stock').val("0");
       $modal.find('.modal-body select#enabled').val("1");
    });

    $("#modalProductDelete").on('show.bs.modal', function(event){
       var $control = $(event.relatedTarget);
       var $id = $control.data("id");
       var $name = $control.data("name");
       var $modal = $(this);

       $(".close").css({"display" : "block"});
       $(".group-action").css({"display" : "block"});

       $('input:text:visible:first').focus();
        
       $scope.product.product = $name;
       $scope.product.code = $id;

       $modal.find('.modal-body span#nameToDelete').text($name);

    });

    $('form').on('submit',function(e){
      e.preventDefault();
    });

};