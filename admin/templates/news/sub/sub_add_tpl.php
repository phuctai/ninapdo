<?php
	function get_main_list()
    {
        global $d, $type;

        $row = $d->rawQuery("select tenvi, id from table_news_list where type = ? order by stt,id desc",array($type));

        $str = '<select id="id_list" name="data[id_list]" data-level="0" data-type="'.$type.'" data-table="table_news_cat" data-child="id_cat" class="form-control select2 select-category"><option value="">Chọn danh mục</option>';
        foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['id_list']) $selected = "selected";
            else $selected = "";

            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

	function get_main_cat()
	{
		global $d, $type;

        $id_list = htmlspecialchars($_REQUEST['id_list']);
        $row = $d->rawQuery("select tenvi, id from table_news_cat where id_list = ? and type = ? order by stt,id desc",array($id_list,$type));

		$str = '<select id="id_cat" name="data[id_cat]" data-level="1" data-type="'.$type.'" data-table="table_news_item" data-child="id_item" class="form-control select2 select-category"><option value="">Chọn danh mục</option>';
		foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['id_cat']) $selected = "selected";
            else $selected = "";

            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';

		return $str;
	}

	function get_main_item()
	{
		global $d, $type;

        $id_list = htmlspecialchars($_REQUEST['id_list']);
        $id_cat = htmlspecialchars($_REQUEST['id_cat']);
        $row = $d->rawQuery("select tenvi, id from table_news_item where id_list = ? and id_cat = ? and type = ? order by stt,id desc",array($id_list,$id_cat,$type));

		$str = '<select id="id_item" name="data[id_item]" class="form-control select2"><option value="">Chọn danh mục</option>';
		foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['id_item']) $selected = "selected";
            else $selected = "";

            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';
        
		return $str;
	}

	$linkMan = "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage;
	if($act=='add_sub') $linkFilter = "index.php?com=news&act=add_sub&type=".$type."&p=".$curPage;
	else if($act=='edit_sub') $linkFilter = "index.php?com=news&act=edit_sub&type=".$type."&p=".$curPage."&id=".$id;
    $linkSave = "index.php?com=news&act=save_sub&type=".$type."&p=".$curPage;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Chi tiết <?=$config['news'][$type]['title_main_sub']?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?=$linkSave?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?=$linkMan?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title"><?=($act=="edit_item")?"Cập nhật":"Thêm mới";?> <?=$config['news'][$type]['title_main_sub']?></h3>
            </div>
            <div class="card-body">
                <div class="form-group-category row">
                    <div class="form-group col-md-3 col-sm-4">
                        <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                        <?=get_main_list()?>
                    </div>
                    <div class="form-group col-md-3 col-sm-4">
                        <label class="d-block" for="id_cat">Danh mục cấp 2:</label>
                        <?=get_main_cat()?>
                    </div>
                    <div class="form-group col-md-3 col-sm-4">
                        <label class="d-block" for="id_item">Danh mục cấp 3:</label>
                        <?=get_main_item()?>
                    </div>
                </div>
                <?php if($config['news'][$type]['images_sub']) { ?>
                    <div class="form-group">
                        <label class="change-photo" for="file">
                            <p>Upload hình ảnh:</p>
                            <div class="rounded">
                                <img class="rounded img-upload" src="<?=UPLOAD_NEWS.$item['photo']?>" onerror="src='assets/images/noimage.png'" alt="Alt Photo"/>
                                <strong>
                                    <b class="text-sm text-split"></b>
                                    <span class="btn btn-sm bg-gradient-success"><i class="fas fa-camera mr-2"></i>Chọn hình</span>
                                </strong>
                            </div>
                        </label>
                        <strong class="d-block mt-2 mb-2 text-sm"><?php echo "Width: ".$config['news'][$type]['width_sub']." px - Height: ".$config['news'][$type]['height_sub']." px (".$config['news'][$type]['img_type_sub'].")" ?></strong>
                        <div class="custom-file my-custom-file d-none">
                            <input type="file" class="custom-file-input" name="file" id="file">
                            <label class="custom-file-label" for="file">Chọn file</label>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="hienthi" class="d-inline-block align-middle mb-0 mr-2">Hiển thị:</label>
                    <div class="custom-control custom-checkbox d-inline-block align-middle">
                        <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]" id="hienthi-checkbox" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked':''?>>
                        <label for="hienthi-checkbox" class="custom-control-label"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="<?=isset($item['stt'])?$item['stt']:1?>">
                </div>
                <?php
                    if($config['news'][$type]['slug_sub'])
                    {
                        $slugchange = ($act=='edit_sub') ? 1 : 0;
                        include TEMPLATE."slug.php";
                    }
                ?>
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
                    <div class="card-body card-article">
                        <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                            <?php foreach($config['website']['lang'] as $k => $v) { ?>
                                <div class="tab-pane fade show <?=($k=='vi')?'active':''?>" id="tabs-lang-<?=$k?>" role="tabpanel" aria-labelledby="tabs-lang">
                                    <div class="form-group">
                                        <label for="ten<?=$k?>">Tiêu đề (<?=$k?>):</label>
                                        <input type="text" class="form-control for-seo" name="data[ten<?=$k?>]" id="ten<?=$k?>" placeholder="Tiêu đề (<?=$k?>)" value="<?=$item['ten'.$k]?>" <?=($k=='vi')?'required':''?>>
                                    </div>
                                    <?php if($config['news'][$type]['mota_sub']) { ?>
                                        <div class="form-group">
                                            <label for="mota<?=$k?>">Mô tả (<?=$k?>):</label>
                                            <textarea class="form-control for-seo <?=($config['news'][$type]['mota_cke_sub'])?'form-control-ckeditor':''?>" name="data[mota<?=$k?>]" id="mota<?=$k?>" rows="5" placeholder="Mô tả (<?=$k?>)"><?=htmlspecialchars_decode($item['mota'.$k])?></textarea>
                                        </div>
                                    <?php } ?>
                                    <?php if($config['news'][$type]['noidung_sub']) { ?>
                                        <div class="form-group">
                                            <label for="noidung<?=$k?>">Nội dung (<?=$k?>):</label>
                                            <textarea class="form-control for-seo <?=($config['news'][$type]['noidung_cke_sub'])?'form-control-ckeditor':''?>" name="data[noidung<?=$k?>]" id="noidung<?=$k?>" rows="5" placeholder="Nội dung (<?=$k?>)"><?=htmlspecialchars_decode($item['noidung'.$k])?></textarea>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($config['news'][$type]['seo_sub']) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung SEO</h3>
                    <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
                </div>
                <div class="card-body">
                    <?php
                        $seo = get_seo($id,$com,'man_sub',$type);
                        include TEMPLATE."seo.php";
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?=$linkMan?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?=$item['id']?>">
        </div>
    </form>
</section>