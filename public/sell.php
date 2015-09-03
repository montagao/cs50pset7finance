<?php

    require("../includes/config.php");
    // grab all users stock information
    $usersStocks = query("SELECT symbol FROM stocks WHERE id = ?", $_SESSION["id"]);
    

    if (empty($_POST["stock"]) === TRUE) 
    {
        render("sell.php", ["stocks" => $usersStocks]); 
    }
    else
    {
        // determine how many shares of the stock sold the user owned
        $sharesOwned = query("SELECT shares FROM stocks WHERE symbol = ?", $_POST["stock"])[0]["shares"];

        // determine the price of the stock sold
        $priceSold = lookup($_POST["stock"])["price"];

        // determine the total value  of  stock that was sold
        $totalSales = $sharesOwned * $priceSold; 

        // update users cash with added sales from sold shares
        query("UPDATE users SET cash = cash + ? where id = ?", $totalSales, $_SESSION["id"]); 

        // remove shares from stocks table
        query("DELETE FROM stocks WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["stock"]);

        
        // add to history table
        $test = query("INSERT INTO history (action, symbol, shares, cash, id) VALUES ( 'SELL', ?, ?, ?, ? )", $_POST["stock"],$sharesOwned, $totalSales, $_SESSION["id"]);
        redirect("/");
    }
?>
