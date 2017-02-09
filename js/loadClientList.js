function ControladorFiltros($scope, $http) {

    $scope.cliente ={
      id : "",
      fullname : "",
      email : "",
      username : "",
      password : "",
      confirmPassword : "",
      state : ""
    };

    $http.get('../controller/getUserList.php').
    success(function(response){
        $scope.clientes = response;
    });

    $scope.deleteUser = function() {
      var id = $scope.cliente.id;

      $(".close").css({"display" : "none"});
      $(".group-action").css({"display" : "none"});
      $("#showMessageSendingDelete").css({"display" : "block"});

        $http.post('../controller/deleteUser', {
            "id" : id
        })
        .success(function(response){
           if (response === "OK") {

              $http.get('../controller/getUserList.php').
                    success(function(response){
                    $scope.clientes = response;

                    $("#showMessageSendingDelete").css({"display" : "none"});
                    $("#showMessageSuccessfullDelete").css({"display" : "block"});
                    setTimeout(function(){
                        $("#showMessageSuccessfullDelete").fadeOut(800);
                        $("#modalUserDelete").modal("toggle");
                    }, 3000);
              });

           } else if (response === "PENDING") {
                    $("#showMessageSendingDelete").css({"display" : "none"});
                    $("#showMessagePendingDelete").css({"display" : "block"});
                    setTimeout(function(){
                        $("#showMessagePendingDelete").fadeOut(800);
                        $("#modalUserDelete").modal("toggle");
                    }, 5000);
           } else {
              $("#showMessageSendingDelete").css({"display" : "none"});
              $("#showMessageFailDelete").html(response);
              $("#showMessageFailDelete").css({"display" : "block"});
              setTimeout(function(){
                  $("#showMessageFailDelete").fadeOut(800);
                  $("#modalUserDelete").modal("toggle");
              }, 6000);
           }    
        });      

    };

    $scope.cambiarClave = function(){
      var $id = $scope.cliente.id;
      var $password = $scope.cliente.password;
      var $confirmPassword = $scope.cliente.confirmPassword;

      if ($password !== "" && $confirmPassword !== "") {
          if ($password !== $confirmPassword) {
              $("#showMessageFailPassword").html("Las contraseñas no coinciden");
              $("#showMessageFailPassword").css({"display" : "block"});
              setTimeout(function(){
                  $("#showMessageFailPassword").fadeOut(800);
              }, 3000);
          }
          else {

              $(".close").css({"display" : "none"});
              $(".group-action").css({"display" : "none"});
              $("#showMessageSendingPassword").css({"display" : "block"});

              $http.post('../controller/changePassword.php', {
                 "id" : $id,
                 "password" : $password
              })
              .success(function(response){
                 if (response == "1") {

                    $("#showMessageSendingPassword").css({"display" : "none"});
                    $("#showMessageSuccessfullPassword").css({"display" : "block"});
                    setTimeout(function(){
                        $("#showMessageSuccessfullPassword").fadeOut(800);
                        $("#modalChangePassword").modal("toggle");
                    }, 3000);
                 } else {
                    $("#showMessageSendingPassword").css({"display" : "none"});
                    $("#showMessageFailPassword").html(response);
                    $("#showMessageFailPassword").css({"display" : "block"});
                    setTimeout(function(){
                        $("#showMessageFailPassword").fadeOut(800);
                        $("#modalChangePassword").modal("toggle");
                    }, 6000);
                 }    
              });
          }
      } else {
          $("#showMessageFailPassword").html("Debe diligenciar todos los campos");
          $("#showMessageFailPassword").css({"display" : "block"});
          setTimeout(function(){
              $("#showMessageFailPassword").fadeOut(800);
          }, 3000);
      }

    }

    $scope.actualizarCliente = function(){
        var $id = $scope.cliente.id;
        var $fullname = $scope.cliente.fullname;
        var $email = $scope.cliente.email;
        var $state = $("#state").val();

        if ($fullname !== "" && $email !== "") {

          $(".close").css({"display" : "none"});
          $(".group-action").css({"display" : "none"});
          $("#showMessageSendingUpdate").css({"display" : "block"});
          
          $http.post('../controller/updateClient.php',
            {"id" : $id, "fullname" : $fullname, "email" : $email, "state" : $state}
          ).success(function(response){
              if (response === "1") {
                  $http.get('../controller/getUserList.php').
                          success(function(response){
                          $scope.clientes = response;

                          $("#showMessageSendingUpdate").css({"display" : "none"});
                          $("#showMessageSuccessfullUpdate").css({"display" : "block"});
                          setTimeout(function(){
                              $("#showMessageSuccessfullUpdate").fadeOut(800);
                              $("#modalEditClient").modal("toggle");
                          }, 3000);
                    });
              }
              else {
                  $("#showMessageSendingUpdate").css({"display" : "none"});
                  $("#showMessageFailUpdate").html(response);
                  $("#showMessageFailUpdate").css({"display" : "block"});
                  setTimeout(function(){
                      $("#showMessageFailUpdate").fadeOut(800);
                      $("#modalEditClient").modal("toggle");
                  }, 6000);
              }
          });
           
        }
        else {
            $("#showMessageFailUpdate").html("Debe diligenciar todos los campos");
            $("#showMessageFailUpdate").css({"display" : "block"});
            setTimeout(function(){
                $("#showMessageFailUpdate").fadeOut(800);
            }, 3000);
        }
    }

    $scope.agregarCliente = function(){
      if ($scope.cliente.fullname != "" && $scope.cliente.email != "" && $scope.cliente.username != "" && $scope.cliente.password != "" && $scope.cliente.confirmPassword != "") {
          if ($scope.cliente.password !== $scope.cliente.confirmPassword) {
              
              $("#showMessageFail").html("Las contraseñas no coinciden");
              $("#showMessageFail").css({"display" : "block"});
              setTimeout(function(){
                  $("#showMessageFail").fadeOut(800);
              }, 3000);

          }
          else {
                
                $(".close").css({"display" : "none"});
                $(".group-action").css({"display" : "none"});
                $("#showMessageSending").css({"display" : "block"});
                
                $http.post('../controller/createClient.php',
                {"fullname": $scope.cliente.fullname,
                 "email" : $scope.cliente.email,
                 "username" : $scope.cliente.username,
                 "password" : $scope.cliente.password
                }).success(function(response){
                    if (response == "Creado exitosamente") {
                      $http.get('../controller/getUserList.php').
                            success(function(response){
                            $scope.clientes = response;

                            $("#showMessageSending").css({"display" : "none"});
                            $("#showMessageSuccessfull").css({"display" : "block"});
                            setTimeout(function(){
                                $("#showMessageSuccessfull").fadeOut(800);
                                $("#modalNewClient").modal("toggle");
                            }, 3000);

                      });
                    }
                    else {
                        $("#showMessageSending").css({"display" : "none"});
                        $("#showMessageFail").html(response);
                        $("#showMessageFail").css({"display" : "block"});
                        setTimeout(function(){
                            $("#showMessageFail").fadeOut(800);
                            $("#modalNewClient").modal("toggle");
                        }, 6000);
                    }
              });

          }
      }
      else {
            $("#showMessageFail").html("Debe diligenciar todos los campos");
            $("#showMessageFail").css({"display" : "block"});
            setTimeout(function(){
                $("#showMessageFail").fadeOut(800);
            }, 3000);
      }

    };

    $("#modalNewClient").on('show.bs.modal', function(event){
       var $modal = $(this);
       
       $('input:text:visible:first').focus();

       $(".close").css({"display" : "block"});
       $(".group-action").css({"display" : "block"});

       $modal.find('.modal-body input#fullname').val("");
       $modal.find('.modal-body input#email').val("");
       $modal.find('.modal-body input#username').val("");
       $modal.find('.modal-body input#password').val("");
       $modal.find('.modal-body input#confirmPassword').val("");
       
       $modal.find('.modal-body input#fullname').focus();
    });

    $("#modalEditClient").on('show.bs.modal', function(event){
       var $control = $(event.relatedTarget);
       var $id = $control.data('id');
       var $fullname = $control.data('fullname');
       var $email = $control.data('email');
       var $state = $control.data('state');
       var $modal = $(this);

       $(".close").css({"display" : "block"});
       $(".group-action").css({"display" : "block"});

       $valueState = "0";

       if ($state === "SI") {
          $valueState = "1";
       }

       $scope.cliente.id = $id;
       $scope.cliente.fullname = $fullname;
       $scope.cliente.email = $email;
       $scope.cliente.state = ($state === "ACTIVO") ? "1": "0";
       $modal.find('.modal-body input#fullname').val($fullname);
       $modal.find('.modal-body input#email').val($email);
       $modal.find('.modal-body select#state').val($valueState);
    });

    $("#modalChangePassword").on('show.bs.modal', function(event){
       var $control = $(event.relatedTarget);
       var $id = $control.data("id");
       var $modal = $(this);

       $(".close").css({"display" : "block"});
       $(".group-action").css({"display" : "block"});

       $('input:text:visible:first').focus();
        
       $scope.cliente.password = "";
       $scope.cliente.confirmPassword = "";

       $scope.cliente.id = $id;
       $modal.find('.modal-body input#password').val("");
       $modal.find('.modal-body input#confirmPassword').val("");
       
       $modal.find('.modal-body input#password').focus();
    });

    $("#modalUserDelete").on('show.bs.modal', function(event){
       var $control = $(event.relatedTarget);
       var $id = $control.data("id");
       var $name = $control.data("name");
       var $modal = $(this);

       $(".close").css({"display" : "block"});
       $(".group-action").css({"display" : "block"});

       $('input:text:visible:first').focus();
        
       $scope.cliente.fullname = $name;
       $scope.cliente.id = $id;

       $modal.find('.modal-body span#nameToDelete').text($name);

    });

    $('form').on('submit',function(e){
      e.preventDefault();
    });

};

