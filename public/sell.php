<?php

    // configuration
    require("../includes/config.php"); 

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a stock symbol that you own.");
        }
        
        // convert submission to uppercase (see if it would work without it!)
        $_POST["symbol"] = strtoupper($_POST["symbol"]);
        
        
        // query database for stock
        $rows = query("SELECT shares FROM portfolio WHERE id = ? and symbol = ?", $_SESSION["id"], $_POST["symbol"]);
        
        if (count($rows) == 1)
        {
            // look up the current price
            $stock = lookup($_POST["symbol"]);
            if ($stock === false)
            {
                apologize("That symbol was not found, try again.");
            }
            
            // query for the current amount of cash
            $curcash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            
            // update cash and tables
            $stockvalue = $stock["price"] * $rows[0]["shares"];
            query("INSERT INTO history (id, time, action, symbol, shares, price) VALUES (?,NOW(),'SELL',?,?,?)", $_SESSION["id"], $_POST["symbol"],$rows[0]["shares"],$stock["price"]);
            query("DELETE FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
            query("UPDATE users SET cash = cash + $stockvalue WHERE id = ?", $_SESSION["id"]);
            
            render("sell_confirmation.php", ["title" => "Sell"]);
        }
        
        // else apologize
        else
        {
        apologize("You currently don't own that stock.");
        }
    }
    
    else
    {
        // else render form
        render("sell_form.php", ["title" => "Sell"]);
    }

?>
