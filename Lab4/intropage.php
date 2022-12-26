<?php

session_start();

if(!isset($_SESSION["session_email"])):
  header("location:login.php");
else:
  ?>
  
  <?php include("includes/header.php"); ?>
  <div id="welcome">
    <h2>Ласкаво просимо, <span><?php echo $_SESSION['session_email'];?>! </span></h2>
    <p><a href="logout.php">Вийти</a> з системи</p>
  </div>
  <?php
  header ('Refresh: 5; url=http://localhost/lab4/menu.php');
  exit;
  ?>
  <?php include("includes/footer.php"); ?>
  
<?php endif; ?>
