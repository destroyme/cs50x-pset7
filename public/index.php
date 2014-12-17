<?php

    // configuration
    require("../includes/config.php");
    
    $rows = query("SELECT symbol, shares FROM portfolio WHERE id = ?", $_SESSION["id"]);
    $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    
    $positions = [];
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"]
            ];
        }
    }

    // render portfolio
    render("portfolio.php", ["title" => "Portfolio", "positions" => $positions, "cash" => $cash]);

?>
