<?php
session_start();
include 'config.php';

if (isset($_SESSION['UserAdmin']) && $_SESSION['UserAdmin'] === 1) {
    global $pdo;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ButtonValue = intval(htmlspecialchars($_POST['button']));
        if ($ButtonValue === -2) {
            header("Location: admin-1.php");
        }

        if ($ButtonValue === -1) {
            $hasValue = false;
            if (!empty($_POST['UserEmail']) && !empty($_POST['UserName']) && !empty($_POST['UserPassword'])) {
                $UserEmail = $_POST['UserEmail'];
                $UserName = $_POST['UserName'];
                $UserPassword = $_POST['UserPassword'];
    
                $stmt = $pdo->prepare("SELECT UserEmail FROM user WHERE UserEmail =?");
                $stmt->execute([htmlspecialchars($UserEmail)]); 
                $data = $stmt->fetch();
                
                if(!$data) {
                    $hashed_password = password_hash($UserPassword, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO user (UserAdmin, UserEmail, UserName, UserPassword) VALUES (?,?,?,?)");
                    $stmt->execute([1, htmlspecialchars($UserEmail), htmlspecialchars($UserName), htmlspecialchars($hashed_password)]);
                    header("Location: success.php");
                    }
                } else {
                    header("Location: error.php");
                }
            }

        if ($ButtonValue === 1) { 
                $ItemId = $_POST['ItemId'];
                $StockAmount = $_POST['StockAmount'];

                $stmt = $pdo->prepare("UPDATE items SET ItemInStock = ? WHERE ItemId = ?");
                $stmt->execute([htmlspecialchars($StockAmount), htmlspecialchars($ItemId)]);
                if($stmt)  {
                    header("Location: success.php");
                } else {
                    header("Location: error.php");  
                }
       
            }
        
        
        if ($ButtonValue === 0) {
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
                    if (!empty($_POST['itemDescription']) && !empty($_POST['itemPrice'])) {
                        $ItemDescription = $_POST['itemDescription'];
                        $ItemPrice = $_POST['itemPrice'];
                        $stmt = $pdo->prepare("INSERT INTO items (ItemInStock, ItemDescription, ItemPrice, ItemImg) VALUES (?,?,?,?)");
                        $stmt->execute([1, htmlspecialchars($ItemDescription), htmlspecialchars($ItemPrice), htmlspecialchars($target_file)]);
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
            <?php $stmt = $pdo->prepare("SELECT * FROM items");
            $stmt->execute();
            $data = $stmt->fetchAll(); ?>
            <div class="grid-container">
                <?php foreach ($data as $row) { ?>
                    <div class="grid-child">
                        <p><img class="item-image" src="./<?php echo $row['ItemImg']; ?>" alt="<?php echo $row['ItemImg']; ?>" width="150"
                                height="150"> <br></p>
                        <p>€ <?php echo $row['ItemDescription']; ?> <br></p>
                        <p> <?php echo $row['ItemPrice']; ?> <br></p>
                        <p>
                            <label for="lname">Stock amount: </label><br></p>
                        <p>
                            <input type="hidden" id="lname" name="ItemId" value="<?php echo $row['ItemId']; ?>">
                        </p>
                        
                            <input type="number" id="lname" name="StockAmount" value=""><br>
                        <p>
                            <button type="submit" class="button" name="button" value="1"> Set stock
                            </button>
                        </p>
                </div>
                <?php } ?>
            </div>
            <p>
                <button type="submit" class="button" name="button" value="-2"> Next page
                </button>
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

