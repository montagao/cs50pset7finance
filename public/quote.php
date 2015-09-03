<?php
    require("../includes/config.php");

    if (empty($_POST["symbol"])=== TRUE)
    {
        render("quote_form.php");
    }
    else
    {
        $stock = lookup($_POST["symbol"]);
        if (empty($stock) === TRUE)
        {
            render("apology.php",["title"=>"Quote Not Found", "message"=> "The symbol you entered couldn't be found"]);
        }
        else
        {
            render("quote.php",["stock"=> $stock]);
        }
    }


?>
