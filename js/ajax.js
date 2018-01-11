$(document).ready(function(){

	$( "#do_send" ).click(function() 
	{
		var name = $('[name="name"]').val();
		var email = $('[name="email"]').val();
		var message = $('[name="text_form"]').val();
		var csrf = $('[name="csrf"]').val();
		var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var response = grecaptcha.getResponse();

		if (name == "") {
			$("#send-result").text("Заполните поле Имя");
		} else if (email == "") {
			$("#send-result").text('Заполните поле Email');
		} else if (!pattern.test(email)) {
			$("#send-result").text('Поле Email заполнено неправильно');
		} else if (message == "") {
			$("#send-result").text('Заполните поле Сообщение');
		}  else if (response.length == 0) {
			$("#send-result").text('Заполните поле Recaptcha');
		} else {

			$.post( "../libs/submit.php", 
			{
				name: name,
				email: email,
				message: message,
				csrf: csrf,
				response: response
			},
			function( data ) {
				$( "#send-result" ).html( data );
			});

		}
	});

});