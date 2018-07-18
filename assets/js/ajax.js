function showSubject(str,str2,str3) {
    if (str == "") {
        document.getElementById(str3).innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(str3).innerHTML = this.responseText;
                $('#subjects').selectpicker('refresh');
                $('#subject').selectpicker('refresh');
                $('#sub').selectpicker('refresh');
                $('#examid').addClass('selectpicker');
                $('#examid').selectpicker('refresh');
                $("#chatbtn").removeAttr('disabled');

            }
        };
        xmlhttp.open("GET","ajax.php?"+str2+"="+str,true);
        xmlhttp.send();

    }


}

function ref(){
    $('.selectpicker').selectpicker('refresh');
}