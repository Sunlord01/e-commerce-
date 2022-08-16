<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/connexion.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
	<title>MBOA SHOP: Connexion</title>
</head>
<body>

	<a href="index.php" class="retour">←</a>

	<?php if (!empty($_GET['i']) && $_GET['i'] == "1") {	?>

	<section class="container">
		<span><h1>Create your Mboa account</h1></span>
	
		<span class="lop">Mboa Shop<sub>online site par excellence de E-commerce camerounais</sub></span>

		<form method="post" action="index.php?un=connexion&i=1">
			<div class="input-field">
			<input type="text" name="nom" required placeholder="First Name">
           </div>
		   <div class="input-field">
			<input type="text" name="prenom" required placeholder="Last Name">
			</div>
			<div class="input-field">
			<input type="mail" name="mail" required placeholder="Email">
			</div>
			<div class="input-field">
			<input type="text" name="pseudo" required placeholder="Username">
			</div>
			<div class="input-field">
			<input type="password" class="password" name="pass" required placeholder="Password">
			<i class="uil uil-eye"></i>
			<i class="uil uil-eye-slash showHidePw"></i>
            </div>
			<div class="checkbox-text">
				<div class="checkbox-content">
					<pre>
		<input type="checkbox" name="choix"><label> I agree to the google Terms of Service and Privacy Policy</label>
	               </pre>
			</div>
			</div>
			<div class="input-field button">
			<input type="button" value="Sign up" class="liens" >
		</div>
		</form>
            <div class="login-signup">
		<span>are you already a member?<a href="index.php?un=connexion"> Se connecter.</a></span>
		</div>

	</section>
 
	<?php } 

	elseif (!empty($_GET['m']) && $_GET['m'] == "1") {	?>

	<section class="container">
		<span><h1>Forgot your password?</h1></span>
		<pre>
		<span class="lop">           Enter your email or phone number 
			        and recever your account
		</span>
	</pre>
		<form method="post" action="index.php?un=connexion">
		<div class="input-field">
			<input type="mail" name="mail" required placeholder="Email">
			</div>
			<div class="li">
			  <p>OR</p> 
</div>
			<div class="input-field">
			<input type="text" name="tel" required placeholder="Phone Number">
			</div>
			<div class="input-field button">
			<input type="button" value="Reset password" class="liens" >
		</div>
			
		</form>

		
	</section>	

	<?php }

	elseif (!empty($_GET['i']) && $_GET['i'] == "o") {   ?>
		
	<section class="container">
		<mark>modifier le mot de passe</mark>
		<img src="image/user.png">

		<form method="post" action="">
			<input type="hidden" name="mpw" value="1" >
			<p>Pseudo:<?php echo $_SESSION['pseudo']; ?></p>
			<p>Mail:<?php echo $_SESSION['mail']; ?></p>
			<label>Nouveau MDP:</label><input type="password" name="pass" required> 
			<input type="submit" value="Changer de mot de passe" class="liens" >
		</form>

		<span>votre mot de passe sera modifier.</span>
	</section>

	<?php }

	 else{	?>

	<section class="container">
	<span><h1>Log in</h1></span>
	
	<span class="lop">Mboa Shop<sub>online site par excellence de E-commerce camerounais</sub></span>

		<form method="post" action="index.php?un=connexion">
		<div class="input-field">
			<input type="mail" name="mail" required placeholder="Email">
	 </div>
	 <div class="input-field">
			<input type="password" class="password" name="pass" required placeholder="Password">
			<i class="uil uil-eye-slash showHidePw"></i>
            </div>
			<div class="checkbox-text">
				<div class="checkbox-content">
			<input type="checkbox" name="choix"><label> keep me signed in</label>
			</div>
			<span> <a href="index.php?un=connexion&m=1">Forgot password?</a></span>
			</div>
			
			<div class="input-field button">
			<div class="input-field button mo">
			<input type="button" value="Facebook" class="liens" >
			
			<input type="button" value="Gmail" class="liens" >
	 </div>
			<input type="button" value="Sign in" class="liens" >
		</div>
			
		</form>
		<div class="login-signups">
		<span>Not a member yet?<a href="index.php?un=connexion&i=1"><strong>   Sign up</strong></a></span>
		</div>
		
	</section>

	<?php } ?>
<script src="js/paswrd.js"></script>
</body>
</html>