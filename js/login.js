(function () {
	'use strict'

	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')

	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
		.forEach(function (form) {
			form.addEventListener('submit', function (event) {
				if (!form.checkValidity()) {
					event.preventDefault()
					event.stopPropagation()
				}

				form.classList.add('was-validated')
			}, false)
		})
})()
var other = document.getElementById('other')		
checkSelect = (val) => {
	if (val.value == 'Other') {
		other.style.display='block'		
	} else {
		other.style.display='none'		
	}
}
check = () => {
	var checkBox = document.getElementById("termCheck")
	if(checkBox.checked == true){		
		checkBox.value=true		
	}else{
		checkBox.value=false				
	}
}