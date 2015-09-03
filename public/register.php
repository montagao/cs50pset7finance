<?php
    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if use reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"]) == TRUE || empty($_POST["password"]) == TRUE || empty($_POST["confirmation"]) == TRUE)
        {
            render("apology.php", ["title" => "Sorry", "message" => "You must fill all fields"]);
        }
        else if ( $_POST["password"] !== $_POST["confirmation"] )
        {
            render("apology.php", ["title" => "Sorry", "message" => "Your two passwords didn't match!"]);
        }
        else
        {
            if (query("INSERT INTO users (username, hash, cash) VALUES( ?, ?, 10000.00)", $_POST["username"],crypt($_POST["password"])) === FALSE)
            {
                render("apology.php", ["title" => "Oops!", "message" => "Something went wrong!"]);
            } 
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $id = $rows[0]["id"];
            $_SESSION["id"] = $id;
            redirect("index.php");
        }

    }

?>
