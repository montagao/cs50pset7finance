<?php
    require("../includes/config.php");
    
    if (empty($_POST["newpw"]))
    {
        render("pchange_form.php");
    }
    else
    {
        if(empty($_POST["newpw"]) || empty($_POST["newpw2"]) || empty($_POST["oldpw"]))
        {
            render("apology.php", ["message"=>"You must fill all fields"]);
        }
        // 
        else if(crypt($_POST["oldpw"],query("SELECT hash FROM users WHERE id = ?", $_SESSION["id"][0]["hash"])) !== $_SESSION["hash"])
        {
            render("apology.php",["message"=>"Old password entered is incorrect"]);
        }
        else if( $_POST["newpw"] !== $_POST["newpw2"])
        {
            render("apology.php",["message"=>"Passwords do not match!"]);

        }
        else 
        {
            query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["newpw"]) , $_SESSION["id"]);
            redirect("/");
        }

    }
    

?>
