<div class="wrap-user">
    <div class="title-user">
        <span><?=_kichhoat?></span>
    </div>
    <form class="form-user validation-user" novalidate method="post" action="account/kich-hoat/id=<?=$_GET['id']?>" enctype="multipart/form-data">
        <div class="input-group input-user">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-qrcode"></i></div>
            </div>
            <input type="text" class="form-control" id="maxacnhan" name="maxacnhan" placeholder="<?=_nhapmakichhoat?>" required>
            <div class="invalid-feedback"><?=_vuilongnhapmakichhoat?></div>
        </div>
        <div class="button-user">
            <input type="submit" class="btn btn-primary" name="kichhoat" value="<?=_kichhoat?>" disabled>
        </div>
    </form>
</div>