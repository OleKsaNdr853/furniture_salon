<?php include("includes/header.php"); ?>
<?php include("menu.php"); ?>
<?php


$dsn = 'mysql:host=localhost;dbname=furniture_salon';
$username = 'root';
$password = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}

$id_prodagy = '';
$id_cpivrobitnuki = '';
$id_mebli = '';
$id_klient = '';
$Date_prodagy = '';
$Cposib_oplatu = '';
$Name = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['id_prodagy'];
    $posts[1] = $_POST['id_cpivrobitnuki'];
    $posts[2] = $_POST['id_mebli'];
    $posts[3] = $_POST['id_klient'];
    $posts[4] = $_POST['Date_prodagy'];
    $posts[5] = $_POST['Cposib_oplatu'];
    $posts[6] = $_POST['Name'];
    
    return $posts;
}

//Search And Display Data 

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT * FROM Sale_mebli WHERE id_prodagy = :id_prodagy');
        $searchStmt->execute(array(
            ':id_prodagy'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $id_prodagy  = $user[0];
            $id_cpivrobitnuki = $user[1];
            $id_mebli    = $user[2];
            $id_klient = $user[3];
            $Date_prodagy = $user[4];
            $Cposib_oplatu= $user[5];
            $Name= $user[6];
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) || empty($data[6]))
    {
        echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO Sale_mebli(id_cpivrobitnuki,id_mebli,id_klient,Date_prodagy,Cposib_oplatu,Name) VALUES(:id_cpivrobitnuki,:id_mebli,:id_klient,:Date_prodagy,:Cposib_oplatu,:Name)');
        $insertStmt->execute(array(
            ':id_cpivrobitnuki'  => $data[1],
            ':id_mebli'      => $data[2],
            ':id_klient'  => $data[3],
            ':Date_prodagy'   => $data[4],
            ':Cposib_oplatu'  => $data[5],
            ':Name'  => $data[6],
        ));
        
        if($insertStmt)
        {
            echo 'Data Inserted';
        }
        
    }
}

//Update Data

if(isset($_POST['update']))
{
    $data = getPosts();
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) || empty($data[6]))
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE Sale_mebli SET id_cpivrobitnuki = :id_cpivrobitnuki, id_mebli = :id_mebli, id_klient = :id_klient, Date_prodagy = :Date_prodagy, Cposib_oplatu = :Cposib_oplatu, Name = :Name WHERE id_prodagy = :id_prodagy');
        $updateStmt->execute(array(
            ':id_prodagy'=> $data[0],
            ':id_cpivrobitnuki'=> $data[1],
            ':id_mebli'=> $data[2],
            ':id_klient'=> $data[3],
            ':Date_prodagy'=> $data[4],
            ':Cposib_oplatu'  => $data[5],
            ':Name'  => $data[6],
        ));
        
        if($updateStmt)
        {
            echo 'Data Updated';
        }
        
    }
}

// Delete Data

if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User ID To Delete';
    }  else {
        
        $deleteStmt = $con->prepare('DELETE FROM Sale_mebli WHERE id_prodagy = :id_prodagy');
        $deleteStmt->execute(array(
            ':id_prodagy'=> $data[0]
        ));
        
        if($deleteStmt)
        {
            echo 'User Deleted';
        }
        
    }
}

?>

<div class="menub">
    <head>
        <title>Sale_mebli.com</title>  
    </head>
    <body>
        <form action="" id="loginform" method="post"name="loginform">
            <form action="sale_mebli.php" method="POST">

                <label for="">id_prodagy<br>
                    <input class="input"type="text" name="id_prodagy" value="<?php echo $id_prodagy;?>"><br></p>
                    <label for="">id_cpivrobitnuki<br>
                        <input class="input"type="text" name="id_cpivrobitnuki" value="<?php echo $id_cpivrobitnuki;?>"><br></p>
                        <label for="">id_mebli<br>
                            <input class="input"type="text" name="id_mebli" value="<?php echo $id_mebli;?>"><br></p>
                            <label for="">id_klient<br>
                                <input class="input"type="text" name="id_klient"  value="<?php echo $id_klient;?>"><br></p>
                                <label for="">Date_prodagy<br>
                                    <input class="input"type="date" name="Date_prodagy"  value="<?php echo $Date_prodagy;?>"><br></p>
                                    <label for="">Cposib_oplatu<br>
                                        <input class="input"type="text" name="Cposib_oplatu"  value="<?php echo $Cposib_oplatu;?>"><br></p>
                                        <label for="">Name<br>
                                            <input class="input"type="text" name="Name"  value="<?php echo $Name;?>"><br><br></p>
                                            
                                            <input class="butmenu"type="submit" name="insert" value="Insert">
                                            <input class="butmenu"type="submit" name="update" value="Update">
                                            <input class="butmenu"type="submit" name="delete" value="Delete">
                                            <input class="butmenu"type="submit" name="search" value="Search">

                                        </form>
                                        
                                    </body>    
                                </div>
<?php
session_start();
require 'includes/dbcon.php';
?>

<!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


    </head>
    <body>

        <div class="table5">
           <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>id_prodagy</th>
                    <th>id_cpivrobitnuki</th>
                    <th>id_mebli</th>
                    <th>id_klient</th>
                    <th>Date_prodagy</th>
                    <th>Cposib_oplatu</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM Sale_mebli";
                $query_run = mysqli_query($con, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $Sale_mebli)
                    {
                        ?>
                        <tr>
                            <td><?= $Sale_mebli['id_prodagy']; ?></td>
                            <td><?= $Sale_mebli['id_cpivrobitnuki']; ?></td>
                            <td><?= $Sale_mebli['id_mebli']; ?></td>
                            <td><?= $Sale_mebli['id_klient']; ?></td>
                            <td><?= $Sale_mebli['Date_prodagy']; ?></td>
                            <td><?= $Sale_mebli['Cposib_oplatu']; ?></td>
                            <td><?= $Sale_mebli['Name']; ?></td>

                        </tr>
                        <?php
                    }
                }
                else
                {
                    echo "<h5> No Record Found </h5>";
                }
                ?>

            </tbody>
        </table>

<?php include("includes/footer.php"); ?>