var i = 0;


$("#returnico").click(function(){
  $("#grey").css("visibility", "visible");
});

$("#grey").click(function(){
  $("#grey").css("visibility", "hidden");
});


function booking(elm, id){
    
    var xhttp = new XMLHttpRequest();
    
      if($("#" + id).css("background-color") == "rgb(66, 133, 244)") {

        $("#" + id).css("background-color", "#bfbfbf");
        $("#" + id).html("Booked");
        
        i = i + 1;

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          }
        };
        xhttp.open("GET", "shoppingcart.php?q=" + id, true);
        xhttp.send();
        
      }else {

        $("#" + id).css("background-color", "#4285f4")
        $("#" + id).html("Book");
        i = i - 1;

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
          }
        };
        xhttp.open("GET", "shoppingcart.php?r=" + id, true);
        xhttp.send();
      }
      if(i > 0){
        $("#basketico").attr("src", "shopping-basket-set.png");
      }else {
        $("#basketico").attr("src", "shopping-basket.png");
      }

} 




