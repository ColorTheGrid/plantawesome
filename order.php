<?php
session_start();
include 'config.php';
if ($_SESSION['UserId']) { ?>
    <!DOCTYPE html>
    <html>
    <?php include 'head.php'?>
    <body>
    <?php include 'header.php' ?>
    <div class="center wrapper">
        <div class="page-title">
            <h1>
                Order confirmation
            </h1>
        </div>
        <form action="" method="post" id="nameform">
            <div class="order-container">
                <?php
                global $pdo;
                $stmt = $pdo->prepare("SELECT OrderId  FROM orders WHERE UserId = ? ORDER BY OrderId DESC;");
                $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
                $data = $stmt->fetchAll(); ?>
                <?php foreach ($data as $order) { ?>
                    <?php
                    $stmt = $pdo->prepare("SELECT ItemId FROM orders_items WHERE OrderId = ?;");
                    $stmt->execute([htmlspecialchars($order['OrderId'])]);
                    $data = $stmt->fetchAll(); 

                    $stmt = $pdo->prepare("SELECT ItemDescription, ItemPrice, ItemImg FROM items WHERE ItemId  =? ");
                    $stmt->execute([htmlspecialchars($data[0]['ItemId'])]);
                    $data = $stmt->fetchAll(); ?>

                    <?php foreach ($data as $row) { ?>
                
                        <div class="order-item">
                        <div class="block-content"> 
                            <div class="order-item-list">
                                <div class="order-item-chekcout">
                                    <div class="cart-image-wrapper">
                                        <p> <img  class="item-image" src="./<?php echo $row['ItemImg']; ?>" alt="<?php echo $row['ItemImg']; ?>"
                                            width="75"
                                            height="75"> <br>
                                        </p>
                                    </div>
                                    <div class="div-block">
                                        <div class="text-block"> 
                                            <p>€<?php echo $row['ItemPrice']; ?> <br></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php } ?>
        </form>
        <div class="push"></div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    </html>
<?php } else {
    header("Location: log-in.php");
}







