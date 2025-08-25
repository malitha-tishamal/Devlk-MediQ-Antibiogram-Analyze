$(document).ready(function(){
	$('#newPassword, #confirmPassword').on('keyup', function(){
		let newPassword = $('#newPassword').val();
		let confirmPassword = $('#confirmPassword').val();
		
		if (((newPassword.trim() !== "") && (confirmPassword.trim() !== "")) && newPassword !== confirmPassword) {
			$('#confirmNewPasswordErrorMessage').html('* Unmatched new password and re-entered new password');
			$('#confirmNewPasswordErrorMessage').addClass('pt-1');
		}else{
			$('#confirmNewPasswordErrorMessage').html('');
		}
	});

	$("#submitButton").click(function(){
		let isEmpty = false;
        let isValidNic = validateNic(document.getElementById("nicNumber"));
        let isValidMobile = validateMobile(document.getElementById("mobileNumber"));

		$("input, select").each(function(){
		  if($(this).val() === ''){
			isEmpty = true;
			return false; // Exit the loop if any field is empty
		  }
		});
	
		if(isEmpty || !isValidNic || !isValidMobile){
		  $('#confirmSubmitModal').modal('hide');
		}
	});
});

function togglePasswordVisibility(inputId, iconClass) {
	var passwordInput = document.getElementById(inputId);
	var icon = document.querySelector('.' + iconClass);
	
	passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
	icon.classList.toggle('bxs-hide');
	icon.classList.toggle('bxs-show');
}

function validateNic(nic) {
    const isValid = /^\d{12}$|^\d{9}V$/.test(nic.value.trim());
    nic.setCustomValidity(isValid ? '' : ' ');
    document.getElementById('nicErrorMessage').innerText = isValid ? '' : (nic.value ? 'Invalid NIC number' : 'Please enter the NIC number');
    nic.classList.toggle('is-invalid', !isValid);
    nic.classList.toggle('is-valid', isValid);
	return isValid;
}

function validateMobile(mobile) {
    const isValid = /^7\d{8}$/.test(mobile.value.trim());
    mobile.setCustomValidity(isValid ? '' : ' ');
    document.getElementById('numberErrorMessage').innerText = isValid ? '' : (mobile.value ? 'Invalid mobile number' : 'Please enter the mobile number');
    mobile.classList.toggle('is-invalid', !isValid);
    mobile.classList.toggle('is-valid', isValid);
	return isValid;
}



// var nic = document.getElementById(nicNumber).value;

	// if (/^\d{12}$/.test(nic) || /^\d{9}V$/.test(nic) || nic == "") {
	// 	$('#nicErrorMessage').html('');
	// } else {
	// 	$('#nicErrorMessage').html('* Not a valid nic');
	// 	$('#cnicErrorMessage').addClass('pt-1');
	// }