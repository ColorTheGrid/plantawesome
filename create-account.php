<?php
session_start();
include 'config.php';
$create = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isEmpty = false;
    foreach ($_POST as $key => $value) {
        if ($value === "") {
            $isEmpty = true;
        }
    }
    if ($isEmpty === false) {
        $UserEmail = $_POST['UserEmail'];
        $UserName = $_POST['UserName'];
        $UserPassword = $_POST['UserPassword'];
        $hashed_password = password_hash($UserPassword, PASSWORD_DEFAULT);

        global $pdo;
        $stmt = $pdo->prepare("SELECT UserEmail  FROM user WHERE UserEmail  =?");
        $stmt->execute([htmlspecialchars($UserEmail)]); 
        $data = $stmt->fetch();
        
        if(!$data) {
            $stmt = $pdo->prepare("INSERT INTO user (UserAdmin, UserEmail, UserName, UserPassword) VALUES (?,?,?,?)");
            $stmt->execute([0, htmlspecialchars($UserEmail), htmlspecialchars($UserName), htmlspecialchars($hashed_password)]);   
            $stmt = $pdo->prepare("SELECT UserId ,UserAdmin FROM user WHERE UserName = ?");
            $stmt->execute([htmlspecialchars($UserName)]);
            $data = $stmt->fetchAll();
            $_SESSION['UserId'] = $data[0]['UserId'];
            $_SESSION['UserName'] = $UserName;
            $_SESSION['UserAdmin'] = $data[0]['UserAdmin'];
            $create = true;
            header("Location: success.php");
        } else {
            header("Location: error.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<?php include 'head.php'?>
<body>
<?php include 'header.php' ?>
<div class="center wrapper">
    <div class="page-title">
        <h2>
            Create an account
        </h2>
    </div>
    <form action="" method="post" id="nameform">
        <div class="checkout-container">
            <p>
                <label for="fname">Email: </label><br>
                <input type="text" id="fname" name="UserEmail"><br>
            </p>
            <p>
                <label for="lname">User name: </label><br>
                <input type="text" id="lname" name="UserName"><br>
            </p>
            <p>
                <label for="lname">Password: </label><br>
                <input type="password" id="lname" name="UserPassword"><br>
            </p>
        </div>
        <button type="submit" class="button" name="button" value="0">
            Create Account
        </button>
        <?php
        if ($create) {
            echo 'Account created';
        } ?>
    </form>
    <div class="push"></div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

