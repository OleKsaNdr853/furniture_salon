
<?php include("includes/headerAdmin.php"); ?>

<div class="container mloginAdmin">
	<div id="login">
		<h1>Вхід</h1>
		<form action="" id="loginform" method="post"name="loginform">
			<p><label for="user_login">Email<br>
				<input class="input" id="Email" name="Email"size="20"
				type="text" value=""></label></p>
				<p><label for="user_pass">Пароль<br>
					<input class="input" id="Paroli" name="Paroli"size="20"
					type="password" value=""></label></p> 
					<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
				</form>
			</div>
		</div>

		<?php
		session_start();
		?>

		<?php require_once("includes/dbcon.php"); ?>
		<?php include("includes/headerAdmin.php"); ?>	 
		<?php
		
		if(isset($_SESSION["session_Email"])){

			header("Location: menuAdmin.php");
		}

		if(isset($_POST["login"])){

			if(!empty($_POST['Email']) && !empty($_POST['Paroli'])) {
				$Email=htmlspecialchars($_POST['Email']);
				$Paroli=htmlspecialchars($_POST['Paroli']);
				$query =mysqli_query($con, "SELECT * FROM Spivrobitnuki WHERE Email='".$Email."' AND Paroli='".$Paroli."'");
				$numrows=mysqli_num_rows($query);
				
				if($numrows!=0)
				{
					while($row=mysqli_fetch_assoc($query))
					{
						$dbEmail=$row['Email'];
						$dbParoli=$row['Paroli'];
					}
					if($Email == $dbEmail && $Paroli == $dbParoli)
					{

  header ('Refresh: 0; url=http://localhost/lab4/menuAdmin.php');
  exit;
  
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



		<?php include("includes/footer.php"); ?>