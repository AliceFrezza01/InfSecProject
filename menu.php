<!-- TOP MENU -->
<div class="topnav">
    <a class="active" href="landingPage.php">Home</a>
    <a href="chat.php">Chat</a>
    <?php

    global $user;
    global $userid;

    //if the user is a buyer, it should not be able to see its orders
    if ($user['isVendor']==1) {
        echo "<a href=\"orders.php?vendorId=" . $userid . "\">Orders</a>";
    }
    ?>
    <div class="logout_div">
        <form class="logout_form" method='post'>
            <input class="button_logout" type="submit" name="logout" value="LOG OUT">
        </form>
    </div>

</div>