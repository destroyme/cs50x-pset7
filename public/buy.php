<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a stock symbol.");
        }
        else if (empty($_POST["shares"]))
        {
            apologize("You must include the amount of shares you wish to purchase.");
        }
        
        // convert submission to uppercase (see if it would work without it!)
        $_POST["symbol"] = strtoupper($_POST["symbol"]);
        
        // lookup the symbol and check if it's valid
        $stock = lookup($_POST["symbol"]);
        if ($stock === false)
        {
            apologize("That symbol was not found, try again.");
        }
        
        // check to see if user can afford to purchase the stock(s)
        $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
        $cash = $cash[0]["cash"];
        $stockpurchase = $stock["price"] * $_POST["shares"];
        if ($stockpurchase > $cash)
        {
            apologize("You're purchase is greater than your current available balance. Add more funds first.");
        }
        
        // insert stock and amount of shares and adjust cash balance.
        else
        {
            query("INSERT INTO portfolio (id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], $_POST["symbol"], $_POST["shares"]);
            query("INSERT INTO history (id, time, action, symbol, shares, price) VALUES (?,NOW(),'BUY',?,?,?)", $_SESSION["id"], $_POST["symbol"], $_POST["shares"], $stock["price"]);
            query("UPDATE users SET cash = cash - $stockpurchase WHERE id = ?", $_SESSION["id"]);
            render("buy_congratulations.php", ["title" => "Congratulations!"]);
        }        
        
    }
    else
    {
        render("buy_form.php", ["title" => "Buy"]);
    }
?>
