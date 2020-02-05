window.onload = function () {
  console.log('loaded');
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("create-project-button");

 var clickHandler = function() {
  console.log('clicked');
  modal.style.display = "block";
}

// When the user clicks the button, open the modal 
btn.addEventListener('click', clickHandler);

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  console.log('outside');
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
}
