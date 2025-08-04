
<!DOCTYPE html>
<html>
<?php include 'head.php'?>
<div class="error-background">
    <div class="error-image">
        <img src="img/error.png" alt="Girl in a jacket" width="50px" height="50px">
    </div>
    <div class="header-error"> 
        <h1>
            Sorry your action was not succesful!
        </h1>
    </div>
</div>
<body>
</body>
</html>

<?php 
header("refresh:1; url={$_SERVER['HTTP_REFERER']}");
?>
