<?php
session_start();
include 'config.php';
if ($_SESSION['cart']) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // collect value of input field
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = array();
        $name = htmlspecialchars($_POST['button']);
        if (empty($name)) {
            header("Location: address.php");
        } else {
            unset($_SESSION['cart']);
            header("Location: success.php");
        }
    } ?>

    <!DOCTYPE html>
    <html>
    <?php include 'head.php'?>
    <body>
    <?php include 'header.php' ?>
    <div class="center wrapper">
        <div class="page-title">
            <h1>
                Items in your cart
            </h1>
        </div>
<form action="" method="post" id="nameform"> 
<div class="order-container">
    <?php
   global $pdo;
   foreach (($_SESSION['cart']) as $cart) {
       $stmt = $pdo->prepare("SELECT * FROM item WHERE Id=?");
       $stmt->execute([htmlspecialchars($cart)]);
       $data = $stmt->fetchAll(); ?>
       <?php foreach ($data as $row) { ?>
        <div class="order-item">
            <div class="block-content"> 
                <div class="order-item-list">
                    <div class="order-item-chekcout">
                        <div class="cart-image-wrapper">
                        <img class="item-image" src="./<?php echo $row['itemImg']; ?>"
                                alt="<?php echo $row['itemImg']; ?>"
                                width="75"
                                height="75"> 
                        </div>
                        <div class="order-item-desc">
                            <p>
                                <?php echo $row['itemName']; ?> <br>
                            </p>
                        </div>
                        <div class="div-block">
                            <div class="text-block"> 
                                <p>€<?php echo $row['itemPrice']; ?> <br></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
        <div class="cart-nav-wrapper">
            <p class="cart-nav">
                <button type="submit" class="button" name="button" value="1">
                    Empty Cart
                </button>
                <br></p>
            <p class="cart-nav">
                <button type="submit" class="button" name="button" value="">
                    Proceed
                </button>
            <br></p>
            </div>  
        </div>
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
}






