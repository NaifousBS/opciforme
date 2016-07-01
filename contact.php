<?php
        $errName= "";
        $errEmail = "";
        $errMessage = "";
        $errHuman = "";
        $result = "";

if (isset($_POST["submit"])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$human = intval($_POST['human']);
		$from = 'OPCIFORME.fr'; 
		$to = 'opciforme@gmail.com';
        //ini_set("SMTP","smtp.sfr.fr");
        ini_set("sendmail_from",$from);
		$subject = 'Nouveau message du site OPCIFORME.fr';
		
		$body = "De:".$name."\n Mail:".$email."\n Message:\n ".$message;
 
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
		if ($human !== 5) {
			$errHuman = 'Résultat incorrect';
		}
 
// Envoi du mail s'il n'y a pas d'erreur
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
	if (mail ($to, $subject, $body, $from)) {
		$result='<div class="alert alert-success">Merci! Nous vous répondrons rapidement! <i class="fa fa-smile-o" aria-hidden="true"></i></div>';
	} else {
		$result='<div class="alert alert-danger">Désolé il y a eu une erreur lors de l\'envoi, réessayez SVP.</div>';
	}
}
	}
?>
<!-- CSS -->
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<link href="assets/css/simple-line-icons.css" rel="stylesheet" media="screen">
	<link href="assets/css/animate.css" rel="stylesheet">
    
	<!-- Custom styles CSS -->
	<link href="assets/css/style.css" rel="stylesheet" media="screen">
    
    <script src="assets/js/modernizr.custom.js"></script>


			<div class="row">

				<div class="col-sm-6 col-sm-offset-3">

					<div class="pfblock-header">
						<h2 class="pfblock-title">Envoyez-nous un message</h2>
						<div class="pfblock-line"></div>
						<div class="pfblock-subtitle">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<button type="button" class="btn btn-primary" onclick="window.open('https://www.facebook.com/profile.php?id=100008769211783&fref=ts')">
									<i class="fa fa-facebook"></i>
								</button>
								<button type="button" class="btn btn-primary" onclick="window.open('https://fr.linkedin.com/in/mouloud-besbiss-977a4a68')">
									<i class="fa fa-linkedin" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<br/><br/>
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
									<label for="human" class="col-sm-2 control-label">2 + 3 = ?</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="human" name="human" placeholder="Réponse">
									</div>
                                    <?php         
                                        echo "<p class='text-danger'>".$errHuman."</p>";
                                    ?>
								</div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <input id="submit" name="submit" type="submit" value="Envoyer" class="btn btn-primary">
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="button" name="retour" class="btn btn-warning" onclick="window.location='index.php'">
                                                Retour
                                            </button>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php
                                            echo $result;
                                        ?>	
                                    </div>
                                </div>
							</form>
						</div>
					</div>

				</div>
            </div>

<?php include('footer.php'); ?>