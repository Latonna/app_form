"use strict"

$('.options__item').hover(
	function () {
		$('.options__tooltip').toggleClass('active');
	}
);

document.addEventListener('DOMContentLoaded', function () {
	const container = document.getElementById('forms__container');

	var forms = document.getElementsByClassName('needs_validate');
	var validation = Array.prototype.filter.call(forms, function (form) {
		form.addEventListener('submit', function (e) {

			if (formValidate(form)) {
				e.preventDefault();
				e.stopPropagation();
			} else {
				e.preventDefault();
				e.stopPropagation();

				$.ajax({
					url: 'index.php',
					type: 'POST',
					data: $('#' + e.target.id).serialize(),
					beforeSend: function () {
						container.classList.add('_sending');
						form.reset();
						resetReqInputs();
					},
					success: function (response) {
						container.classList.remove('_sending');
						let res = JSON.parse(response);
						alert(res.message);
					},
					error: function () {
						alert('Error');
					}
				})
			}
		});
	});

	var inputs = document.getElementsByClassName('input_error');
	var validation = Array.prototype.filter.call(inputs, function (input) {
		input.addEventListener('focus', function (e) {
			alert(1);
		});
	});

	function resetReqInputs() {
		let formReq = document.querySelectorAll('._req');
		for (let index = 0; index < formReq.length; index++) {
			const input = formReq[index];
			formRemoveClass(input, 'input_error');
			formRemoveClass(input, 'input_ok');
		}
	}

	function formValidate(form) {
		let error = 0;
		let formReq = form.querySelectorAll('._req');

		for (let index = 0; index < formReq.length; index++) {
			const input = formReq[index];
			formRemoveClass(input, 'input_error');
			formRemoveClass(input, 'input_ok');

			if (input.classList.contains('_email')) {
				if (emailTest(input)) {
					formAddClass(input, 'input_error');
					error++;
				} else {
					formAddClass(input, 'input_ok');
				}
			}
			else if (input.classList.contains('_password')) {
				if (passTest(input)) {
					formAddClass(input, 'input_error');
					error++;
				}
				else {
					formAddClass(input, 'input_ok');
				}
			} else if (input.classList.contains('_alpha')) {
				if (nameTest(input)) {
					formAddClass(input, 'input_error');
					error++;
				} else {
					formAddClass(input, 'input_ok');
				}
			}
			else {
				if (input.value === '') {
					formAddError(input);
					error++;
				}
			}
		}
		return error;
	}


	function formRemoveClass(input, className) {
		input.parentElement.classList.remove(className);
		input.classList.remove(className);
	}
	function formAddClass(input, className) {
		input.parentElement.classList.add(className);
		input.classList.add(className);
		$(input).focus(function () {
			formRemoveClass(input, 'input_error');
		})
		$(input).blur(function () {
			if ($(input).val() == '') {
				formAddClass(input, 'input_error');
			}
		})
	}

	function emailTest(input) {
		return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
	}

	function passTest(input) {
		return !/^[а-яА-ЯёЁa-zA-Z0-9\\s]+$/.test(input.value);
	}

	function nameTest(input) {
		return !/^[а-яА-ЯёЁa-zA-Z\\s]+$/.test(input.value);
	}
});
