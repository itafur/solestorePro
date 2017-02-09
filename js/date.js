$(document).ready(function(){
    
    $("#btnShowDate").on("click", function(){
       $dateShower = $("#dateValid").val();
       alert("FECHA = " + $dateShower);
    });
    
});