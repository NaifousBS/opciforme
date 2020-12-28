<?php 
require 'assets/phpmailer/src/Exception.php';
require 'assets/phpmailer/src/PHPMailer.php';
require 'assets/phpmailer/src/SMTP.php';

include('header.php');
// require_once 'assets/swiftmailer/lib/swift_required.php';
include_once 'assets/php/definition.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
//require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$errName= "";
$errEmail = "";
$errMessage = "";
$errHuman = "";
$result = "";

$varA = rand(0,20);
$varB = rand(0,20);
$sum = $varA + $varB;
session_start();
if (!isset($_SESSION['sum'])) {
	$_SESSION['sum'] = array();
}
array_push($_SESSION['sum'], $sum);

if (isset($_POST["submit"])) {
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);
		$human = intval($_POST['human']);
		$from = 'OPCIFORME'; 
		$to = 'opciforme@gmail.com';
		$subject = 'Nouveau message du site OPCIFORME';
		
		$body = 'De: <b>'.$name.'</b><br>Mail: <b>'.$email.'</b><br><br>'.$message;

		// Check if name has been entered
		if (!$_POST['name']) {
            $errName= 'Entrez votre nom';
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
		$correctsum = $_SESSION['sum'][count($_SESSION['sum']) - 2];
		if ($human !== $correctsum) {
			$errHuman = 'Résultat incorrect';
		}
    
try {
// Envoi du mail s'il n'y a pas d'erreur
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = SMTP_SERVER;                    		// Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = GMAIL;                     				// SMTP username
		$mail->Password   = PWD;                               		// SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom($email, $name);
		$mail->addAddress($to);     // Add a recipient

		// Content           
		$mail->isHTML(true);               
		$mail->Subject = $subject;
		$mail->Body    = $body;

		$mail->send();
    
		$result='<div class="alert alert-success">Merci! Nous vous répondrons rapidement! <i class="fa fa-smile-o" aria-hidden="true"></i></div>';
	 
} else {
		$result='<div class="alert alert-danger">Désolé il y a eu une erreur lors de l\'envoi, réessayez SVP.</div>';
	}
    } catch (Exception $e) {
     echo '<script>console.log(\'Exception reçue : '.$e->getMessage().'\');</script>';
     $result='<div class="alert alert-danger">Une erreur est survenue, veuillez nous excuser pour le désagrément.</div>';
}
}
?>
			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">

					<div class="pfblock-header">
						<h2 class="pfblock-title" style="margin-top:100px">Formulaire de contact</h2>
						<div class="pfblock-line"></div>
						<div class="pfblock-subtitle">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<!--<button type="button" class="btn btn-primary" onclick="window.open('index.html')">
									<i class="fa fa-facebook"></i>
								</button>-->
								<button type="button" class="btn btn-primary" onclick="window.open('https://fr.linkedin.com/in/mouloud-besbiss-977a4a68')">
									<i class="fa fa-linkedin" aria-hidden="true"></i>
								</button>
                                <button type="button" class="btn btn-info" onclick="window.location='mailto:opciforme@gmail.com'">
									<i class="fa fa-envelope"></i>
								</button>
							</div>
						</div>
						<br/>
                            <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php
                                            echo $result;
										?>	
                                    </div>
                            </div>
                        <br/>
							<form class="form-horizontal" role="form" method="post" action="contact.php">
								<div class="form-group">
									<label for="name" class="col-sm-2 control-label">Nom</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="name" name="name" placeholder="Nom & Prénom" value="<?php if(isset($_POST['name'])){echo htmlspecialchars($_POST['name']);} ?>">
									</div>
                                    <?php
                                        echo "<p class='text-danger'>".$errName."</p>";
                                    ?>	
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" id="email" name="email" placeholder="exemple@domaine.com" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email']);} ?>">
									</div>
                                    <?php         
                                        echo "<p class='text-danger'>".$errEmail."</p>";
                                    ?>	
								</div>
								<div class="form-group">
									<label for="message" class="col-sm-2 control-label">Message</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="4" name="message" placeholder="Entrez votre message ..."><?php if(isset($_POST['message'])){ echo htmlspecialchars($_POST['message']);} ?></textarea>
									</div>
                                    <?php         
                                        echo "<p class='text-danger'>".$errMessage."</p>";
                                    ?>	
								</div>
								<div class="form-group">
									<label for="human" class="col-sm-2 control-label"><?php echo $varA.' + '.$varB;?> = </label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="human" name="human" placeholder="Réponse">
									</div>
                                    <?php         
                                        echo "<p class='text-danger'>".$errHuman."</p>";
                                    ?>
								</div>
                                    <input id="submit" name="submit" type="submit" value="Envoyer" class="btn btn-primary">
                                    <button type="button" name="retour" class="btn btn-warning" onclick="window.location='index.php'">
                                        Retour
                                    </button>
							</form>
						</div>
					</div>

				</div>
            </div>