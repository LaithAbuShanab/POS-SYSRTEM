<div class="h4 pb-2 mb-4 text-success border-bottom border-success mt-3 d-flex justify-content-between had">
    <span> Adding Items <span id="delete_p">to the store</span>
        <i class="fa-solid fa-warehouse me-2"></i></span>
    <a href="/stocks" class="btn btn-danger me-2">
        cancel
    </a>
</div>


<form action="/stocks/store" method="POST" enctype="multipart/form-data" class="w-50 m-auto p-5 bg-white alert shadow p-3 mb-5 form_form">

    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
        <div class=" alert alert-danger text-center" role="alert">
            <?= $_SESSION['error'] ?> </div>
    <?php endif;
    unset($_SESSION['error']);
    ?>

    <div class="mb-2">
        <label for="item_name" class="form-label">Item name</label>
        <input type="text" class="form-control" id="item_name" name="name" required>
    </div>

    <div class="mb-2">
        <label for="item_cost" class="form-label">Item cost</label>
        <input type="number" class="form-control" id="item_cost" name="cost" step="any" required>
    </div>

    <label for="item_price" class="form-label">Item price</label>
    <div class="mb-2 input-group">
        <span class="input-group-text">$</span>
        <input type="text" id="item_price" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" step="any" required>
        <span class="input-group-text">.00</span>
    </div>

    <div class="mb-2">
        <label for="item_quantity" class="form-label">Item quantity</label>
        <input type="text" class="form-control" id="item_quantity" name="quantity" required>
    </div>

    <div class="mb-2">
        <label for="item_photo" class="form-label">Item photo</label>
        <input type="file" class="form-control" id=" item_photo" name="photo" required>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">Create</button>
    </div>

</form>