function booking(cookie, id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        }
      };
      xhttp.open("GET", "return.php?item=" + id + "&auth=" + cookie, true);
      xhttp.send();
}