<?php
session_start();
include 'config.php';

if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] === 1) {
    global $pdo;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = intval(htmlspecialchars($_POST['button']));
        if ($name === -2) {
            header("Location: admin-1.php");
        }

        if ($name === -1) {
            $hasValue = false;
            if (!empty($_POST['UserEmail']) && !empty($_POST['UserName']) && !empty($_POST['UserPassword'])) {
                $UserEmail = $_POST['UserEmail'];
                $UserName = $_POST['UserName'];
                $UserPassword = $_POST['UserPassword'];
    
                $stmt = $pdo->prepare("SELECT userEmail FROM user WHERE userEmail =?");
                $stmt->execute([htmlspecialchars($UserEmail)]); 
                $data = $stmt->fetch();
                
                if(!$data) {
                    $hashed_password = password_hash($UserPassword, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO user (isAdmin, userEmail, userName, userPassword) VALUES (?,?,?,?)");
                    $stmt->execute([1, htmlspecialchars($UserEmail), htmlspecialchars($UserName), htmlspecialchars($hashed_password)]);
                    header("Location: success.php");
                    }
                } else {
                    header("Location: error.php");
                }
            }

        if ($name > 0) { 
                $stmt = $pdo->prepare("SELECT stock FROM item Where Id = ?");
                $stmt->execute([htmlspecialchars($name)]);
                $data = $stmt->fetch();
                if($data['stock'] === 1 ) {
                    $stmt = $pdo->prepare("UPDATE item SET Stock = 0 WHERE Id = ?");
                    $stmt->execute([htmlspecialchars($name)]);
    
                } else {
                    $stmt = $pdo->prepare("UPDATE item SET Stock = 1 WHERE Id = ?");
                    $stmt->execute([htmlspecialchars($name)]);
                }
                if($stmt)  {
                    header("Location: success.php");
                } else {
                    header("Location: error.php");  
                }
       
            }
        
        
        if ($name === 0) {
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
            if (isset($_POST["fileToUpload"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $imgOutput = "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $imgOutput = "File is not an image.";
                    $uploadOk = 0;
                }
            }

// Check if file already exists
            if (file_exists($target_file)) {
                $imgOutput = "Sorry, file already exists.";
                $uploadOk = 0;
            }

// Check file size
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                $imgOutput = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

// Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $imgOutput = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                header("Location: error.php");
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    if (!empty($_POST['itemDescription']) && !empty($_POST['itemName']) && !empty($_POST['itemPrice'])) {
                        $ItemDescription = $_POST['itemDescription'];
                        $ItemName = $_POST['itemName'];
                        $ItemPrice = $_POST['itemPrice'];
                        $stmt = $pdo->prepare("INSERT INTO item (itemName, itemDescription, itemPrice, itemImg) VALUES (?,?,?,?)");
                        $stmt->execute([htmlspecialchars($ItemName), htmlspecialchars($ItemDescription), htmlspecialchars($ItemPrice), htmlspecialchars($target_file)]);
                    }
                    header("Location: success.php");
                } else {
                    header("Location: error.php");
                }
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
            Admin page
        </h2>
    </div>
    <div class="center wrapper">
        <form action="" method="post" id="nameform" enctype="multipart/form-data">
            <div class="small-border">
                <h2 class="item-header">
                    Add item
                </h2>
                <p>
                    <label for="fname">Item name: </label><br>
                    <input type="text" id="fname" name="itemName"><br>
                </p>
                <p>
                    <label for="lname">Item description: </label><br>
                    <input type="text" id="lname" name="itemDescription"><br>
                </p>
                <p>
                    <label for="lname">Item price: </label><br>
                    <input type="text" id="lname" name="itemPrice"><br>
                </p>
                <p>
                    <input type="file" name="fileToUpload">
                </p>
            </div>
            <button type="submit" class="button" name="button" value="0">
                Add item
            </button>
            <div class="small-border">
                <h2 class="item-header">
                    Create admin account
                </h2>
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
            <button type="submit" class="button" name="button" value="-1">
                Add account
            </button>
            <?php $stmt = $pdo->prepare("SELECT * FROM item");
            $stmt->execute();
            $data = $stmt->fetchAll(); ?>
            <div class="grid-container">
                <?php foreach ($data as $row) { ?>
                    <div class="grid-child">
                        <p><img class="item-image" src="./<?php echo $row['itemImg']; ?>" alt="<?php echo $row['itemImg']; ?>" width="150"
                                height="150"> <br></p>
                        <p> <?php echo $row['itemName']; ?> <br></p>
                        <p>€ <?php echo $row['itemPrice']; ?> <br></p>
                        <p> <?php echo $row['itemDescription']; ?> <br></p>
                        <p>
                        <?php if($row['stock'] === 1) { ?>
                            <button type="submit" class="button" name="button" value="<?php echo $row['Id']; ?>"> Set out Stock
                            </button>
                            <br></p>
                        <?php } else { ?>
                            <button type="submit" class="button" name="button" value="<?php echo $row['Id']; ?>"> Set back in stock
                            </button>
                            <br></p>
                        <?php }?>
                </div>
                <?php } ?>
            </div>
            <p>
                <button type="submit" class="button" name="button" value="-2"> Next page
                </button>
                <br>
            </p>
        </form>
        <div class="push"></div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    </html>
<?php } else {
    header("Location: index.php");
} ?>

