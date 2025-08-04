<?php
session_start();
include 'config.php';
global $pdo;
$stmt = $pdo->prepare("SELECT * FROM item");
$stmt->execute();
$data = $stmt->fetchAll();

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
}
?>
<!DOCTYPE html>
<html>

<?php include 'head.php'?>
<body>
<div class="content">
    <div class="content-inside">
        <?php include 'header.php' ?>
        <div class="parallax">
        </div>
        <div class="support-container">
            <div class="support-header">
                <p>
                    Looking for new plants?
                </p>
                <h1>
                    You're at the right place.
                </h1>
            </div>
            <div class="support-header">
                <p>
                    CSuspendisse euismod risus eu ante ultricies sollicitudin. Proin quis justo erat. Nam vel finibus purus. Nam ultricies posuere ultricies.
                </p>
            </div>
        </div>
        <div class="support-icons">
            <div class="support-column">
                <div class="support-row">
                    <h1 class="support">
                        01
                    </h1>
                    <h1 class="support-text">
                        Explicable service
                    </h1>
                    <div class="support-img-container">
                        <img class="support-img" src="img\img-plants (1).jpg" alt="Girl in a jacket" width="150px"
                             height="150px">
                    </div>

                </div>
                <p class="support-paragraph">
                hasellus luctus libero eget nunc feugiat, ac dapibus nisl auctor. Praesent felis diam, bibendum vitae volutpat nec, facilisis ac elit. Nunc nec nulla ultricies, mollis velit vitae, luctus tortor. 
                </p>
            </div>
            <div class="support-column">
                <div class="support-row">
                    <h1 class="support">
                        02
                    </h1>
                    <h1 class="support-text">
                        Free shipping
                    </h1>
                    <div class="support-img-container">
                        <img class="support-img" src="img\img-plants (2).jpg" alt="Girl in a jacket" width="150px"
                             height="150px">
                    </div>
                </div>
                <p class="support-paragraph">
                Nunc mi neque, condimentum non porta a, ullamcorper eget lectus. Mauris placerat purus ac placerat ultrices. Aliquam at condimentum tortor, consequat malesuada lectus. 
                </p>
            </div class="support-header">
            <div class="support-column">
                <div class="support-row">
                    <h1 class="support">
                        03
                    </h1>
                    <h1 class="support-text">
                        Great assortment
                    </h1>
                    <div class="support-img-container">
                        <img class="support-img" src="img\img-plants (3).jpg" alt="Girl in a jacket" width="150px"
                             height="150px">
                    </div>
                </div>
                <p class="support-paragraph">
                Curabitur ac posuere tortor, in semper massa. Aenean non purus massa. 
                </p>
            </div>
        </div>
        <div class="parallax-2">
        </div>
        <div class="product">
            <div class="shop-top-wrapper">
                <p>
                    shop products
                </p>
                <h2>
                    Open 24/7/365.
                </h2>
            </div>
            <div class="product-list" id="product-list">
                <form action="" method="post" id="nameform">
                    <div class="grid-container">
                        <?php foreach ($data as $row) {
                            if($row['stock'] === 1) { ?>
                            <div class="grid-child">
                                <div class="container">
                                    <a href="product.php?id=<?php echo urlencode($row['Id']); ?>"><img class="animation-image" src="./<?php echo $row['itemImg']; ?>"
                                            alt="<?php $row['itemImg']; ?>" width="200"
                                            height="250"></a>
                                            <div class="caption">
                                                <h1>Quality products</h1>
                                            </div>
                                </div>

                                <p> <?php echo $row['itemDescription']; ?> <br></p>
                                <p> <?php echo $row['itemName']; ?> <br></p>
                                <p>€ <?php echo $row['itemPrice']; ?> <br></p>
                                <p>
                                    <button type="submit" class="button" name="button"
                                            value="<?php echo $row['Id']; ?>"> Add to
                                        cart
                                    </button>
                                    <br></p>
                            </div>
                        <?php }
                    } ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="local-shop-container" id="statement">
            <div class="local-shop-wrapper">
                <div class="local-shop-left">
                    <img id="shop-img" src="img\statement.jpg"
                         alt="alt" width="350px"
                         height="500px">
                </div>
                <div class="local-shop-right">
                    <div class="local-shop-right-wrapper">
                        <h2>
                            Our substrates are the best of the line. This way the plant lives happier and longer. 
                        </h2>
                        <p>
                        Phasellus suscipit magna quis mattis vehicula.
                        </p>
                        <p>
                        Quisque tempus mauris et eros viverra fringilla. 
                        </p>
                        <p>
                        Sed vestibulum orci tortor, a dapibus tortor malesuada vitae. Sed suscipit eros at tortor venenatis egestas. Cras mollis sapien ac suscipit ornare.
                        </p>
                        <p>
                            -------
                        </p>
                        <p>
                            Jane & John Doe
                            PlantAwsome
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

