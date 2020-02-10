window.onload = function () {
  addRowHandlers();
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("create-task-button");

 var clickHandler = function() {
  modal.style.display = "block";
}

// When the user clicks the button, open the modal 
btn.addEventListener('click', clickHandler);

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

const input = document.querySelector('input');
const log = document.getElementById('values');

input.addEventListener('input', updateValue);

function updateValue(e) {
  log.textContent = e.target.value;
}

$('#display-button').click(function(){
// взима стринга с таговете
var tags=$('#tags').val();
//console.log(typeof tags);//string

$.ajax({
method: "post",
url: "estimate_task.php",
data:{tags:tags} // първото го ползваме в _task.php, а втоото е стойността на променливата tags
})
.done(function(data){
//console.log('result');
$('#hours').val(data);

});
});

// logic for opening a modal when clicking on already created task row
function addRowHandlers() {
  var table = document.getElementById("tasks-table");
  var rows = table.getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    var currentRow = table.rows[i];
    var createClickHandler = function(row) {
      return function() {
        var cell = row.getElementsByTagName("td")[0];
        var id = cell.innerHTML;
        alert("TODO: The creation modal should open prepopulated after row clicked.");
      };
    };
    currentRow.onclick = createClickHandler(currentRow);
  }
}


}
