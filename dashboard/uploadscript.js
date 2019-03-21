

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
                        setTimeout(explode, 10000);
                }else {
                    //$("#warning").html(xhttp.responseText);
                    $("#warning").html("one or more of your items could not be booked due to an internal error");
                    $("#grey").css("visibility", "visible");
                    setTimeout(explode, 10000);
                    
                }
                
            }
            };
            xhttp.open("GET", "shoppingcart.php?p=send", true);
            xhttp.send();
            
            

})    

function explode(){
    window.location.replace("/dashboard");
}