<?php
    require("../includes/config.php");
    
    $history = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
    render("history.php",["stocks"=>$history, "title"=>"History"]);
?>
