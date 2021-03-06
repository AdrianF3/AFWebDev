//console.log("running.");


$(document).ready(function() {
  //Event Listener all get in touch & contact buttons
  let elements = document.getElementsByClassName("contact-modal");
  for (let i = 0; i < elements.length; i++) {
      elements[i].addEventListener("click", disModal);
  }
  //Event Listener For Attribution Modal
  //document.getElementById("attribution").addEventListener("click", attrModal);
   $('[data-toggle="popover"]').popover({html:true});

});

// function disModal(evt) {
//   evt.preventDefault();
//   $('#contactModal').modal();
//   console.log("modal called");
// }
//
// function attrModal(evt) {
//   //$('#attribution').modal();
//   console.log("Attribute Called");
// }
