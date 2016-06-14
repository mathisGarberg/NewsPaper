// If the code detect any errors, the php-code doesn't run

// Validate user input
function validate(e){
    fail = validate_username(this.username.value);
    fail += validate_password(this.password.value);		
    if(fail == '') { 
		return true; 
	}
	else {
	document.getElementById("errors").innerHTML = '<p>Please correct the following errors:</p>' + '<ul>' + fail + '</ul>'; 
	e.preventDefault();
	return false;
	}
}		
   
// Validate username
function validate_username(username){			
    var err = '';					
	if(username.trim() == '') {
		err = '<li>Username can not be empty.</li>';
	}
	
	if (!/^.{3,10}$/.test(username)) {
		err += '<li>User name should be between 3-10 characters.<li>';
	}
					
	if (/[^\w]/.test(username)) {
		err += "<li>Username should only include letters, numbers and '_'.</li>";
	}
	
	return err; 
}

// Validate password	
function validate_password(password){
    var err = '';			
    if(password.trim() == '') {
		err = 'Password can not be empty.<br>';
	}
	
	if (!/^.{5,}$/.test(password)) {
		err += '<li>Password should be minimum of 5 characters.</li>';
	}
					
	if (!/[a-z]/.test(password)) {
		err += '<li>Password should include at least one lowercase letter.</li>';
	}
					
	if (!/[A-Z]/.test(password)) {
		err += '<li>Password should include at least one uppercase letter.</li>';
	}	
	
    return err;
}

// 
document.querySelector('form').addEventListener('submit', validate);