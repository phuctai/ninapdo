<div class="title-main"><span><?=$title_crumb?></span></div>
<div class="content-main w-clear">
    <div class="top-contact">
        <div class="article-contact"><?=htmlspecialchars_decode($lienhe['noidung'.$lang])?></div>
        <form class="form-contact validation-contact" novalidate method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="input-contact col-sm-6">
                    <input type="text" class="form-control" id="ten" name="ten" placeholder="<?=_hoten?>" required />
                    <div class="invalid-feedback"><?=_vuilongnhaphoten?></div>
                </div>
                <div class="input-contact col-sm-6">
                    <input type="number" class="form-control" id="dienthoai" name="dienthoai" placeholder="<?=_sodienthoai?>" required />
                    <div class="invalid-feedback"><?=_vuilongnhapsodienthoai?></div>
                </div>         
            </div>
            <div class="row">
                <div class="input-contact col-sm-6">
                    <input type="text" class="form-control" id="diachi" name="diachi" placeholder="<?=_diachi?>" required />
                    <div class="invalid-feedback"><?=_vuilongnhapdiachi?></div>
                </div>
                <div class="input-contact col-sm-6">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                    <div class="invalid-feedback"><?=_vuilongnhapdiachiemail?></div>
                </div>
            </div>
            <div class="input-contact">
                <input type="text" class="form-control" id="tieude" name="tieude" placeholder="<?=_chude?>" required />
                <div class="invalid-feedback"><?=_vuilongnhapchude?></div>
            </div>
            <div class="input-contact">
                <textarea class="form-control" id="noidung" name="noidung" placeholder="<?=_noidung?>" required /></textarea>
                <div class="invalid-feedback"><?=_vuilongnhapnoidung?></div>
            </div>
            <div class="input-contact">
                <input type="file" class="custom-file-input" name="file">
                <label class="custom-file-label" for="file" title="<?=_chon?>"><?=_dinhkemtaptin?></label>
            </div>
            <input type="submit" class="btn btn-primary" name="submit-contact" value="<?=_gui?>" disabled />
            <input type="reset" class="btn btn-secondary" value="<?=_nhaplai?>" />
            <input type="hidden" name="recaptcha_response_contact" id="recaptchaResponseContact">
        </form>
    </div>
    <div class="bottom-contact"><?=htmlspecialchars_decode($setting['toado_iframe'])?></div>
</div>