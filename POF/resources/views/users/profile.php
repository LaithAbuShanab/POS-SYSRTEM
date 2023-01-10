<?php

use Core\Helpers\Helper;

?>
<div class="container py-5 h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center mt-3">
        <div class="col col-lg-6 mb-4 mb-lg-0">
            <div class="card mb-3" style="border-radius: .5rem;">
                <div class="row g-0">
                    <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                        <img src="../../../<?= $data->user->photo ?>" alt="<?= $data->user->photo ?>" class="img-fluid my-5" style="width: 80px;" />
                        <h5 class="text-dark"><?= $data->user->username ?></h5>
                        <p class="text-dark"><?= $data->user->role ?></p>
                        <a href="/users/edit?id=<?= $data->user->id ?>"><i class="far fa-edit mb-5 text-primary"></i></a>
                        <?php if (Helper::check_permission(['user:read'])) : ?>
                            <a href="/users/delete?id=<?= $data->user->id ?>"><i class="fa-solid fa-trash"></i></a>
                        <?php endif ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h6>Information</h6>
                            <hr class="mt-0 mb-4">
                            <div class="row pt-1">
                                <div class="col mb-3">
                                    <h6>Email</h6>
                                    <p class="text-muted mb-0"><?= $data->user->email ?></p>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <h6>Phone</h6>
                                <p class="text-muted mb-5"><?= $data->user->phone ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>