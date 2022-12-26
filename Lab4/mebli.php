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

$id_mebli = '';
$Name_mebli = '';
$Komponent = '';
$Rozmir = '';
$Kolir = '';
$Tsina = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['id_mebli'];
    $posts[1] = $_POST['Name_mebli'];
    $posts[2] = $_POST['Komponent'];
    $posts[3] = $_POST['Rozmir'];
    $posts[4] = $_POST['Kolir'];
    $posts[5] = $_POST['Tsina'];
    
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
        
        $searchStmt = $con->prepare('SELECT * FROM Mebli WHERE id_mebli = :id_mebli');
        $searchStmt->execute(array(
            ':id_mebli'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $id_mebli  = $user[0];
            $Name_mebli = $user[1];
            $Komponent    = $user[2];
            $Rozmir = $user[3];
            $Kolir = $user[4];
            $Tsina= $user[5];
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]))
    {
        echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO Mebli(Name_mebli,Komponent,Rozmir,Kolir,Tsina) VALUES(:Name_mebli,:Komponent,:Rozmir,:Kolir,:Tsina)');
        $insertStmt->execute(array(
            ':Name_mebli'  => $data[1],
            ':Komponent'      => $data[2],
            ':Rozmir'  => $data[3],
            ':Kolir'   => $data[4],
            ':Tsina'  => $data[5],
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
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) )
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE Mebli SET Name_mebli = :Name_mebli, Komponent = :Komponent, Rozmir = :Rozmir, Kolir = :Kolir, Tsina = :Tsina WHERE id_mebli = :id_mebli');
        $updateStmt->execute(array(
            ':id_mebli'=> $data[0],
            ':Name_mebli'=> $data[1],
            ':Komponent'=> $data[2],
            ':Rozmir'=> $data[3],
            ':Kolir'=> $data[4],
            ':Tsina'  => $data[5],
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
        
        $deleteStmt = $con->prepare('DELETE FROM Mebli WHERE id_mebli = :id_mebli');
        $deleteStmt->execute(array(
            ':id_mebli'=> $data[0]
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
        <title>Mebli.com</title>  
    </head>
    <body>
        <form action="mebli.php" method="POST">

            <label for="">id_mebli<br>
                <input class="input"type="text" name="id_mebli" value="<?php echo $id_mebli;?>"><br></p>
                <label for="">Name_mebli<br>
                    <input class="input"type="text" name="Name_mebli" value="<?php echo $Name_mebli;?>"><br></p>
                    <label for="">Komponent<br>
                        <input class="input"type="text" name="Komponent" value="<?php echo $Komponent;?>"><br></p>
                        <label for="">Rozmir<br>
                            <input class="input"type="text" name="Rozmir"  value="<?php echo $Rozmir;?>"><br></p>
                            <label for="">Kolir<br>
                                <input class="input"type="text" name="Kolir"  value="<?php echo $Kolir;?>"><br></p>
                                <label for="">Tsina<br>
                                    <input class="input"type="text" name="Tsina"  value="<?php echo $Tsina;?>"><br><br></p>

                                    
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
                    <th>id_mebli</th>
                    <th>Name_mebli</th>
                    <th>Komponent</th>
                    <th>Rozmir</th>
                    <th>Kolir</th>
                    <th>Tsina</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM Mebli";
                $query_run = mysqli_query($con, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $Mebli)
                    {
                        ?>
                        <tr>
                            <td><?= $Mebli['id_mebli']; ?></td>
                            <td><?= $Mebli['Name_mebli']; ?></td>
                            <td><?= $Mebli['Komponent']; ?></td>
                            <td><?= $Mebli['Rozmir']; ?></td>
                            <td><?= $Mebli['Kolir']; ?></td>
                            <td><?= $Mebli['Tsina']; ?></td>

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