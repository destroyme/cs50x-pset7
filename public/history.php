<?php

    // configuration
    require("../includes/config.php");
    
    // query history table
    $rows = query("SELECT time, action, symbol, shares, price FROM history WHERE id = ?", $_SESSION["id"]);
    
    
    render("history.php", ["title" => "History", "rows" => $rows]);

?>
