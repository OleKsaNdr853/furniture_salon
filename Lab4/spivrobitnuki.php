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

$id_cpivrobitnuki = '';
$PIB = '';
$Firma = '';
$Telefon = '';
$Email = '';
$Pocada = '';
$Paroli = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['id_cpivrobitnuki'];
    $posts[1] = $_POST['PIB'];
    $posts[2] = $_POST['Firma'];
    $posts[3] = $_POST['Telefon'];
    $posts[4] = $_POST['Email'];
    $posts[5] = $_POST['Pocada'];
    $posts[6] = $_POST['Paroli'];
    
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
        
        $searchStmt = $con->prepare('SELECT * FROM Spivrobitnuki WHERE id_cpivrobitnuki = :id_cpivrobitnuki');
        $searchStmt->execute(array(
            ':id_cpivrobitnuki'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $id_cpivrobitnuki  = $user[0];
            $PIB = $user[1];
            $Firma    = $user[2];
            $Telefon = $user[3];
            $Email = $user[4];
            $Pocada= $user[5];
            $Paroli= $user[6];
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
        
        $insertStmt = $con->prepare('INSERT INTO Spivrobitnuki(PIB,Firma,Telefon,Email,Pocada,Paroli) VALUES(:PIB,:Firma,:Telefon,:Email,:Pocada,:Paroli)');
        $insertStmt->execute(array(
            ':PIB'  => $data[1],
            ':Firma'      => $data[2],
            ':Telefon'  => $data[3],
            ':Email'   => $data[4],
            ':Pocada'  => $data[5],
            ':Paroli'  => $data[6],
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
        
        $updateStmt = $con->prepare('UPDATE Spivrobitnuki SET PIB = :PIB, Firma = :Firma, Telefon = :Telefon, Email = :Email, Pocada = :Pocada, Paroli = :Pocada WHERE id_cpivrobitnuki = :id_cpivrobitnuki');
        $updateStmt->execute(array(
            ':id_cpivrobitnuki'=> $data[0],
            ':PIB'=> $data[1],
            ':Firma'=> $data[2],
            ':Telefon'=> $data[3],
            ':Email'=> $data[4],
            ':Pocada'  => $data[5],
            ':Paroli'  => $data[6],
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
        
        $deleteStmt = $con->prepare('DELETE FROM Spivrobitnuki WHERE id_cpivrobitnuki = :id_cpivrobitnuki');
        $deleteStmt->execute(array(
            ':id_cpivrobitnuki'=> $data[0]
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
        <title>Spivrobitnuki.com</title>  
    </head>
    <body>
        <form action="" id="loginform" method="post"name="loginform">
            <form action="spivrobitnuki.php" method="POST">

                <label for="">id_cpivrobitnuki<br>
                    <input class="input"type="text" name="id_cpivrobitnuki" value="<?php echo $id_cpivrobitnuki;?>"><br></p>
                    <label for="">PIB<br>
                        <input class="input"type="text" name="PIB" value="<?php echo $PIB;?>"><br></p>
                        <label for="">Firma<br>
                            <input class="input"type="text" name="Firma" value="<?php echo $Firma;?>"><br></p>
                            <label for="">Telefon<br>
                                <input class="input"type="text" name="Telefon"  value="<?php echo $Telefon;?>"><br></p>
                                <label for="">Email<br>
                                    <input class="input"type="text" name="Email"  value="<?php echo $Email;?>"><br></p>
                                    <label for="">Pocada<br>
                                        <input class="input"type="text" name="Pocada"  value="<?php echo $Pocada;?>"><br></p>
                                        <label for="">Paroli<br>
                                            <input class="input"type="text" name="Paroli"  value="<?php echo $Paroli;?>"><br><br></p>

                                            
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
                    <th>id_cpivrobitnuki</th>
                    <th>PIB</th>
                    <th>Firma</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Pocada</th>
                    <th>Paroli</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM Spivrobitnuki";
                $query_run = mysqli_query($con, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $Spivrobitnuki)
                    {
                        ?>
                        <tr>
                            <td><?= $Spivrobitnuki['id_cpivrobitnuki']; ?></td>
                            <td><?= $Spivrobitnuki['PIB']; ?></td>
                            <td><?= $Spivrobitnuki['Firma']; ?></td>
                            <td><?= $Spivrobitnuki['Telefon']; ?></td>
                            <td><?= $Spivrobitnuki['Email']; ?></td>
                            <td><?= $Spivrobitnuki['Pocada']; ?></td>
                            <td><?= $Spivrobitnuki['Paroli']; ?></td>

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