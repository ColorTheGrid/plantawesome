<?php
session_start();
include 'config.php' ?>
<!DOCTYPE html>
<html>

<?php include 'head.php'?>
<body>
<div class="content">
    <div class="content-inside">
        <?php include 'header.php' ?>
        <div class="parallax"></div>
            <div id="about-us">
                <h1>FAQ Page</h1> 
                <p> 
                Q: What is your return policy? <br>
                A: We offer a 30-day return policy on all items. If you're not satisfied with your purchase, you can return it within 30 days of receiving the product for a full refund or exchange, provided the item is in its original condition.<br>
                </p>
                Q: How long does shipping take? <br>
                A: Shipping typically takes 5–7 business days within the continental U.S. International shipping may take 10–15 business days, depending on the destination and customs.<br>
                <p>
                Q: Do you ship internationally?<br>
                A: Yes, we ship to most countries worldwide. International shipping rates and delivery times vary depending on the destination.<br>
                </p>
                <p> 
                Q: How can I track my order?<br>
                A: Once your order is shipped, you will receive an email with a tracking number. You can use this number to track your order on our website or the carrier’s website.<br>
                </p>
            </div>
        </div>
    </div>        
<?php include 'footer.php'; ?>
</body>
</html>

