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
        $StreetName = $_POST['StreetName'];
        $StreetNumber = $_POST['StreetNumber'];
        $PostalCode = $_POST['PostalCode'];
        $Country = $_POST['Country'];


        global $pdo;
        $stmt = $pdo->prepare("SELECT UserEmail FROM user WHERE UserEmail  =?");
        $stmt->execute([htmlspecialchars($UserEmail)]); 
        $data = $stmt->fetch();      

        $stmt = $pdo->prepare("INSERT INTO user (UserAdmin, UserEmail, UserName, UserPassword, StreetNumber, PostalCode) VALUES (?,?,?,?,?,?)");
        $stmt->execute([0, htmlspecialchars($UserEmail), htmlspecialchars($UserName), htmlspecialchars($hashed_password), htmlspecialchars($StreetNumber), htmlspecialchars($PostalCode)]);   
        $stmt = $pdo->prepare("SELECT UserId ,UserAdmin FROM user WHERE UserEmail = ?");
        $stmt->execute([htmlspecialchars($UserEmail)]);
        $data = $stmt->fetchAll();

        $_SESSION['UserId'] = $data[0]['UserId'];
        $_SESSION['UserName'] = $UserName;
        $_SESSION['UserAdmin'] = $data[0]['UserAdmin'];

        $stmt = $pdo->prepare("INSERT INTO addresses (PostalCode, StreetNumber, StreetName, Country) VALUES (?, ?, ?, ?)");
        $stmt->execute([htmlspecialchars($PostalCode), htmlspecialchars($StreetNumber), htmlspecialchars($StreetName), htmlspecialchars($Country)]);

        if(!empty($stmt)) {
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

            <p> Shipping address</p>
            <p>
                <label class="label" for="lname">Postal Code: </label><br>
                <input type="text" class="address-input" id="lname" name="PostalCode"><br>
            </p>

            <p>
                <label class="label" for="lname">Street number: </label><br>
                <input type="text" class="address-input" id="lname" name="StreetNumber"><br>
            </p>

            <p>
                <label class="label" for="lname">Street name: </label><br>
                <input type="text" class="address-input" id="lname" name="StreetName"><br>
            </p>
  
            <p>
                <label class="label" for="lname">Country: </label><br>
                <input type="text" class="address-input" id="lname" name="Country"><br>
            </p>
            <button type="submit" class="button" name="button" value="0">
                Create Account
            </button>
        </div>
    </form>
    <div class="push"></div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

