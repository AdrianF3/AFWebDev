console.log("running.");


// $(document).ready(function() {
//   //Event Listener all get in touch & contact buttons
//   let elements = document.getElementsByClassName("contact-modal");
//   for (let i = 0; i < elements.length; i++) {
//       elements[i].addEventListener("click", disModal);
//   }
//
//
// });
//
// function disModal(evt) {
//   evt.preventDefault();
//   $('#contactModal').modal();
//   console.log("modal called");
// }


//Automatic Function (event handelers)
// $(function () {
//    // your code goes here
//
// });
function ml_fitness() {
  alert("Matt Lane Example Called");
}


$( "#ml_fitness" ).click(function() {
  ml_fitness();
});
