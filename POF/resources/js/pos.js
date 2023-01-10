
$(function () {
    const baseUrl = "http://pos.local";
    let totalSales = 0;
    let $totalItem = 0;
    let $user = $("#username").val();
    let counter = 0;

    // AJAX TO GET ALL THE TRANSACTION THAT HAS BEEN MADE TODAY BY THE CURRENT LOGGED IN USER
    $.ajax({
        type: "GET",
        url: baseUrl + "/transaction/sellers",
        success: function (data) {
            data.body.forEach((item) => {
                $("#daily_card").append(`
                <tr>
                <td>${item.item_name}</td>
                <td>${item.quantity}</td>
                <td>${item.total}$</td>
                <td>${item.created_at}</td>
            </tr>
                `);
            });
        },
    });

    // AJAX TO GET ALL ITEMS FROM THE STOCK
    $.ajax({
        type: "GET",
        url: baseUrl + "/sellers",
        success: function (data) {
            data.body.forEach((element) => {
                if (element.quantity > 0) {
                    $("#items_list").append(`
                <tr item-id="${element.id}">
                <td data-id="${element.name}">
                <div class="photo d-flex align-items-center">
                <img src="${element.photo}" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                <div class="ms-3">
                <p class="fw-bold mb-1">${element.name}</p>
                </div>
                </div>
                </td>
                <td data-id="${element.id}">${element.quantity}</td>
                <td>
                ${element.price}$
                </td>
                <td>
                <div class="input-group w-75 mb-1">
                <button data-id="${element.id}" class="btn btn-outline-success border border-0" type="button" id="button-addon1"><i class="fa-solid fa-plus"></i></button>
                <input data-id="${element.id}" type="number" class="form-control count" placeholder="Quantity" min="0" required>
                </div></td>
                </tr>
                `);
                }
                //======================= FOR SEARCH ITEM DIRECTLY===========================
                $('#search').keyup(function () {
                    const search_input = $('#search');
                    const filter = search_input.val();
                    let text = $(`td[data-id="${element.name}"]`).text();
                    if (text.includes(filter)) {
                        $(`tr[item-id="${element.id}"]`).show()
                    } else {
                        $(`tr[item-id="${element.id}"]`).hide('slow', function () {
                        })
                    }
                });
                //==========================================================================

                // CHECK IF THE QUANTITY IS NOT EMPTY
                //TRUE ADD ITEM IN DATABASE AND UPDATE THE QUANTITY
                // FALSE ALERT MASSAGE
                if (element.quantity > 0) {
                    $(
                        `tr[item-id="${element.id}"] button[data-id="${element.id}"]`
                    ).click(function (e) {
                        e.preventDefault();

                        let old_quantity = $(`input[data-id="${element.id}"]`).val();
                        old_quantity = Number(old_quantity);
                        $totalItem = Number(element.price) * old_quantity;
                        totalSales += Number($totalItem);
                        $("#total-sales").text(totalSales + ".$");

                        //Check if the quantity is less than 0
                        if ($(`input[data-id="${element.id}"]`).val() < 0) {
                            swal({
                                title: "A negative value cannot be entered",
                                icon: "error",
                                button: "OK",
                            });
                            return;
                        }

                        //WHEN CLICK BUTTON ADD CREATE THE TRANSACTION TO DATABASE
                        //INPUT COUNT 
                        let count = $(`input[data-id="${element.id}"]`).val();
                        count = Number(count);

                        //CHECK IF QUANTITY > INPUT COUNT
                        if (element.quantity >= count) {

                            $totalItem = Number(element.price) * count;

                            // CHECK THE INPUT COUNT NOT EMPTY
                            if ($totalItem == 0) {
                                swal("Please Inter The Quantity!", "", "warning");
                                return;
                            }

                            $('#cart_now').text(++counter);

                            // SEND THE UNIT QUANTITY TO DATABASE
                            let unit = $(`tr[item-id="${element.id}"] input`).val();
                            element.count = Number(unit);


                            //SEND DATA TO CREATE NEW TRANSACTION
                            let data = {
                                item_name: element.name,
                                quantity: element.count,
                                total: $totalItem,
                            }
                            // CREATE NEW TRANSACTION AND WHEN ADD TO TABLE MAKE SOME OPERATION
                            $.ajax({
                                type: "POST",
                                url: baseUrl + "/sellers/create",
                                data: JSON.stringify(data),
                                success: function (data) {
                                    data.body.forEach((item) => {
                                        $("#transaction_now").append(`
                                        <tr data-id="${item.id}">
                                        <td>${item.item_name}</td>
                                        <td>
                                        <div class="mb-3">
                                        <input min="1" type="number" class="form-control w-75" value="${item.quantity}" quantity-id="${item.id}">
                                        <input type="hidden" value="${item.quantity}" OldQuantity-id="${item.id}">
                                        </div>
                                        </td>
                                        <td total-id="${element.id}">${item.total}$</td>
                                        <td data-id="${item.id * 1000}">
                                        <button edit-id="${item.id * 2000}" class="btn btn-outline-warning border border-0" type="button" id="button-addon1"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button data-id="${item.id * 1000}" class="btn btn-outline-danger border border-0" type="button" id="button-addon1"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                        </tr>
                                        `);

                                        //UPDATE THE QUANTITY IN STOCK
                                        let quantity = element.quantity - element.count;
                                        data = {
                                            id: element.id,
                                            quantity: quantity,
                                        }
                                        $.ajax({
                                            type: "PUT",
                                            url: baseUrl + "/sellers/update",
                                            data: JSON.stringify(data),
                                            success: function (response) {
                                                $(`td[data-id="${element.id * 1}"]`).text(quantity)
                                                element.quantity = element.quantity - element.count;
                                            },
                                        });

                                        $(`button[data-id="${item.id * 1000}"]`).click(function () {
                                            $('#cart_now').text(--counter);
                                            $.ajax({
                                                type: "DELETE",
                                                url: baseUrl + "/sellers/delete",
                                                data: JSON.stringify({
                                                    id: item.id
                                                }),
                                                success: function (response) {
                                                    console.log(response);
                                                    totalSales -= item.total;
                                                    $("#total-sales").text(totalSales + " $");
                                                    $(`tr[data-id="${item.id}"]`).remove();
                                                    swal({
                                                        title: "Deleted Success",
                                                        icon: "success",
                                                        button: "OK",
                                                    });
                                                },
                                            });

                                            let quantity = element.quantity + element.count;
                                            x = {
                                                id: element.id,
                                                quantity: quantity,
                                            };
                                            $.ajax({
                                                type: "PUT",
                                                url: baseUrl + "/sellers/update",
                                                data: JSON.stringify(x),
                                                success: function (response) {
                                                    $(`td[data-id="${element.id * 1}"]`).text(quantity)
                                                    element.quantity = element.quantity + element.count;
                                                },
                                            });
                                        })

                                        let old_quantity = $(`input[OldQuantity-id="${item.id}"]`).val();
                                        $(`button[edit-id="${item.id * 2000}"]`).click(function () {
                                            let NewQuantity = $(`input[quantity-id="${item.id}"]`).val();
                                            let price = element.price;
                                            let NewTotal = $(`td[total-id="${element.id}"]`);
                                            NewTotal.text(NewQuantity * price);

                                            if (NewQuantity >= old_quantity) {
                                                totalSales += (NewQuantity - (old_quantity)) * element.price;
                                                $("#total-sales").text(totalSales + "$");
                                                old_quantity = NewQuantity;

                                            } else if (NewQuantity < old_quantity) {
                                                totalSales -= (((old_quantity) - NewQuantity) * element.price);
                                                $("#total-sales").text(totalSales + "$");
                                                old_quantity = NewQuantity;
                                            }
                                            
                                            data = {
                                                id: item.id,
                                                quantity: NewQuantity,
                                                item_id: element.id,
                                            }
                                            $.ajax({
                                                type: "PUT",
                                                url: baseUrl + "/sellers/update/transaction",
                                                data: JSON.stringify(data),
                                                success: function (response) {
                                                    swal({
                                                        title: "Updated Success",
                                                        icon: "success",
                                                        button: "OK",
                                                    });
                                                }
                                            });
                                        })
                                    })
                                }
                            })
                        } else {
                            swal({
                                title: "Exceeded limit",
                                text: "Please Inter The Quantity",
                                icon: "error",
                                button: "OK",
                            });
                        }
                    })
                } else {
                    $(
                        `button[data-id="${element.id
                        }"]`
                    ).click(function () {
                        swal(`Item ${element.name} Empty`, "", "warning");
                    });
                }
            })
        }
    })
    $("#item_q").change(function () {
        $('#item_t').val($('#item_p').val() * $('#item_q').val());
    });
    $("#clear").click(function () {
        location.reload();
    })
})
