<?php
    $linkSave = "index.php?com=photo&act=save_static&type=".$type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý hình ảnh - video</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?=$linkSave?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết <?=$config['photo']['photo_static'][$type]['title_main']?></h3>
            </div>
            <div class="card-body">
                <?php if($config['photo']['photo_static'][$type]['images']) { ?>
                    <div class="form-group">
                        <label class="change-photo" for="file">
                            <p>Upload hình ảnh:</p>
                            <div class="rounded">
                                <img class="rounded img-upload" id="watermark" left="<?=($item['posleft']) ? $item['posleft'] : 10;?>" top="<?=($item['postop']) ? $item['postop'] : 10;?>" src="<?=THUMBS?>/<?=$config['photo']['photo_static'][$type]['thumb']?>/<?=UPLOAD_PHOTO_L.$item['photo']?>" onerror="src='assets/images/noimage.png'" alt="Alt Photo"/>
                                <strong>
                                    <b class="text-sm text-split"></b>
                                    <span class="btn btn-sm bg-gradient-success"><i class="fas fa-camera mr-2"></i>Chọn hình</span>
                                </strong>
                            </div>
                        </label>
                        <strong class="d-block mt-2 mb-2 text-sm"><?php echo "Width: ".$config['photo']['photo_static'][$type]['width']." px - Height: ".$config['photo']['photo_static'][$type]['height']." px (".$config['photo']['photo_static'][$type]['img_type'].")" ?></strong>
                        <div class="custom-file my-custom-file d-none">
                            <input type="file" class="custom-file-input" name="file" id="file">
                            <label class="custom-file-label" for="file">Chọn file</label>
                        </div>
                    </div>
                <?php } ?>
                <?php if($config['photo']['photo_static'][$type]['position'] && file_exists(UPLOAD_PHOTO.$item['photo']) && $item['photo']) { ?>
                    <div class="form-group">
                        <label>Vị trí đóng dấu:</label>
                        <div class="watermarker"><div class="watermarker-area"><img src="" id="watermarker-icon"></div></div>
                        <input type="hidden" name="data[posleft]" id="posleft" value="<?=($item['posleft']) ? $item['posleft'] : 10;?>"/>
                        <input type="hidden" name="data[postop]" id="postop" value="<?=($item['postop']) ? $item['postop'] : 10;?>"/>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if($config['photo']['photo_static'][$type]['background']) { ?>
                        <div class="form-group col-md-3">
                            <label for="background_repeat">Tùy chọn lặp:</label>
                            <select id="background_repeat" name="data[background_repeat]" class="form-control select2">
                                <option value="">Chọn thuộc tính</option>
                                <option <?php if($item['background_repeat']=='no-repeat') echo 'selected="selected"' ?> value="no-repeat">Không lặp lại</option>
                                <option <?php if($item['background_repeat']=='repeat') echo 'selected="selected"' ?> value="repeat">Lặp lại</option>
                                <option <?php if($item['background_repeat']=='repeat-x') echo 'selected="selected"' ?> value="repeat-x">Lặp lại theo chiều ngang</option>
                                <option <?php if($item['background_repeat']=='repeat-y') echo 'selected="selected"' ?> value="repeat-y">Lặp lại theo chiều dọc</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="background_size">Kích thước:</label>
                            <select id="background_size" name="data[background_size]" class="form-control select2">
                                <option value="">Chọn thuộc tính</option>
                                <option <?php if($item['background_size']=='auto') echo 'selected="selected"' ?> value="auto">Auto</option>
                                <option <?php if($item['background_size']=='cover') echo 'selected="selected"' ?> value="cover">Cover</option>
                                <option <?php if($item['background_size']=='contain') echo 'selected="selected"' ?> value="contain">Contain</option>
                                <option <?php if($item['background_size']=='100% 100%') echo 'selected="selected"' ?> value="100% 100%">Toàn màn hình</option>
                                <option <?php if($item['background_size']=='100% auto') echo 'selected="selected"' ?> value="100% auto">Toàn màn hình theo chiều ngang</option>
                                <option <?php if($item['background_size']=='auto 100%') echo 'selected="selected"' ?> value="auto 100%">Toàn màn hình theo chiều dọc</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="background_position">Vị trí:</label>
                            <select id="background_position" name="data[background_position]" class="form-control select2">
                                <option value="">Chọn thuộc tính</option>
                                <option <?php if($item['background_position']=='left top') echo 'selected="selected"' ?> value="left top">Canh Trái - Canh Trên</option>
                                <option <?php if($item['background_position']=='left bottom') echo 'selected="selected"' ?> value="left bottom">Canh Trái - Canh Dưới</option>
                                <option <?php if($item['background_position']=='left center') echo 'selected="selected"' ?> value="left center">Canh Trái - Canh Giữa</option>
                                <option <?php if($item['background_position']=='right top') echo 'selected="selected"' ?> value="right top">Canh Phải - Canh Trên</option>
                                <option <?php if($item['background_position']=='right bottom') echo 'selected="selected"' ?> value="right bottom">Canh Phải - Canh Dưới</option>
                                <option <?php if($item['background_position']=='right center') echo 'selected="selected"' ?> value="right center">Canh Phải - Canh Giữa</option>
                                <option <?php if($item['background_position']=='center top') echo 'selected="selected"' ?> value="center top">Canh Giữa - Canh Trên</option>
                                <option <?php if($item['background_position']=='center bottom') echo 'selected="selected"' ?> value="center bottom">Canh Giữa - Canh Dưới</option>
                                <option <?php if($item['background_position']=='center center') echo 'selected="selected"' ?> value="center center">Canh Giữa - Canh Giữa</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="background_attachment">Cố định:</label>
                            <select class="form-control" name="data[background_attachment]" id="background_attachment">
                                <option <?=($item['background_attachment']=='')?"selected":""?> value="">Không cố định</option>
                                <option <?=($item['background_attachment']=='fixed')?"selected":""?> value="fixed">Cố định</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mau">Màu sắc:</label>
                            <input type="text" class="form-control jscolor" name="data[mau]" id="mau" maxlength="7" value="<?=($item['mau'])?$item['mau']:'#000000'?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="loaihienthi">Loại hiển thị:</label>
                            <select class="form-control" name="data[loaihienthi]" id="loaihienthi">
                                <option value="0">Chọn tình trạng</option>
                                <option <?=($item['loaihienthi']==1)?"selected":""?> value="1">Hình nền</option>
                                <option <?=($item['loaihienthi']==0)?"selected":""?> value="0">Màu sắc</option>
                            </select>
                        </div>
                    <?php } ?>
                    <?php if($config['photo']['photo_static'][$type]['link']) { ?>
                        <div class="form-group col-md-6">
                            <label for="link">Link:</label>
                            <input type="text" class="form-control" name="data[link]" id="link" placeholder="Link" value="<?=$item['link']?>">
                        </div>
                    <?php } ?>
                    <?php if($config['photo']['photo_static'][$type]['video']) { ?>
                        <div class="form-group col-md-6">
                            <label for="link_video">Video:</label>
                            <input type="text" class="form-control" name="data[link_video]" id="link_video" placeholder="Video" value="<?=$item['link_video']?>">
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Hiển thị:</label>
                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                        <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked':''?>>
                        <label for="hienthi-checkbox" class="custom-control-label"></label>
                    </div>
                </div>
                <?php if($config['photo']['photo_static'][$type]['tieude'] || $config['photo']['photo_static'][$type]['mota'] || $config['photo']['photo_static'][$type]['noidung']) { ?>
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                                <?php foreach($config['website']['lang'] as $k => $v) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?=($k=='vi')?'active':''?>" id="tabs-lang" data-toggle="pill" href="#tabs-lang-<?=$k?>" role="tab" aria-controls="tabs-lang-<?=$k?>" aria-selected="true"><?=$v?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                                <?php foreach($config['website']['lang'] as $k => $v) { ?>
                                    <div class="tab-pane fade show <?=($k=='vi')?'active':''?>" id="tabs-lang-<?=$k?>" role="tabpanel" aria-labelledby="tabs-lang">
                                        <?php if($config['photo']['photo_static'][$type]['tieude']) { ?>
                                            <div class="form-group">
                                                <label for="ten<?=$k?>">Tiêu đề (<?=$k?>):</label>
                                                <input type="text" class="form-control" name="data[ten<?=$k?>]" id="ten<?=$k?>" placeholder="Tiêu đề (<?=$k?>)" value="<?=$item['ten'.$k]?>">
                                            </div>
                                        <?php } ?>
                                        <?php if($config['photo']['photo_static'][$type]['mota']) { ?>
                                            <div class="form-group">
                                                <label for="mota<?=$k?>">Mô tả (<?=$k?>):</label>
                                                <textarea class="form-control <?=($config['photo']['photo_static'][$type]['mota_cke'])?'form-control-ckeditor':''?>" name="data[mota<?=$k?>]" id="mota<?=$k?>" rows="5" placeholder="Mô tả (<?=$k?>)"><?=htmlspecialchars_decode($item['mota'.$k])?></textarea>
                                            </div>
                                        <?php } ?>
                                        <?php if($config['photo']['photo_static'][$type]['noidung']) { ?>
                                            <div class="form-group">
                                                <label for="noidung<?=$k?>">Nội dung (<?=$k?>):</label>
                                                <textarea class="form-control <?=($config['photo']['photo_static'][$type]['noidung_cke'])?'form-control-ckeditor':''?>" name="data[noidung<?=$k?>]" id="noidung<?=$k?>" rows="5" placeholder="Nội dung (<?=$k?>)"><?=htmlspecialchars_decode($item['noidung'.$k])?></textarea>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
        </div>
    </form>
</section>