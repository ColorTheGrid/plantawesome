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
                $stmt = $pdo->prepare("SELECT orderUserId, orderItemId FROM orders WHERE orderUserId =? ORDER BY orderId DESC;");
                $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
                $data = $stmt->fetchAll(); ?>
                <?php foreach ($data as $order) { ?>
                    <?php
                    $stmt = $pdo->prepare("SELECT itemName, itemPrice, itemImg FROM item WHERE Id =? ");
                    $stmt->execute([htmlspecialchars($order['orderItemId'])]);
                    $data = $stmt->fetchAll(); ?>

                    <?php foreach ($data as $row) { ?>
                
                        <div class="order-item">
                        <div class="block-content"> 
                            <div class="order-item-list">
                                <div class="order-item-chekcout">
                                    <div class="cart-image-wrapper">
                                        <p> <img  class="item-image" src="./<?php echo $row['itemImg']; ?>" alt="<?php echo $row['itemImg']; ?>"
                                            width="75"
                                            height="75"> <br>
                                        </p>
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







