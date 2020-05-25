<div class="wrap-user">
    <div class="title-user">
        <span><?=_thongtincanhan?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/thong-tin" enctype="multipart/form-data">
        <label for="basic-url"><?=_hoten?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control" id="ten" name="ten" placeholder="<?=_nhaphoten?>" value="<?=$row_detail['ten']?>" required>
            <div class="invalid-feedback"><?=_vuilongnhaphoten?></div>
        </div>
        <label for="basic-url"><?=_taikhoan?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input type="text" class="form-control" id="username" name="username" placeholder="<?=_nhaptaikhoan?>" value="<?=$row_detail['username']?>" readonly required>
        </div>
        <label for="basic-url"><?=_matkhaucu?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control" id="password" name="password" placeholder="<?=_nhapmatkhaucu?>">
        </div>
        <label for="basic-url"><?=_matkhaumoi?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control" id="new-password" name="new-password" placeholder="<?=_nhapmatkhaumoi?>">
        </div>
        <label for="basic-url"><?=_nhaplaimatkhaumoi?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="password" class="form-control" id="new-password-confirm" name="new-password-confirm" placeholder="<?=_nhaplaimatkhaumoi?>">
        </div>
        <label for="basic-url"><?=_gioitinh?></label>
        <div class="input-group input-user">
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nam" name="gioitinh" class="custom-control-input" <?=($row_detail['gioitinh']==1)?'checked':''?> value="1" required>
                <label class="custom-control-label" for="nam"><?=_nam?></label>
            </div>
            <div class="radio-user custom-control custom-radio">
                <input type="radio" id="nu" name="gioitinh" class="custom-control-input" <?=($row_detail['gioitinh']==2)?'checked':''?> value="2" required>
                <label class="custom-control-label" for="nu"><?=_nu?></label>
            </div>
        </div>
        <label for="basic-url"><?=_ngaysinh?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-lock"></i></div>
            </div>
            <input type="text" class="form-control" id="ngaysinh" name="ngaysinh" placeholder="<?=_nhapngaysinh?>" value="<?=date("d/m/Y",$row_detail['ngaysinh'])?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapsodienthoai?></div>
        </div>
        <label for="basic-url">Email</label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-envelope"></i></div>
            </div>
            <input type="email" class="form-control" id="email" name="email" placeholder="<?=_nhapemail?>" value="<?=$row_detail['email']?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapdiachiemail?></div>
        </div>
        <label for="basic-url"><?=_dienthoai?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-phone-square"></i></div>
            </div>
            <input type="number" class="form-control" id="dienthoai" name="dienthoai" placeholder="<?=_nhapdienthoai?>" value="<?=$row_detail['dienthoai']?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapsodienthoai?></div>
        </div>
        <label for="basic-url"><?=_diachi?></label>
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-map"></i></div>
            </div>
            <input type="text" class="form-control" id="diachi" name="diachi" placeholder="<?=_nhapdiachi?>" value="<?=$row_detail['diachi']?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapdiachi?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary btn-block" name="capnhatthongtin" value="<?=_capnhat?>" disabled>
        </div>
    </form>
</div>