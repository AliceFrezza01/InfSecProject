<!-- TOP MENU -->
<div class="topnav">
    <a class="active" href="landingpage.php">Landing Page</a>
    <a href="chat.php">Chat</a>
    <?php
    //if the user is a buyer, it should not be able to see its orders
    if ($user['isVendor']==1) {
        echo "<a href=\"orders.php?vendorId=" . $userid . "\">Orders</a>";
    }
    ?>
    <form method='post'>
        <input class="button" type="submit" name="logout" value="LOG OUT">
    </form>
</div>