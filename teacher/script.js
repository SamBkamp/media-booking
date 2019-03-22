$("#returnico").click(function(){
  $("#grey").css("visibility", "visible");
});

$("#grey").click(function(){
  $("#grey").css("visibility", "hidden");
});


function booking(cookie, id, ident) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          
          if (xhttp.responseText == "everything-ok"){
            location.reload();
          }else {
            alert(xhttp.responseText);
          }
          
        }
      };
      xhttp.open("GET", "return.php?item=" + id + "&auth=" + cookie + "&ident=" + ident, true);
      xhttp.send();
}

$("#addFile").click(function(){
  console.log("yar");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      window.location.replace("/");
    }
  };
  xhttp.open("GET", "return.php?logout=true", true);
  xhttp.send();
  
});