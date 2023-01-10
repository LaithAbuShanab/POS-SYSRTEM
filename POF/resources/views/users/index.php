<h1 class="text-center my-2 text-primary">Employees List(<?= $data->user_count ?>)</h1>

<div class="container my-2">
    <div class="row">
        <?php foreach ($data->users as $user) : ?>
            <div class="col-md-6 col-lg-4 col-xl-3 mt-4 mb-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="<?= $user->photo ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                            <h5 class="card-title mt-2"> &nbsp<?= $user->display_name ?></h5>
                        </div>
                        <?php if ($user->active) : ?>
                            <p class="text-success mb-1">Online <i class="fa-solid fa-power-off"></i></p>
                        <?php else : ?>
                            <p class="text-danger mb-1">Offline <i class="fa-solid fa-power-off"></i></p>
                        <?php endif ?>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $user->role ?></h6>
                        <a href="./user/profile?id=<?= $user->id ?>" class="card-link btn btn-primary">Check</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>