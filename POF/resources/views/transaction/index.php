<h1 class="text-center my-2 text-primary">Transaction List(<?= $data->transaction_count ?>)</h1>

<table class="table table-hover align-middle my-5 bg-white">
    <thead class="bg-light">
        <tr>
            <th class="td_transaction">Employee Name</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Total</th>
            <th class="td_transaction">Created At</th>
            <th class="td_transaction">Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->transaction_info as $transaction) : ?>
            <tr>
                <td class="td_transaction">
                    <div class="d-flex align-items-center">
                        <img src="<?= $transaction->photo ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle">
                        <div class="ms-3">
                            <p class="fw-bold mb-1"><?= $transaction->display_name ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1"><?= $transaction->item_name ?></p>
                </td>
                <td>
                    <p class="fw-normal mb-1"><?= $transaction->quantity ?></p>
                </td>
                <td><?= $transaction->total ?>$</td>
                <td class="td_transaction"><?= $transaction->created_at ?></td>
                <td class="td_transaction"><?= $transaction->updated_at ?></td>
                <td>
                    <a href="/transactions/delete?id=<?= $transaction->id ?>" class="btn btn-outline-danger border border-0"><i class="fa-solid fa-trash"></i></a>
                    <a href="/transactions/edit?id=<?= $transaction->id ?>" class="btn btn-outline-warning border border-0"><i class="fa-solid fa-wrench"></i></a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot class="bg-light">
        <tr>
            <th>Employee Name</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Total</th>
            <th class="td_transaction">Created At</th>
            <th class="td_transaction">Updated At</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>