
<div style="text-align:center">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Shares</th>
                <th>Price</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($stocks as $stock): ?>
            <tr>
                <td><?= $stock["symbol"] ?> </td>
                <td><?= $stock["name"] ?> </td>
                <td><?= $stock["shares"] ?> </td>
                <td>$<?= $stock["price"] ?> </td>
                <td>$<?= number_format($stock["shares"] * $stock["price"],2) ?> </td>
            </tr>
        <?php endforeach ?>
            <tr>
                <td> CASH </td>
                <td></td>
                <td></td>
                <td></td>
                <td>$<?= number_format($cash[0]["cash"],2) ?></td>
            </tr>
        </tbody>
         
    </table>
</div>
