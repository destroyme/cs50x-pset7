<div class="row">
    <!-- first spacing -->
    <div class="col-md-4"></div>
    
    <!-- container for the middle-->
    <div class="col-md-4">
        <table class="table table-condensed table-hover row">
            <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Shares</th>
                    <th>Price</th>
                    <th>Current Value</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($positions as $position): ?>

                    <tr>
                        <td><?= $position["symbol"] ?></td>
                        <td><?= number_format($position["shares"], 0, '.', ',') ?></td>
                        <td><?= number_format($position["price"], 2, '.', ',') ?></td>
                        <td><?= number_format($position["price"]*$position["shares"], 2, '.', ',') ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
        <p>Cash Available: <?php echo number_format($cash[0]["cash"], 2, '.', ',') ?></p>
    </div>
</div>
