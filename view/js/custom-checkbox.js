(function () {
  var all_checkbox = document.getElementsByClassName("invisible_checkbox");

  for(var i = 0; i < all_checkbox.length; i++) {
    var checkbox_id = all_checkbox[i].id;
    var div_id = checkbox_id+"_proxy";
    var div_element = document.getElementById(div_id);
    if(all_checkbox[i].checked == true) {
      div_element.setAttribute("class", "image-checkbox-checked");
    } else {
      div_element.setAttribute("class", "image-checkbox");
    }
  }
})();

function load() {
  var all_checkbox_divs = new Array();
  for(var i = 0; i < all_checkbox.length; i++) {
    div_id = all_checkbox[i].id+"_proxy";
    all_checkbox_divs[i] = document.getElementById(div_id);
  }

  for (var i=0;i<all_checkbox_divs.length;i++) {

    all_checkbox_divs[i].onclick = function (e) {
      var div_id = this.id;
      var checkbox_id =div_id.split("_")[0];
      var checkbox_element = document.getElementById(checkbox_id);

      if (checkbox_element.checked == true) {
        checkbox_element.checked = false;
        this.setAttribute("class","image-checkbox");
      } else {
        checkbox_element.checked = true;
        this.setAttribute("class","image-checkbox-checked");
      }
    }
  }
}

/*function load() {
 var all_checkbox_divs = document.getElementsByClassName("image-checkbox");

 for (var i=0;i<all_checkbox_divs.length;i++) {
   all_checkbox_divs[i].onclick = function (e) {
     var div_id = this.id;
     var checkbox_id =div_id.split("_")[0];
     var checkbox_element = document.getElementById(checkbox_id);

     if (checkbox_element.checked == true) {
       checkbox_element.checked = false;
       this.setAttribute("class","image-checkbox");
     } else {
       checkbox_element.checked = true;
       this.setAttribute("class","image-checkbox-checked");
     }
   }
 }
 };*/
