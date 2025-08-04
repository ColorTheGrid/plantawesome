<?php
session_start();
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isEmpty = false;
    foreach ($_POST as $key => $value) {
        if ($value === "") {
            $isEmpty = true;
        }
    }
    if ($isEmpty === false) {
        $UserEmail = $_POST['UserEmail'];
        $UserPassword = $_POST['UserPassword'];
        $hashed_password = password_hash($UserPassword, PASSWORD_DEFAULT);
        if (password_verify(htmlspecialchars($UserPassword), htmlspecialchars($hashed_password))) {
            global $pdo;
            $stmt = $pdo->prepare("SELECT Id,isAdmin,userName FROM user WHERE userEmail = ?");
            $stmt->execute([htmlspecialchars($UserEmail)]);
            $data = $stmt->fetchAll();
            $_SESSION['UserId'] = $data[0]['Id'];
            $_SESSION['UserName'] = $data[0]['userName'];
            $_SESSION['IsAdmin'] = $data[0]['isAdmin'];
            header("Location: success.php");
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
                Account log in
            </h2>
        </div>
        <form action="" method="post" id="nameform">
            <div class="small-border">
                <h2 class="item-header">
                    Log in
                </h2>

                <p>
                    <label for="lname">User email: </label><br>
                    <input type="text" id="lname" name="UserEmail"><br>
                </p>
                <p>
                    <label for="lname">Password: </label><br>
                    <input type="password" id="lname" name="UserPassword"><br>
                </p>
            </div>

            <button type="submit" class="button" name="button" value="0">
                Log In
            </button>
        </form>
        <div class="push"></div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    </html>

<?php
