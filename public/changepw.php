<?php

    // configuration
    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $currentpw = query("SELECT hash FROM users WHERE id = ?", $_SESSION["id"]);
        $currentpw = $currentpw[0]["hash"];
        
        if (empty($_POST["oldpw"]) || empty($_POST["newpw"]) || empty($_POST["cfrmpw"]))
        {
            apologize("You must type in all the provided fields.");
        }
        else if ($currentpw != crypt($_POST["oldpw"], $currentpw))
        {
            apologize("You have typed in the wrong password.");
        }
        else if ($_POST["newpw"] != $_POST["cfrmpw"])
        {
            apologize("You haven't confirmed your new password properly.");
        }
        else if ($_POST["oldpw"] == $_POST["newpw"])
        {
            apologize("Your must change your password.");
        }
        
        query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["newpw"], $currentpw), $_SESSION["id"]);
        
        render("changepw_confirm.php", ["title" => "Password Change Confirmation"]);
    }
    
    else
    {
        render("changepw.php", ["title" => "Change Password"]);
    } 

?>
