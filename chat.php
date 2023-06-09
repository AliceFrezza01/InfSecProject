<?php
session_start();
?>
<?php

include ('connect.php');
include ('authenticationUser.php');

global $con;
global $user;
global $userid;


//get all chets
$chatqueryresult = $con->query("SELECT * FROM chatmessage WHERE receiverUserID = '$userid' or senderUserID = '$userid' order by id desc");
$userchatcreated = array();
if ($chatqueryresult->num_rows > 0) {
    while ($r = $chatqueryresult->fetch_assoc()) {
        if($r['senderUserID'] != $userid){
            $otheruserofchatid = null;
            if(!array_key_exists($r['senderUserID'], $userchatcreated)){
                $otheruserofchatid=$r['senderUserID'];
            }
        }else{
            if(!array_key_exists($r['receiverUserID'], $userchatcreated)) {
                $otheruserofchatid=$r['receiverUserID'];
            }
        }
        if($otheruserofchatid != null){
            $otheruserqueryresult = $con->query("SELECT * FROM user WHERE id = '$otheruserofchatid'");
            if($otheruserqueryresult->num_rows == 1){
                $otheruserofchat = $otheruserqueryresult->fetch_assoc();
                $userchatcreated[$otheruserofchatid]= array('name'=>$otheruserofchat['name'], 'date'=>$r['date']);
            }
        }

    }
}

//get all chatmessages
$chatmsg = array();
$chatwithusername = null;
if(isset($_GET['id'])){
    $chatwithuserid = $_GET['id'];
    //get name of user we chat with
    $userofchatquery = $con->query("SELECT * FROM user WHERE id = '$chatwithuserid'");
    if($userofchatquery->num_rows == 1){
        $userofchat = $userofchatquery->fetch_assoc();
        $chatwithusername = $userofchat['name'];
    }

    //get all messages with this user
    $chatqueryresult = $con->query("SELECT * FROM chatmessage WHERE (receiverUserID = '$userid' and senderUserID = '$chatwithuserid') or (receiverUserID = '$chatwithuserid' and senderUserID = '$userid')");
    if ($chatqueryresult->num_rows > 0) {
        while ($r = $chatqueryresult->fetch_assoc()) {
            if($r['senderUserID'] == $userid){
                $class = 'ownwrittenmsg';
            }else{
                $class = 'receivedmsg';
            }
            array_push($chatmsg, array('text'=>$r['text'], 'date'=>$r['date'], 'class'=>$class));
        }
    }

    //if button is clicked
    if(isset($_POST['sendmsg'])){
        $message = input($_POST['msgtext']);
        $date = date('Y-m-d H:i:s');
        $result = $con->query("INSERT INTO chatmessage(`text`, `date`, `receiverUserID`, `senderUserID`) VALUES ('$message','$date','$chatwithuserid','$userid')");
        header("Refresh:0");
    }
}




?>

<!--HTML CODE-->

<!DOCTYPE html>
<html lang="en-us">
<?php include('head.php') ?>
<body>
<div>
    <?php include('menu.php') ?>

    <div style="display: flex; padding-top: 70px; padding-left: 20px;">
        <div style="width: 200px;  background-color: #cecece; height: calc(100vh - 230px); overflow-y: scroll; overflow-x: hidden;">
            <?php
            foreach ($userchatcreated as $key=>$userch){
                ?>
                <a href="chat.php?id=<?php echo $key ?>">
                    <div style="padding: 10px; border-bottom: 1px solid black">
                        <h3><?php echo $userch['name'] ?></h3>
                        <p><?php echo $userch['date'] ?></p>
                    </div>
                </a>
                <?php
            }
            ?>

        </div>
        <div style="width: calc(100% - 300px); background-color: #cecece; height: calc(100vh - 230px); overflow-y: scroll; overflow-x: hidden;">
            <?php
            if($chatwithusername != null){
                ?>
                <div style="padding: 20px; background-color: #333333; color: #ffffff;"><?php echo $chatwithusername ?></div>
                <?php
                foreach ($chatmsg as $msg){
                    ?>
                    <div class="<?php echo $msg['class'] ?>" style="padding: 10px; margin-top: 10px; max-width: 250px; ">
                        <h3><?php echo $msg['text'] ?></h3>
                        <p><?php echo $msg['date'] ?></p>
                    </div>
                    <?php
                }

                ?>
                <form  action="" method="post" style=" display: flex;">
                    <input style="width: 100%" type="text" name="msgtext">
                    <input type="submit" value="send" class="button" name="sendmsg">
                </form>
            <?php
            }
            ?>

        </div>
    </div>




</div>


</body>
</html>
