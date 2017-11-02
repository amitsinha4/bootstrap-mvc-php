<?php 
foreach($users as $user){
    echo $user['id']."<br/>";
    echo $user['user_name']."<br/>";
    echo $user['password']."<br/>";
    echo $user['is_active']."<br/>";
}
?>