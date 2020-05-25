<div class="wrap-user">
    <div class="title-user">
        <span><?=_dangky?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/dang-ky" enctype="multipart/form-data">
        <label for="basic-url"><?=_hoten?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control" id="ten" name="ten" placeholder="<?=_nhaphoten?>" required>
            <div class="invalid-feedback"><?=_vuilongnhaphoten?></div>
        </div>
        <label for="basic-url"><?=_taikhoan?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control" id="username" name="username" placeholder="<?=_nhaptaikhoan?>" required>
            <div class="invalid-feedback"><?=_vuilongnhaptaikhoan?></div>
        </div>
        <label for="basic-url"><?=_matkhau?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control" id="password" name="password" placeholder="<?=_nhapmatkhau?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapmatkhau?></div>
        </div>
        <label for="basic-url"><?=_nhaplaimatkhau?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control" id="repassword" name="repassword" placeholder="<?=_nhaplaimatkhau?>" required>
            <div class="invalid-feedback"><?=_vuilongnhaplaimatkhau?></div>
        </div>
        <label for="basic-url"><?=_gioitinh?></label>
        <div class="input-group input-user">
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nam" name="gioitinh" class="custom-control-input" value="1" required>
                <label class="custom-control-label" for="nam"><?=_nam?></label>
            </div>
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nu" name="gioitinh" class="custom-control-input" value="2" required>
                <label class="custom-control-label" for="nu"><?=_nu?></label>
            </div>
        </div>
        <label for="basic-url"><?=_ngaysinh?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="text" class="form-control" id="ngaysinh" name="ngaysinh" placeholder="<?=_nhapngaysinh?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapsodienthoai?></div>
        </div>
        <label for="basic-url">Email</label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
            </div>
            <input type="email" class="form-control" id="email" name="email" placeholder="<?=_nhapemail?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapdiachiemail?></div>
        </div>
        <label for="basic-url"><?=_dienthoai?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-phone-square"></i></div>
            </div>
            <input type="number" class="form-control" id="dienthoai" name="dienthoai" placeholder="<?=_nhapdienthoai?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapsodienthoai?></div>
        </div>
        <label for="basic-url"><?=_diachi?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-map"></i></div>
            </div>
            <input type="text" class="form-control" id="diachi" name="diachi" placeholder="<?=_nhapdiachi?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapdiachi?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary btn-block" name="dangky" value="<?=_dangky?>" disabled>
        </div>
    </form>
</div>