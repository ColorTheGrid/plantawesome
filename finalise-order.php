<?php
session_start();
include 'config.php';
if ($_SESSION['cart'] && $_SESSION['UserId']) {

    global $pdo;
    $stmt = $pdo->prepare("SELECT UserEmail, UserName FROM user WHERE UserId =?");
    $stmt->execute([$_SESSION['UserId']]);
    $data = $stmt->fetchAll();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach (($_SESSION['cart']) as $cart) {
            $stmt = $pdo->prepare("INSERT INTO orders (UserId) VALUES (?)");
            $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
            

            $stmt = $pdo->prepare("SELECT OrderId FROM orders WHERE UserId = ?");
            $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
            $data = $stmt->fetchAll();

            $stmt = $pdo->prepare("INSERT INTO orders_items (OrderId, ItemId ) VALUES (?, ?)");
            $stmt->execute([htmlspecialchars($data[0]['OrderId']),  htmlspecialchars($cart)]);
        unset($_SESSION['cart']);
        header("Location: order.php");
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
                Finialize your order
            </h1>
        </div>
        <form action="" method="post" id="nameform">
            <p> <?php echo $data[0]['UserEmail']; ?> <br></p>
            <p> <?php echo $data[0]['UserName']; ?> <br></p>
            <?php $itemTotal = 0; ?>
            <div class="order-container">
                <?php foreach (($_SESSION['cart']) as $cart) { ?>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM items WHERE ItemId=?");
                $stmt->execute([htmlspecialchars($cart)]);
                $data = $stmt->fetchAll();
                    

                foreach ($data as $row) { ?>
                     
                    <div class="order-item">
                        <div class="order-item-chekcout">
                            <div>
                                <img class="item-image" src="./<?php echo $row['ItemImg']; ?>" alt="<?php echo $row['ItemImg']; ?>"
                                width="75"
                                height="75">
                            </div>
                           
                            <div>
                                <?php echo $row['ItemDescription']; ?> <br>
                            </div>
                                        
                            <div>
                                €<?php echo $row['ItemPrice']; 
                                $itemTotal += $row['ItemPrice'];
                                ?> 
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
                <p>
                    Order total: € 
                    <?php echo $itemTotal ?>
                </p>
                <p>
                    <button type="submit" class="button" name="button" value="">
                        Finalize
                    </button>
                    <br>
                </p>
            </div>
            
        </form>
        <div class="push"></div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php");
}






