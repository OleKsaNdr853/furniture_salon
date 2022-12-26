<?php include("includes/headerAdmin.php"); ?>
<?php include("menuAdmin.php"); ?>
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

$id_user = '';
$full_name = '';
$email = '';
$username = '';
$password = '';
function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['id_user'];
    $posts[1] = $_POST['full_name'];
    $posts[2] = $_POST['email'];
    $posts[3] = $_POST['username'];
    $posts[4] = $_POST['password'];


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
        
        $searchStmt = $con->prepare('SELECT * FROM User_klient WHERE id_user = :id_user');
        $searchStmt->execute(array(
            ':id_user'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $id_user  = $user[0];
            $full_name = $user[1];
            $email    = $user[2];
            $username = $user[3];
            $password = $user[4];
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]))
    {
        echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO User_klient(full_name,email,username,password) VALUES(:full_name,:email,:username,:password)');
        $insertStmt->execute(array(
            ':full_name'  => $data[1],
            ':email'      => $data[2],
            ':username'  => $data[3],
            ':password'   => $data[4],
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
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]))
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE User_klient SET full_name = :full_name, email = :email, username = :username, password = :password WHERE id_user = :id_user');
        $updateStmt->execute(array(
            ':id_user'=> $data[0],
            ':full_name'=> $data[1],
            ':email'=> $data[2],
            ':username'=> $data[3],
            ':password'=> $data[4],
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

        $deleteStmt = $con->prepare('DELETE FROM User_klient WHERE id_user = :id_user');
        $deleteStmt->execute(array(
            ':id_user'=> $data[0]
        ));
        
        if($deleteStmt)
        {
            echo 'User Deleted';
        }
        
    }
}
?>
<div class="menube">
    <head>
        <title>User_klient.com</title>  
    </head>
    <body>
        <form action="" id="loginform" method="post"name="loginform">
            <form action="klient.php" method="POST">

                <label for="">id_user<br>
                    <input class="input"type="text" name="id_user" value="<?php echo $id_user;?>"><br></p>
                    <label for="">full_name<br>
                        <input class="input"type="text" name="full_name" value="<?php echo $full_name;?>"><br></p>
                        <label for="">email<br>
                            <input class="input"type="text" name="email" value="<?php echo $email;?>"><br></p>
                            <label for="">username<br>
                                <input class="input"type="text" name="username" value="<?php echo $username;?>"><br></p>
                                <label for="">password<br>
                                    <input class="input"type="text" name="password" value="<?php echo $password;?>"><br></p>

                                        
                                        
                                        <input class="butmenuA" name="insert"type= "submit" value="Insert">
                                        <input class="butmenuA"type="submit" name="update" value="Update">
                                        <input class="butmenuA"type="submit" name="delete" value="Delete">
                                        <input class="butmenuA"type="submit" name="search" value="Search">

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

        <div class="table53">
           <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>id_user</th>
                    <th>full_name</th>
                    <th>email</th>
                    <th>username</th>
                    <th>password</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                $query = "SELECT * FROM User_klient";
                $query_run = mysqli_query($con, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $User_klient)
                    {
                        ?>
                        <tr>
                            <td><?= $User_klient['id_user']; ?></td>
                            <td><?= $User_klient['full_name']; ?></td>
                            <td><?= $User_klient['email']; ?></td>
                            <td><?= $User_klient['username']; ?></td>
                            <td><?= $User_klient['password']; ?></td>

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