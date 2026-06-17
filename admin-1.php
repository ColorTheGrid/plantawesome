<?php
session_start();
include 'config.php';
if (isset($_SESSION['UserAdmin']) && $_SESSION['UserAdmin'] === 1) {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ButtonValue = $_POST['button'];
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM orders WHERE OrderId = ?");
        $stmt->execute([htmlspecialchars($ButtonValue)]);
        $stmt = $pdo->prepare("DELETE FROM orders_items WHERE OrderId = ?");
        $stmt->execute([htmlspecialchars($ButtonValue)]);
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
            $stmt = $pdo->prepare("SELECT OrderId, ItemId FROM orders_items");
            $stmt->execute();
            $data = $stmt->fetchAll(); ?>
            <?php foreach ($data as $order) { ?>
                <?php
                $stmt = $pdo->prepare("SELECT ItemDescription, ItemPrice, ItemImg FROM items WHERE ItemId =?");
                $stmt->execute([htmlspecialchars($order['ItemId'])]);
                $data = $stmt->fetchAll(); ?>
                <p>
                    <button type="submit" class="button" name="button" value="<?php echo $order['OrderId']; ?>">
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
                        <img class="item-image" src="./<?php echo $row['ItemImg']; ?>"
                             alt="<?php echo $row['ItemImg']; ?>"
                             width="150"
                             height="150"> <br></p>
                    <p>€ <?php echo $row['ItemPrice']; ?> <br></p>
                    <p> <?php echo $row['ItemDescription']; ?> <br></p>
                    </div>


                <?php }                  
                $stmt = $pdo->prepare("SELECT UserId FROM orders WHERE OrderId =?");
                $stmt->execute([htmlspecialchars($order['OrderId'])]);
                $data = $stmt->fetchAll();

                $stmt = $pdo->prepare("SELECT StreetNumber,PostalCode FROM user WHERE UserId =?");
                $stmt->execute([htmlspecialchars($data[0]['UserId'])]);
                $data = $stmt->fetchAll(); 
            
                $stmt = $pdo->prepare("SELECT StreetNumber, PostalCode, Country, StreetName FROM addresses WHERE StreetNumber = ? AND PostalCode = ?");
                $stmt->execute([$data[0]['StreetNumber'],$data[0]['PostalCode']]);
                $data = $stmt->fetchAll(); 
                ?>
                
                <?php foreach ($data as $row) { ?>
                    <div class="small-border">
                        <h2 class="item-header">
                            Order information
                        </h2>
                        <p>Shipped to</p>
                        <p> <?php echo $row['StreetName']; ?> <br></p>
                        <p> <?php echo $row['StreetNumber']; ?> <br></p>
                        <p> <?php echo $row['PostalCode']; ?> <br></p>
                        <p> <?php echo $row['Country']; ?> <br></p>
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







