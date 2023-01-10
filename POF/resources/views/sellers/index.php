<input type="hidden" id="username" value="<?= $_SESSION['user']['user_id'] ?>">
<div class="container-fluid d-flex my-3 w-100">
    <input id="search" type="search" class="form-control" placeholder="Search Here....." aria-label="search" aria-describedby="search" name="search">
    <i id="search_icon" class="fa-solid fa-magnifying-glass"></i>
</div>

<div id="product_pox">
    <div class="d-flex justify-content-between m-2 px-1">
        <div>
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                Daily Sales
            </button>
            <div class="offcanvas offcanvas-start w-50 off_selling" tabindex="-1" id="offcanvasExample">
                <div class="offcanvas-body">
                    <h3 class="text-center mb-3 mt-5">Daily Sales</h3>
                    <hr>
                    <table class="table table-hover m-auto ">
                        <thead>
                            <tr>
                                <th scope="col">Item Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody id="daily_card">
                        </tbody>
                    </table>
                </div>
            </div>
            <button id="clear" type="button" class="btn btn-primary">Reload <i class="fa-solid fa-rotate-right"></i></button>
        </div>
        
        <div class="mt-2" id="cart">
            <button class="btn btn-primary position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Cart <i class="fa-solid fa-cart-shopping td_transaction"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <span id="cart_now">0</span>
                    <span class="visually-hidden">unread messages</span>
            </button>
            <div class="offcanvas offcanvas-end w-50 off_selling" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <h3 class="text-center mb-3 mt-5">Cart</h3>
                    <hr>
                    <div class="info mt-2 ml-2">
                        <strong class="text-success  ms-1" class="color">Total Sales:</strong>
                        <span class="text-success" id="total-sales"> 0 </span>
                    </div>
                    <table class="table m-auto">
                        <thead>
                            <tr>
                                <th scope="col" class="w-25">Item Name</th>
                                <th scope="col" class="w-25">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="transaction_now">
                            <p></p>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr class="m-2">
    <div class="m-2" id="dataTableContainer">
        <table class="table table-hover align-middle bg-white">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Item Name</th>
                    <th scope="col">Item Quantity</th>
                    <th scope="col">Item Price</th>
                    <th scope="col" class="ps-5">Add To Cart</th>
                </tr>
            </thead>
            <tbody id="items_list">
            </tbody>
        </table>
    </div>
</div>