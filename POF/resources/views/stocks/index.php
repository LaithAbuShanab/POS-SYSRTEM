<h1 class="text-center my-2 text-primary">Items List(<?= $data->stock_count ?>)</h1>

<table class="table table-hover align-middle my-5 bg-white img_item">
    <thead class="bg-light">
        <tr>
            <th>Name</th>
            <th class="cost_item">Cost</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data->items as $item) : ?>
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="<?= $item->photo ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                        <div class="ms-3">
                            <p class="fw-bold mb-1 font_item"><?= $item->name ?></p>
                        </div>
                    </div>
                </td>
                <td class="cost_item">
                    <p class="fw-normal mb-1"> <?= $item->cost ?>$</p>
                </td>
                <td>
                    <p class="fw-normal mb-1"><?= $item->price ?>$</p>
                </td>
                <td>
                    <?php if ($item->quantity == 0) : ?>
                        <span class="badge rounded-pill text-bg-danger">Empty</span>
                    <?php else : ?>
                        <?= $item->quantity ?>
                    <?php endif ?>
                </td>
                <td>
                    <a href="/stocks/delete?id=<?= $item->id ?>" class="btn btn-outline-danger border border-0"><i class="fa-solid fa-trash"></i></a>
                    <a href="/stocks/edit?id=<?= $item->id ?>" class="btn btn-outline-warning border border-0"><i class="fa-solid fa-wrench"></i></a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot class="bg-light">
        <tr>
            <th>Name</th>
            <th>Cost</th>
            <th>Price</th>
            <th>Quantity</th>
            <th class="cost_item">Actions</th>
        </tr>
    </tfoot>
</table>