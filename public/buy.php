<?php
    // configuration 
    require("../includes/config.php");
    
    if (empty($_POST["symbol"]) === TRUE)
    {
        render("buy.php");
    }
    else
    {
        // check if all fields were filled
        if ( empty($_POST["symbol"]) === TRUE || empty($_POST["shares"]) === TRUE)
        {
            render("apology.php", ["message" => "You must fill all fields!", "title" => "Oops!"]);
        }

        // determine if "shares" input is valid
        else if (preg_match("/^\d+$/", $_POST["shares"]) == FALSE)
        {
            render("apology.php", ["message" => "You entered an invalid amount of shares", "title" => "Oops!"]);
        }
        else if (lookup($_POST["symbol"]) === FALSE)
        {
            render("apology.php", ["message" => "Stock not found!", "title" => "Ooops!"]);
        }
        else 
        {

            // determine total cost of shares bought 
            $stockPrice = lookup($_POST["symbol"])["price"]; 
            $totalCost = $_POST["shares"] * $stockPrice; 
            


            // check if user has sufficient funds
            if ( query("SELECT cash FROM users WHERE id = ?",$_SESSION["id"])[0]["cash"] < $totalCost )
            {
                render("apology.php", ["message" => "Insufficient funds.", "title" => "Oops!"]);
            }
            else
            {
                // remove funds from users table
                query("UPDATE users SET cash = cash - ? WHERE id = ?", $totalCost, $_SESSION["id"]);

                // add new stocks to portfolio
                // check if user owns shares already of that stock
                if (empty(query("SELECT * FROM stocks WHERE symbol = ? AND id = ?", $_POST["symbol"], $_SESSION["id"])) === TRUE)
                {
                    // insert new row with stock's values
                    query("INSERT INTO stocks (id, symbol, shares) VALUES (?,?,?)", $_SESSION["id"], $_POST["symbol"], $_POST["shares"]);  
                }

                // if user owns already, simply update the table
                else
                {
                    query("UPDATE stocks SET shares = shares + ? WHERE id = ? AND symbol = ?", $_POST["shares"], $_SESSION["id"], $_POST["symbol"]);
                }

                // insert into history table
                query("INSERT INTO history (action, symbol, shares, cash, id) VALUES ( 'BUY', ?, ?, ?, ? )", $_POST["symbol"],$_POST["shares"], $totalCost, $_SESSION["id"]);

                //redirect to index when done
                redirect("/");
                
            }
        } 

    }
?>
