<?php
session_start();
include 'config.php';
if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] === 1) {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['button'];
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM orders WHERE orderId = ?");
        $stmt->execute([htmlspecialchars($name)]);
        header("Location: success.php");
    } ?>

    <!DOCTYPE html>
    <html>
    <?php include 'head.php'?>
    <body>
    <?php include 'header.php' ?>
    <div class="center wrapper">
        <form action="" method="post" id="nameform">
            <?php
            $stmt = $pdo->prepare("SELECT orderId, orderUserId, orderItemId FROM orders");
            $stmt->execute();
            $data = $stmt->fetchAll(); ?>
            <?php foreach ($data as $order) { ?>
                <?php
                $stmt = $pdo->prepare("SELECT itemName, itemDescription, itemPrice, itemImg FROM item WHERE Id =?");
                $stmt->execute([htmlspecialchars($order['orderItemId'])]);
                $data = $stmt->fetchAll(); ?>
                <p>
                    <button type="submit" class="button" name="button" value="<?php echo $order['orderId']; ?>">
                        Delete order
                    </button>
                    <br>
                </p>
                <div class="small-border">

                <h2 class="item-header">
                    Delete order
                </h2>

                <?php foreach ($data as $row) { ?>
                    <p>
                        <img class="item-image" src="./<?php echo $row['itemImg']; ?>"
                             alt="<?php echo $row['itemImg']; ?>"
                             width="150"
                             height="150"> <br></p>
                    <p> <?php echo $row['itemName']; ?> <br></p>
                    <p>€ <?php echo $row['itemPrice']; ?> <br></p>
                    <p> <?php echo $row['itemDescription']; ?> <br></p>
                    </div>


                <?php }
                $stmt = $pdo->prepare("SELECT streetName, streetNumber, streetPostalCode, country FROM useraddress WHERE userId =?");
                $stmt->execute([htmlspecialchars($order['orderUserId'])]);
                $data = $stmt->fetchAll(); ?>
                <?php foreach ($data

                               as $row) { ?>
                    <div class="small-border">
                        <h2 class="item-header">
                            Order information
                        </h2>
                        <p>Shipped to</p>
                        <p> <?php echo $row['streetName']; ?> <br></p>
                        <p> <?php echo $row['streetNumber']; ?> <br></p>
                        <p> <?php echo $row['streetPostalCode']; ?> <br></p>
                        <p> <?php echo $row['country']; ?> <br></p>
                    </div>
                <?php } ?>
            <?php } ?>
        </form>
    </div>
    <div class="push"></div>

    <?php include 'footer.php'; ?>
    </body>
    </html>
<?php } else {
    header("Location: index.php");
}







