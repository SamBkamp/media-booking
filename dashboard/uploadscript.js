

$(".button-two").click(function(){
    var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (xhttp.responseText == "Empty Basket"){

                }else if (xhttp.responseText == ""){
                    console.log("amp");
                    setTimeout(explode, 1500);
                    $("#grey").css("visibility", "visible");

                }else if(xhttp.responseText == "some items you chose have already been booked"){
                        $("#warning").text("warning: Some items you have chosen have already been booked");
                        $("#grey").css("visibility", "visible");
                        setTimeout(explode, 3000);
                }else if(xhttp.responseText == "you have too many thing booked"){
                  alert("you have booked too many items, the maximum allowed is 4");
                }else {
                    $("#warning").html(xhttp.responseText);
                    //$("#warning").html("one or more of your items could not be booked due to an internal error");
                    $("#grey").css("visibility", "visible");
                    setTimeout(explode, 3000);
                    
                }
                
            }

            
            };
            xhttp.open("GET", "shoppingcart.php?p=send", true);
            xhttp.send();
            
            

})    

function explode(){
    window.location.replace("/dashboard");
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