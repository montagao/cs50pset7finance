<?php

    // configuration
    require("../includes/config.php"); 

    // lookup the users shares info, as well as cash balance
    
    $userCash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);

    $userStocks = query("SELECT * FROM stocks WHERE id = ?", $_SESSION["id"]);
    
    $stockInfo = [];
    foreach ($userStocks as $userStock)
    {
        $stock = lookup($userStock["symbol"]);
        if ($stock !== FALSE)
        {
            $stockInfo[] = [
                "name" => $stock["name"], 
                "price" => $stock["price"],
                "shares" => $userStock["shares"],
                "symbol" => $userStock["symbol"]
            ];
        }
    }
    
    
    // render portfolio
    render("portfolio.php", ["title" => "Portfolio", "cash" => $userCash, "stocks" => $stockInfo]);

?>
