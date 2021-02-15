<?php
// Файлы phpmailer
//use PHPMailer\PHPMailer\PHPMailer;

function debug($data)
{
	echo '<pre>' . print_r($data, 1) . '</pre>';
}


function load($data)
{

	if ($data) {
		foreach ($_POST as $key => $value) {
			if (array_key_exists($key, $data)) {

				$data[$key]['value'] = trim($value);
			}
		}
	}
	return $data;
}

function validate($data)
{
	$errors = '';

	if ($data) {
		foreach ($data as $key => $value) {
			if ($data[$key]['required'] && empty($data[$key]['value'])) {
				$errors .= "<li>Вы не заполнили обязательное поле {$data[$key]['field_name']}</li>";
			}
		}
	}
	return $errors;
}

function clear_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function send_mail($fields, $mail_settings)
{
	$mail = new \PHPMailer\PHPMailer\PHPMailer();

	try {
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = $mail_settings['host'];
		$mail->SMTPAuth = $mail_settings['smtp_auth'];
		$mail->Username = $mail_settings['username'];
		$mail->Password = $mail_settings['password'];
		$mail->SMTPSecure = $mail_settings['smtp_secure'];
		$mail->Port = $mail_settings['port'];

		$mail->setFrom($mail_settings['from_email'], $mail_settings['from_name']);
		$mail->addAddress($mail_settings['to_email']);

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Form from the site';

		$flag = true;
		$message = '';
		foreach ($fields as $k => $v) {
			if (isset($v['mailable']) && $v['mailable'] == 0) {
				continue;
			}
			$message .= (($flag = !$flag) ? '<tr>' : '<tr style="background-color: #f8f8f8;">') . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>{$v['field_name']}</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>{$v['value']}</td>
			</tr>";
		}

		$mail->Body = "<h1></h1>
		<table style='width: 100%;'>$message</table>";
		if (!$mail->send()) {
			return false;
		}

		return true;
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		return false;
	}
}
