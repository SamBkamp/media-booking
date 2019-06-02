

$(".button-two").click(function(){
    var xhttp = new XMLHttpRequest();
    if($("#dateout").val() == "" || $("#datein").val() == ""){
      return false;
    }else{}
            xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (xhttp.responseText == "Empty Basket"){
                  return false;
                }else if (xhttp.responseText == "succ"){
                    console.log("amp");
                    setTimeout(explode, 1500);
                    $("#grey").css("visibility", "visible");

                }else if(xhttp.responseText == "some items you chose have already been booked"){
                        $("#warning").text("warning: Some items you have chosen have already been booked");
                        $("#grey").css("visibility", "visible");
                        setTimeout(explode, 3000);
                }else if(xhttp.responseText == "you have too many thing booked"){
                  alert("you have booked too many items, the maximum allowed is 4");
                }else if (xhttp.responseText == "date"){
                  alert("please double check your dates");
                }else if (xhttp.responseText == "fail"){
                  alert("there was an error with the database");
                }else {
                    $("#warning").html(xhttp.responseText);
                    //$("#warning").html("one or more of your items could not be booked due to an internal error");
                    $("#grey").css("visibility", "visible");
                    //setTimeout(explode, 3000);
                    
                }
                
            }

            
            };
            xhttp.open("GET", "shoppingcart.php?p=send&dateout=" + $("#dateout").val()+"&datein=" + $("#datein").val(), true);
            xhttp.send();
            console.log($("#datein").val());
            console.log($("#dateout").val());
            
            

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