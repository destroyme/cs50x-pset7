<div class="row">
    <!-- first spacing -->
    <div class="col-md-4"></div>
    
    <!-- container for the middle-->
    <div class="col-md-4">
        <table class="table table-condensed table-hover row">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Action</th>
                    <th>Symbol</th>
                    <th>Shares</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>

                    <tr>
                        <td><?= $row["time"] ?></td>
                        <td><?= $row["action"] ?></td>
                        <td><?= $row["symbol"] ?></td>
                        <td><?= number_format($row["shares"]) ?></td>
                        <td><?= number_format($row["price"], 2, '.', ',') ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
