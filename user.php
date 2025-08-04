<?php
session_start();
include 'config.php';

if (isset($_SESSION['UserId'])) {
    global $pdo;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = intval($_POST['button']);
    
        if ($name === 1) {
            if (!empty($_POST['UserEmail']) && !empty($_POST['UserName']) && !empty($_POST['UserPassword'])) {
                $UserEmail = $_POST['UserEmail'];
                $UserName = $_POST['UserName'];
                $UserPassword = $_POST['UserPassword'];
                $hashed_password = password_hash($UserPassword, PASSWORD_DEFAULT);
                $UserId = $_SESSION['UserId'];
    
                $stmt = $pdo->prepare("UPDATE user SET userEmail=?, userName=?, userPassword=? WHERE Id=?");
                $stmt->execute([htmlspecialchars($UserEmail), htmlspecialchars($UserName), htmlspecialchars($hashed_password), htmlspecialchars($UserId)]); 
                if($stmt)
                {
                    $_SESSION['UserName'] = $UserName;
                    header("Location: success.php");
                }
         
            } else {
                header("Location: error.php");
            }
        }

        if ($name === 0) {
            if (!empty($_POST['StreetName']) && !empty($_POST['StreetNumber']) && !empty($_POST['PostalCode'])&& !empty($_POST['Country'])) { 
                $StreetName = $_POST['StreetName'];
                $StreetNumber = $_POST['StreetNumber'];
                $StreetPostalCode = $_POST['PostalCode'];
                $Country = $_POST['Country'];
                $UserId = $_SESSION['UserId'];
    
                $stmt = $pdo->prepare("UPDATE useraddress SET streetName=?, streetNumber=?, streetPostalCode=?, country=?  WHERE userId=?");
                $stmt->execute([htmlspecialchars($StreetName), htmlspecialchars($StreetNumber), htmlspecialchars($StreetPostalCode), htmlspecialchars($Country), htmlspecialchars($UserId)]); 
                if($stmt)
                {
                    header("Location: success.php");
                }
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
    <div class="page-title">
        <h2>
            Account page
        </h2>
    </div>
    <div class="center wrapper">
        <?php 
        $stmt = $pdo->prepare("SELECT * FROM user WHERE Id = ?");
        $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
        $data = $stmt->fetchAll();
        ?>
        <form action="" method="post" id="nameform" enctype="multipart/form-data">
                <div class="grid-container">
                    <?php foreach ($data as $row) { ?>
                        <div class="small-border">
                            <h2 class="item-header">
                                Edit account data
                            </h2>
                            <p>
                                <label for="fname">Email: </label><br>
                                <input type="text" id="fname" name="UserEmail" value="<?php echo $row['userEmail']; ?>"><br>
                            </p>
                            <p>
                                <label for="lname">User name: </label><br>
                                <input type="text" id="lname" name="UserName" value="<?php echo $row['userName']; ?>"><br>
                            </p>
                            <p>
                                <label for="lname">Password: </label><br>
                                <input type="password" id="lname" name="UserPassword" value=""><br>
                            </p>
        
                        <button type="submit" class="button" name="button" value="1">
                            Edit account
                        </button>
                    </div>
                    <?php } ?>
                </div>
      
                <?php 
                $stmt = $pdo->prepare("SELECT * FROM useraddress WHERE userId = ?");
                $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
                $data = $stmt->fetchAll();
                ?>
                <div class="grid-container">
                    <?php foreach ($data as $row) { ?>
                        <div class="small-border">
                            <h2 class="item-header">
                                Edit address
                            </h2>
                            <p>
                                <label for="fname">Street name: </label><br>
                                <input type="text" id="fname" name="StreetName" value="<?php echo $row['streetName']; ?>"><br>
                            </p>
                            <p>
                                <label for="lname">Street number: </label><br>
                                <input type="text" id="lname" name="StreetNumber" value="<?php echo $row['streetNumber']; ?>"><br>
                            </p>
                            <p>
                                <label for="fname">Postal code: </label><br>
                                <input type="text" id="fname" name="PostalCode" value="<?php echo $row['streetPostalCode']; ?>"><br>
                            </p>
                            <p>
                                <label for="lname">Country: </label><br>
                                <input type="text" id="lname" name="Country" value="<?php echo $row['country']; ?>"><br>
                            </p>
                            <button type="submit" class="button" name="button" value="0">
                                Edit address
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </form>
        <div class="push"></div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    </html>
<?php } else {
    header("Location: index.php");
} ?>

