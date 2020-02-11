window.onload = function () {
var modal2 = document.getElementById("deleteProject");
var no_button = document.getElementById("delete-no");
var btn2 = document.getElementById("delete-project-button");

var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("create-task-button");

 var clickHandler2 = function() {
  modal2.style.display = "block";
}
 var clickHandler = function() {
  modal.style.display = "block";

}
btn.addEventListener('click', clickHandler);
btn2.addEventListener('click', clickHandler2);
no_button.addEventListener('click', clickHandler2);
// When the user clicks the button, open the modal 


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal || event.target == modal2 || event.target == no_button) {
    modal.style.display = "none";
	modal2.style.display="none";
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

document.querySelectorAll('.change_status').forEach(item => {
  item.addEventListener('click', event => {
    // взима стринга с таговете
    var status = $('#status-select').val();
    var task_title = document.getElementsByName('task_name')[0].value;
    // console.log('TASK NAME: ', task_title);
    // console.log('STATUS: ', status);
    $.ajax({
      method: "post",
      url: "change_status.php",
      data: { status: status, task_title: task_title } // първото го ползваме в _task.php, а втоото е стойността на променливата tags
    })
      .done(function (data) {
        // console.log(data);
      });
  })
})
}
