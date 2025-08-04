<?php
session_start();
include 'config.php';
if ($_SESSION['cart'] && $_SESSION['UserId']) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT userId FROM useraddress WHERE userId = ?");
    $stmt->execute([htmlspecialchars($_SESSION['UserId'])]);
    $data = $stmt->fetchAll();

    if (!isset($data[0]['userId'])) {
        $isEmpty = false;
        foreach ($_POST as $key => $value) {
            if ($value === "") {
                $isEmpty = true;
            }
        }
        if ($isEmpty === false) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $StreetName = $_POST['StreetName'];
                $StreetNumber = $_POST['StreetNumber'];
                $PostalCode = $_POST['PostalCode'];
                $country = $_POST['country'];

                $stmt = $pdo->prepare("INSERT INTO useraddress (userId, streetName, streetNumber, streetPostalCode, country) VALUES (?,?,?,?,?)");
                $stmt->execute([htmlspecialchars($_SESSION['UserId']), htmlspecialchars($StreetName), htmlspecialchars($StreetNumber), htmlspecialchars($PostalCode), htmlspecialchars($country)]);
                header("Location: finalise-order.php");
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
                    Address information
                </h2>
            </div>
            <form action="" method="post" id="nameform">
                <div class="container-address">
                    <div class="checkout-container">
                        <div class="checkout-wrapper">
                            <div class="address-paragraph">
                                <p> Shipping address</p>
                            </div>
                            <div class="address">
                                <p>
                                    <label class="label" for="lname">Street name: </label><br>
                                    <input type="text" class="address-input" id="lname" name="StreetName"><br>
                                </p>
                            </div>
                            <div class="address">
                                <p>
                                    <label class="label" for="lname">Street number: </label><br>
                                    <input type="text" class="address-input" id="lname" name="StreetNumber"><br>
                                </p>
                            </div>
                            <div class="address">
                                <p>
                                    <label class="label" for="lname">Postal code: </label><br>
                                    <input type="text" class="address-input" id="lname" name="PostalCode"><br>
                                </p>
                            </div>
                            <div class="address">
                                <p>
                                    <label class="label" for="lname">Country: </label><br>
                                    <input type="text" class="address-input" id="lname" name="country"><br>
                                </p>
                            </div>
                        </div>

                        <div class="address order-sum">
                            <div class="address-paragraph">
                                <p>
                                    Item in order
                                </p>
                            </div>
                            <?php
                            $itemTotal = 0;
                            global $pdo;
                            foreach (($_SESSION['cart']) as $cart) {
                                $stmt = $pdo->prepare("SELECT * FROM item WHERE Id=?");
                                $stmt->execute([htmlspecialchars($cart)]);
                                $data = $stmt->fetchAll(); ?>
                                <?php foreach ($data as $row) { ?>
                                    <div class="item-container">
                                        <p class="item-image-address">
                                            <img class="item-image" src="./<?php echo $row['itemImg']; ?>"
                                                 alt="<?php echo $row['itemImg']; ?>"
                                                 width=100"
                                                 height="100">
                                        </p>
                                        <p class="item-name">
                                            <?php echo $row['itemName']; ?>
                                            € <?php echo $row['itemPrice']; ?>
                                        </p>
                                    </div>
                                    <?php $itemTotal += $row['itemPrice']; ?>
                                <?php } ?>
                            <?php } ?>
                            <p>
                                Total : € <?php echo $itemTotal ?>
                            </p>
                            <button type="submit" class="button" name="button" value="0">
                                Proceed
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="push"></div>
        </div>
        <?php include 'footer.php'; ?>
        </body>
        </html>
        <?php
    } else {
        header("Location: finalise-order.php");
    }
} else {
    header("Location: log-in.php");
}

