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


$("#addFile").click(function(){
  console.log("yar");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      window.location.replace("/");
    }
  };
  xhttp.open("GET", "../teacher/return.php?logout=true", true);
  xhttp.send();
  
});

var change = 0;

$("#report").click(function(){
  if (change == 0){
    $("#reported").css("visibility", "visible");
    change = change+1;
    console.log(change);
  }else {
    $("#reported").css("visibility", "hidden");
    change = change-1;
    console.log(change);
  }
});

$("#sumbutton").click(function(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      $("#errno").html(xhttp.responseText);
    }
  }
  xhttp.open("POST", "shoppingcart.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("message=" + $("#areaText").val());
  $("#areaText").val("");
});

$("#searchBar").keyup(function(){
  $("#cleared").html("");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      
      console.log();
      $("#cleared").html(xhttp.responseText);
    }
  }
  xhttp.open("POST", "shoppingcart.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("searchTerm=" + $("#searchBar").val());
});