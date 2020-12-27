//console.log("running.");


//Event Listener all get in touch & contact buttons
$( document ).ready(function() {
  document.getElementById("contact").addEventListener("click", disModal);
  document.getElementById("getInTouch").addEventListener("click", disModal);
});


function disModal(evt) {
  evt.preventDefault();

  $('#contactModal').modal();
  console.log("modal called");
}
