<div class="h4 pb-2 mb-4 text-warning border-bottom border-warning mt-3 d-flex justify-content-between had">
    <span> Updating Transaction <span id="delete_p">in the system</span>
        <i class="fa-solid fa-right-left me-2"></i>
    </span>
    <a href="/transactions" class="btn btn-danger me-2">
        cancel
    </a>
</div>

<form action="/transactions/update" method="POST" enctype="multipart/form-data" class="w-50 m-auto p-5 bg-white alert shadow p-3 mb-5 form_form">

    <input type="hidden" name="id" value="<?= $data->transaction->id ?>">
    <input type="hidden" id="item_p" name="price" value="<?= $data->item_price->price ?>">

    <div class="mb-3">
        <label for="item-name" class="form-label">Item Name</label>
        <input type="text" value="<?= $data->transaction->item_name ?>" class="form-control" id="item-name" name="item_name" readonly required>
    </div>

    <div class="mb-3">
        <label for="item-quantity" class="form-label">Quantity</label>
        <input type="number" id="item_q" min="0" value="<?= $data->transaction->quantity ?>" class="form-control" id="display-name" name="quantity" required>
        <div id="totalHelp" class="form-text text-danger">
            <?= isset($_SESSION['error']) ? $_SESSION['error'] : null   ?>
            <?php unset($_SESSION['error']) ?>
        </div>
    </div>

    <div class="mb-3">
        <label for="item-total" class="form-label">Total </label>
        <input type="number" id="item_t" class="form-control" id="item-total" aria-describedby="totalHelp" name="total" value="<?= $data->transaction->total ?>" readonly step="any" required>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>