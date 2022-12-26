
<?php include("includes/header.php"); ?>

<div class="container mlogin">
	<div id="login">
		<h1>Вхід</h1>
		<form action="" id="loginform" method="post"name="loginform">
			<p><label for="user_login">Email<br>
				<input class="input" id="email" name="email"size="20"
				type="text" value=""></label></p>
				<p><label for="user_pass">Пароль<br>
					<input class="input" id="password" name="password"size="20"
					type="password" value=""></label></p> 
					<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
					<p class="regtext">Ще не зареєстровані?<a href= "register.php">Реєстрація</a>!</p>
					<p class="regtext">Вхід адміна  <a href= "loginAdmin.php">Admin</a></p>
				</form>
			</div>
		</div>

		<?php
		session_start();
		?>

		<?php
		session_start();
		?>

		<?php require_once("includes/conection.php"); ?>
		<?php include("includes/header.php"); ?>	 
		<?php
		
		if(isset($_SESSION["session_email"])){

			header("Location: intropage.php");
		}

		if(isset($_POST["login"])){

			if(!empty($_POST['email']) && !empty($_POST['password'])) {
				$email=htmlspecialchars($_POST['email']);
				$password=htmlspecialchars($_POST['password']);
				$query =mysqli_query($con, "SELECT * FROM User_klient WHERE email='".$email."' AND password='".$password."'");
				$numrows=mysqli_num_rows($query);
				if($numrows!=0)
				{
					while($row=mysqli_fetch_assoc($query))
					{
						$dbemail=$row['email'];
						$dbpassword=$row['password'];
					}
					if($email == $dbemail && $password == $dbpassword)
					{

						$_SESSION['session_email']=$email;	 

						header("Location: intropage.php");
					}
				} else {


					echo  "Invalid email or password!";
				}
			} else {
				$message = "All fields are required!";
			}
		}
		?>



		<?php include("includes/footer.php"); ?>