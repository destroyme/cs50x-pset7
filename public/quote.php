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
        
        // lookup the symbol and check if it's valid
        $stock = lookup($_POST["symbol"]);
        if ($stock === false)
        {
            apologize("That symbol was not found, try again.");
        }
        
        
        // redirect to portfolio
        render("quote_return.php", ["title" => "Quote", "symbol" => $stock["symbol"], "name" => $stock["name"], "price" => $stock["price"]]);
    }
    
    else
    {
        // else render form
        render("quote_form.php", ["title" => "Quote"]);
    }


?>
