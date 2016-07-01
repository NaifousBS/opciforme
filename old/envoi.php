<?php
	ini_set("SMTP","smtp.sfr.fr");
	ini_set("smtp_port","465");  
	if (isset($_POST["submit"])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$human = intval($_POST['human']);
		$from = 'OPCIFORME.fr'; 
		$to = 'soufian1993@hotmail.fr'; 
		$subject = 'Message reçu du formulaire de contact';
		
		$body = "De: $name\n Mail: $email\n Message:\n $message";
 
		// Check if name has been entered
		if (!$_POST['name']) {
			$errName = 'Entrez votre nom';
		}
		
		// Check if email has been entered and is valid
		if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errEmail = 'Entrez une adresse mail valide';
		}
		
		//Check if message has been entered
		if (!$_POST['message']) {
			$errMessage = 'Entrez votre message';
		}
		//Check if simple anti-bot test is correct
		if ($human !== 5) {
			$errHuman = 'Résultat incorrect';
		}
 
// If there are no errors, send the email
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
	if (mail ($to, $subject, $body, $from)) {
		$result='<div class="alert alert-success">Merci! Nous vous répondrons rapidement :)</div>';
	} else {
		$result='<div class="alert alert-danger">Désolé il y a eu une erreur lors de l\'envoi, réessayez SVP.</div>';
	}
}
header('location:index.php#contact');
	}
?>