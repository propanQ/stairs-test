<?php 
	error_reporting(0);
	session_start();
	$success_csrf = false;
	$form_key = 'sendmassage_form';

	$data = $_POST;
	$send_error = array();
	$success_send = '<div style="color: #5AFF78;">Заявка успешно отправлена</div>';

	$secret = '6LfZcDoUAAAAAKbpNeMP1i5dB_f5HXgO5mqx7shC';
	$response = $data['response'];
	$remoteip = $_SERVER['REMOTE_ADDR'];

	$url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
	$result = json_decode($url, TRUE);

	if(hash_equals($_SESSION['csrf_' . $form_key], $data['csrf'])) {

		if ($result['success'] == 1) {
		
			$email = 'evgehich.un1@gmail.com';		

			$theme = 'Заявка от клиента STAIRS (Веб-сайт)';

			$letter = 'Данные сообщения: '. PHP_EOL .
			'Имя: '.$data['name']. PHP_EOL .
			'Email: '.$data['email']. PHP_EOL .
			'Сообщение: '.$data['message']. PHP_EOL;

			$headers = 'From: Веб-студия Stairs' . PHP_EOL .
			'Reply-To: '. $email . PHP_EOL .
			'X-Mailer: PHP/'. phpversion();

			mail($email, $theme, $letter, $headers);

		} else {
			$send_error[] = 'Recaptcha заполнена неправильно';
		}

	} else { 
		exit('Попытка CSRF атаки!');
	}
	
	if (!empty($send_error)) {
		echo  array_shift($send_error);	
	} else {
		echo($success_send);
	}



