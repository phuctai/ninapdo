<div class="wrap-user">
    <div class="title-user">
        <span><?=_quenmatkhau?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/quen-mat-khau" enctype="multipart/form-data">
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control" id="username" name="username" placeholder="<?=_taikhoan?>" required>
            <div class="invalid-feedback"><?=_vuilongnhaptaikhoan?></div>
        </div>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
            </div>
            <input type="email" class="form-control" id="email" name="email" placeholder="<?=_nhapemail?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapdiachiemail?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary" name="quenmatkhau" value="<?=_laymatkhau?>" disabled>
        </div>
    </form>
</div>