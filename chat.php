<?php
session_start();
?>
<?php

include ('connect.php');
include('authenticationUser.php');
include ('xssSanitation.php');

global $con;
global $user;

//prepared query: get all chats
$chatqueryresult = $con->prepare("SELECT * FROM chatmessage WHERE recieverUserID =? or senderUserID =? order by id desc");
$chatqueryresult->bind_param('ii', $userid, $userid);
$chatqueryresult->execute();
$chatqueryresult = $chatqueryresult->get_result();

$userchatcreated = array();

if ($chatqueryresult->num_rows > 0) {
    while ($r = $chatqueryresult->fetch_assoc()) {

        if($r['senderUserID'] != $userid){
            $otheruserofchatid = null;
            if(!array_key_exists($r['senderUserID'], $userchatcreated)){
                $otheruserofchatid=$r['senderUserID'];
            }
        }else{
            if(!array_key_exists($r['recieverUserID'], $userchatcreated)) {
                $otheruserofchatid=$r['recieverUserID'];
            }
        }

        if($otheruserofchatid != null){

            //prepared query
            $otheruserqueryresult = $con->prepare("SELECT * FROM user WHERE id=?");
            $otheruserqueryresult->bind_param('i', $otheruserofchatid);
            $otheruserqueryresult->execute();
            $otheruserqueryresult = $otheruserqueryresult->get_result();

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

    //prepared query: get name of user we chat with
    $userofchatquery = $con->prepare("SELECT * FROM user WHERE id=?");
    $userofchatquery->bind_param('i', $chatwithuserid);
    $userofchatquery->execute();
    $userofchatquery = $userofchatquery->get_result();

    if($userofchatquery->num_rows == 1){
        $userofchat = $userofchatquery->fetch_assoc();
        $chatwithusername = $userofchat['name'];
    }

    //prepared query: get all messages with this user
    $chatqueryresult = $con->prepare("SELECT * FROM chatmessage WHERE (recieverUserID =? and senderUserID=?) or (recieverUserID =? and senderUserID =?)");
    $chatqueryresult->bind_param('iiii', $userid, $chatwithuserid, $chatwithuserid, $userid);
    $chatqueryresult->execute();
    $chatqueryresult = $chatqueryresult->get_result();

    if ($chatqueryresult->num_rows > 0) {
        while ($r = $chatqueryresult->fetch_assoc()) {
            if($r['senderUserID'] == $userid){
                $class = 'ownwrittenmsg';
            }else{
                $class = 'recievedmsg';
            }
            array_push($chatmsg, array('text'=>$r['text'], 'date'=>$r['date'], 'class'=>$class));
        }
    }

    //if button is clicked
    if(isset($_POST['sendmsg'])){

        $token = input($_POST['token']);

        if (verifyToken($token)) {
            $message = input(sanitation($_POST['msgtext'], "string", false));
            $date = date('Y-m-d H:i:s');

            //prepared query: insert a text message
            $result = $con->prepare("INSERT INTO chatmessage(`text`, `date`, `recieverUserID`, `senderUserID`) VALUES (?,?,?,?)");
            $result->bind_param('sssi', $message, $date, $chatwithuserid, $userid);
            $result->execute();

            header("Refresh:0");
        }

    }
}




?>

<!--HTML CODE-->

<!DOCTYPE html>
<html lang="en-us">
<?php $title = 'Shop: Chat - ' . $chatwithusername ; include('head.php') ?>
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
                    <input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
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
