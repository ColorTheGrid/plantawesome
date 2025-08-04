<?php
session_start();
include 'config.php';
global $pdo;
if (isset($_GET['id'])) {
    // Retrieve the product ID from the URL
    $product_id = intval($_GET['id']); 
    // collect value of input field
    $stmt = $pdo->prepare("SELECT * FROM item WHERE Id=?");
    $stmt->execute([htmlspecialchars($product_id)]); // casting to int if 'Id' is an integer
    $data = $stmt->fetch(PDO::FETCH_ASSOC); 

    if($data) { 
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = array();
            $name = $_POST['button'];
            if (empty($name)) {
                header("Location: error.php");
            } else {
                array_push($_SESSION['cart'], $name);
                header("Location: success.php");
            }
        }?>
            
    <!DOCTYPE html>
    <html>

    <?php include 'head.php'?>
    <body>
    <div class="content">
    <div class="content-inside">
    <?php include 'header.php' ?>
    <div class="product-list" id="product-list">
        <form action="" method="post" id="nameform">
            <div class="grid-container">
                <div class="grid-child">
                   <?php if($data['stock'] === 1) { ?>
                    <p><img class="item-image" src="./<?php echo $data['itemImg']; ?>"
                    alt="<?php $data['itemImg']; ?>" width="200"
                    height="250"> <br></p>
                    <p> <?php echo $data['itemDescription']; ?> <br></p>
                    <p> <?php echo $data['itemName']; ?> <br></p>
                    <p>€ <?php echo $data['itemPrice']; ?> <br></p>
                    <p>
                    <button type="submit" class="button" name="button"
                        value="<?php echo $data['Id']; ?>"> Add to
                        cart
                    </button>
                    <br></p>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    </html>
    
<?php } else {  header("Location: index.php");}
 } else {
    header("Location: index.php");
} ?>
