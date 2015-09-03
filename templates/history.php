    <table class="table table-striped">
        <thead>
            <tr>
                <th>Time</th>
                <th>Action</th>
                <th>Stock</th>
                <th>Shares</th>
                <th>Transaction</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($stocks as $stock): ?>
            <tr>
                <td><?= $stock["time"] ?> </td>
                <td><?= $stock["action"] ?> </td>
                <td><?= $stock["symbol"] ?> </td>
                <td><?= $stock["shares"] ?> </td>
                <td>
                <?php
                    if ($stock["action"] === "SELL" )
                    {
                        print( "+$".number_format($stock["cash"],2));  
                    }
                    else
                    {
                        print("-$".number_format($stock["cash"],2));
                    }
                ?>
                </td>

            </tr>

        <?php endforeach ?>
        </tbody>
         
    </table>
