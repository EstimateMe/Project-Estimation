window.onload = function () {
  console.log('loaded');
// Get the modal
var modal = document.getElementById("deleteProject");
var no_button = document.getElementById("delete-no");


// Get the button that opens the modal
var btn = document.getElementById("delete-project-button");

 var clickHandler = function() {
  console.log('clicked');
  modal.style.display = "block";
}

// When the user clicks the button, open the modal 
btn.addEventListener('click', clickHandler);

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  console.log('outside');
  if (event.target == modal || event.target == no_button ) {
    modal.style.display = "none";
  }
  
}
}