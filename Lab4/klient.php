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

$id_klient = '';
$id_user = '';
$Pasport = '';
$PIB = '';
$Adresa = '';
$Telefon = '';
function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['id_klient'];
    $posts[1] = $_POST['id_user'];
    $posts[2] = $_POST['PIB'];
    $posts[3] = $_POST['Pasport'];
    $posts[4] = $_POST['Adresa'];
    $posts[5] = $_POST['Telefon'];


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
        
        $searchStmt = $con->prepare('SELECT * FROM Klient WHERE id_klient = :id_klient');
        $searchStmt->execute(array(
            ':id_klient'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $id_klient  = $user[0];
            $id_user = $user[1];
            $PIB    = $user[2];
            $Pasport = $user[3];
            $Adresa = $user[4];
            $Telefon= $user[5];
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
        
        $insertStmt = $con->prepare('INSERT INTO Klient(id_user,PIB,Pasport,Adresa,Telefon) VALUES(:id_user,:PIB,:Pasport,:Adresa,:Telefon)');
        $insertStmt->execute(array(
            ':id_user'  => $data[1],
            ':PIB'      => $data[2],
            ':Pasport'  => $data[3],
            ':Adresa'   => $data[4],
            ':Telefon'  => $data[5],
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
        
        $updateStmt = $con->prepare('UPDATE Klient SET id_user = :id_user, PIB = :PIB, Pasport = :Pasport, Adresa = :Adresa, Telefon = :Telefon WHERE id_klient = :id_klient');
        $updateStmt->execute(array(
            ':id_klient'=> $data[0],
            ':id_user'=> $data[1],
            ':PIB'=> $data[2],
            ':Pasport'=> $data[3],
            ':Adresa'=> $data[4],
            ':Telefon'  => $data[5],
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

        $deleteStmt = $con->prepare('DELETE FROM Klient WHERE id_klient = :id_klient');
        $deleteStmt->execute(array(
            ':id_klient'=> $data[0]
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
        <title>Klient.com</title>  
    </head>
    <body>
        <form action="" id="loginform" method="post"name="loginform">
            <form action="klient.php" method="POST">

                <label for="">id_klient<br>
                    <input class="input"type="text" name="id_klient" value="<?php echo $id_klient;?>"><br></p>
                    <label for="">id_user<br>
                        <input class="input"type="text" name="id_user" value="<?php echo $id_user;?>"><br></p>
                        <label for="">PIB<br>
                            <input class="input"type="text" name="PIB" value="<?php echo $PIB;?>"><br></p>
                            <label for="">Pasport<br>
                                <input class="input"type="text" name="Pasport" value="<?php echo $Pasport;?>"><br></p>
                                <label for="">Adresa<br>
                                    <input class="input"type="text" name="Adresa" value="<?php echo $Adresa;?>"><br></p>
                                    <label for="">Telefon<br>
                                        <input class="input"type="text" name="Telefon" value="<?php echo $Telefon;?>"><br><br></p>

                                        
                                        
                                        <input class="butmenu" name="insert"type= "submit" value="Insert">
                                        <input class="butmenu"type="submit" name="update" value="Update">
                                        <input class="butmenu"type="submit" name="delete" value="Delete">
                                        <input class="butmenu"type="submit" name="search" value="Search">

            </form>
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
                    <th>id_klient</th>
                    <th>id_user</th>
                    <th>PIB</th>
                    <th>Pasport</th>
                    <th>Adresa</th>
                    <th>Telefon</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                $query = "SELECT * FROM Klient";
                $query_run = mysqli_query($con, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $Klient)
                    {
                        ?>
                        <tr>
                            <td><?= $Klient['id_klient']; ?></td>
                            <td><?= $Klient['id_user']; ?></td>
                            <td><?= $Klient['PIB']; ?></td>
                            <td><?= $Klient['Pasport']; ?></td>
                            <td><?= $Klient['Adresa']; ?></td>
                            <td><?= $Klient['Telefon']; ?></td>

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