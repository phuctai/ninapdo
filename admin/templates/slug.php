<div class="card card-primary card-outline text-sm">
    <div class="card-header">
        <h3 class="card-title">Đường dẫn</h3>
        <span class="pl-2 text-danger">(Vui lòng không nhập trùng tiêu đề)</span>
    </div>
    <div class="card-body card-slug">
        <?php if($slugchange) { ?>
            <div class="form-group mb-2">
                <label for="slugchange-checkbox" class="d-inline-block align-middle text-info mb-0 mr-2">Thay đổi đường dẫn theo tiêu đề mới:</label>
                <div class="custom-control custom-checkbox d-inline-block align-middle">
                    <input type="checkbox" class="custom-control-input slugchange-checkbox" name="slugchange" id="slugchange-checkbox" value="1">
                    <label for="slugchange-checkbox" class="custom-control-label"></label>
                </div>
            </div>
        <?php } ?>

        <input type="hidden" class="slug-hidden" data-com="<?=$com?>" data-act="<?=$act?>" data-id="<?=$id?>" data-preview="0">

        <?php if($config['website']['slug']['lang-active']) { ?>
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                        <?php foreach($config['website']['slug']['lang'] as $k => $v) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?=($k=='vi')?'active':''?>" id="tabs-lang" data-toggle="pill" href="#tabs-sluglang-<?=$k?>" role="tab" aria-controls="tabs-sluglang-<?=$k?>" aria-selected="true"><?=$v?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                        <?php foreach($config['website']['slug']['lang'] as $k => $v) { ?>
                            <div class="tab-pane fade show <?=($k=='vi')?'active':''?>" id="tabs-sluglang-<?=$k?>" role="tabpanel" aria-labelledby="tabs-lang">
                                <div class="form-gourp mb-0">
                                    <label class="d-block">Đường dẫn mẫu (<?=$k?>):<span class="pl-2 font-weight-normal" id="slugurlpreview<?=$k?>"><?=$config_base?><strong class="text-info"><?=$item['tenkhongdau'.$k]?></strong></span></label>
                                    <input type="text" class="form-control check-slug slugchange" name="slug<?=$k?>" id="slug<?=$k?>" placeholder="Đường dẫn (<?=$k?>)" data-self="1" value="<?=(!$copy)?$item['tenkhongdau'.$k]:''?>">
                                    <p class="alert-slug<?=$k?> text-warning d-none mt-2 mb-0" id="alert-slug-warning<?=$k?>">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>Đường dẫn đã tồn tại. Đường dẫn truy cập mục này có thể bị trùng lặp.</span>
                                    </p>
                                    <p class="alert-slug<?=$k?> text-success d-none mt-2 mb-0" id="alert-slug-success<?=$k?>">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        <span>Đường dẫn hợp lệ.</span>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } else { $k = "vi"; ?>
            <div class="form-gourp mb-0">
                <label class="d-block">Đường dẫn mẫu:<span class="pl-2 font-weight-normal" id="slugurlpreview<?=$k?>"><?=$config_base?><strong class="text-info"><?=$item['tenkhongdau'.$k]?></strong></span></label>
                <input type="text" class="form-control check-slug slugchange" name="slug<?=$k?>" id="slug<?=$k?>" placeholder="Đường dẫn" data-self="1" value="<?=(!$copy)?$item['tenkhongdau'.$k]:''?>">
                <p class="alert-slug<?=$k?> text-warning d-none mt-2 mb-0" id="alert-slug-warning<?=$k?>">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <span>Đường dẫn đã tồn tại. Đường dẫn truy cập mục này có thể bị trùng lặp.</span>
                </p>
                <p class="alert-slug<?=$k?> text-success d-none mt-2 mb-0" id="alert-slug-success<?=$k?>">
                    <i class="fas fa-check-circle mr-1"></i>
                    <span>Đường dẫn hợp lệ.</span>
                </p>
            </div>
        <?php } ?>
    </div>
</div>