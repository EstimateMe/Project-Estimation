
function validateForm(){
	
	var account_type = document.getElementById('register_form').account_type.value;
	var email = document.getElementById('register_form').email.value;
	var username = document.getElementById('register_form').username.value;
	var password = document.getElementById('register_form').password.value;
	var confirm_password = document.getElementById('register_form').confirm_password.value;

	if (!account_type) {
        document.getElementById('error-type-acc').innerHTML = "Моля изберете една от опциите *<br>";
    }
	
	if (email.length<1) {
        document.getElementById('error-email').innerHTML = "Моля въведете имейл *<br>";
    }
	else {
		var reg = new RegExp("^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$");
		if(!reg.test(email))
			document.getElementById('error-email').innerHTML = "Невалиден имейл *";
	}
	
	if (username.length<1) {
        document.getElementById('error-username').innerHTML = "Моля въведете потребителско име *<br>"
    }
    
    if (password.length<1) {
        document.getElementById('error-password').innerHTML = "Моля въведете парола *<br>" ;      
    }
    if (confirm_password!==password) {
        document.getElementById('error-confirm-password').innerHTML = "Паролите не съвпадат *";
    }          
    if(username.length<1 || email.length<1 || password.length<1 || confirm_password.length<1){
       	return false;
    }            
}

window.onload = function () {
  console.log('loaded');

$('#register').click(function() {
	console.log('register');
	
$.ajax({
    type: 'POST',
    url: "register_script.php",
    data: $('#register_form').serialize()
})
.done(function(data){

//Set the message text
$('#result').text(data);

//Clear the form
$('#register_form')[0].reset();

});
});
}