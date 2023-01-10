<div class="row my-5">
    <div class="col-md-4 col-xl-3">
        <div class="card bg-c-blue order-card">
            <div class="card-block">
                <h6 class="m-b-20">Total Sales</h6>
                <h2 class="text-right d-flex justify-content-between"><i class="fa-solid fa-sack-dollar"></i><span><?= $data->total_sales ?>$</span></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-3">
        <div class="card bg-c-green order-card">
            <div class="card-block">
                <h6 class="m-b-20">Total Transactions</h6>
                <h2 class="text-right d-flex justify-content-between"><i class="fa-solid fa-right-left me-2"></i><span><?= $data->total_transactions ?></span></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-3">
        <div class="card bg-c-yellow order-card">
            <div class="card-block">
                <h6 class="m-b-20">Total Items</h6>
                <h2 class="text-right d-flex justify-content-between"><i class="fa-solid fa-warehouse me-2"></i><span><?= $data->quantity ?></span></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-3">
        <div class="card bg-c-pink order-card">
            <div class="card-block">
                <h6 class="m-b-20">Total Users</h6>
                <h2 class="text-right d-flex justify-content-between"><i class="fa-solid fa-users"></i><span><?= $data->user_count ?></span></h2>
            </div>
        </div>
    </div>
</div>

<h3 class="text-center mb-3 mt-5">Top Five Expensive Items</h3>
<hr>
<table class="table table-hover align-middle mb-0 bg-white mb-5">
    <thead class="bg-light">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Cost</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->top_five_expensive as $item) : ?>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="<?= $item->photo ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                        <div class="ms-3">
                            <p class="fw-bold mb-1"><?= $item->name ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if ($item->quantity == 0) : ?>
                        <span class="badge rounded-pill text-bg-danger">Empty</span>
                    <?php else : ?>
                        <?= $item->quantity ?>
                    <?php endif ?>
                </td>
                <td><?= $item->price  ?>$</td>
                <td><?= $item->cost  ?>$</td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>