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

		$str = '<select id="id_item" name="data[id_item]" data-level="2" data-type="'.$type.'" data-table="table_news_sub" data-child="id_sub" class="form-control select2 select-category"><option value="">Chọn danh mục</option>';
		foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['id_item']) $selected = "selected";
            else $selected = "";

            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';

		return $str;
	}
    
	function get_main_sub()
	{
		global $d, $type;

        $id_list = htmlspecialchars($_REQUEST['id_list']);
        $id_cat = htmlspecialchars($_REQUEST['id_cat']);
        $id_item = htmlspecialchars($_REQUEST['id_item']);
        $row = $d->rawQuery("select tenvi, id from table_news_sub where id_list = ? and id_cat = ? and id_item = ? and type = ? order by stt,id desc",array($id_list,$id_cat,$id_item,$type));

		$str = '<select id="id_sub" name="data[id_sub]" class="form-control select2 select-category"><option value="">Chọn danh mục</option>';
		foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['id_sub']) $selected = "selected";
            else $selected = "";

            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';

		return $str;
	}

	function get_tags($id="")
    {
        global $d, $type;

        if($id)
        {
            $temps = $d->rawQueryOne("select id_tags from table_news where id = ? and type = ?",array($id,$type));
            $arr_tags = explode(',', $temps['id_tags']);
            
            for($i=0;$i<count($arr_tags);$i++) $temp[$i]=$arr_tags[$i];
        }

        $row_tags = $d->rawQuery("select tenvi, id from table_tags where type = ? order by stt,id desc",array($type));

        $str = '<select id="tags_group" name="tags_group[]" class="select multiselect" multiple="multiple" >';
        for($i=0;$i<count($row_tags);$i++)
        {
            if($temp)
            {   
                if(in_array($row_tags[$i]['id'],$temp)) $selected = 'selected="selected"';
                else $selected = '';
            }
            $str .= '<option value="'.$row_tags[$i]["id"].'" '.$selected.' /> '.$row_tags[$i]["tenvi"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

	if($act=="add") $labelAct = "Thêm mới";
	else if($act=="edit") $labelAct = "Chỉnh sửa";
	else if($act=="copy")  $labelAct = "Sao chép";

	$linkMan = "index.php?com=news&act=man&type=".$type."&p=".$curPage;
	if($act=='add') $linkFilter = "index.php?com=news&act=add&type=".$type."&p=".$curPage;
	else if($act=='edit') $linkFilter = "index.php?com=news&act=edit&type=".$type."&p=".$curPage."&id=".$id;
    if($act=="copy") $linkSave = "index.php?com=news&act=save_copy&type=".$type."&p=".$curPage;
    else $linkSave = "index.php?com=news&act=save&type=".$type."&p=".$curPage;

    /* Check cols */
    foreach($config['news'][$type]['gallery'] as $key => $value)
    {
        if($key==$type)
        {
            $flagGallery=true;
            break;
        }
    }

    if($config['news'][$type]['dropdown'] || $config['news'][$type]['tags'] || $config['news'][$type]['images'] || $flagGallery)
    {
        $colLeft = "col-xl-8";
        $colRight = "col-xl-4";
    }
    else
    {
        $colLeft = "col-12";
        $colRight = "d-none";   
    }
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?=$labelAct?> <?=$config['news'][$type]['title_main']?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?=$linkSave?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here"><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?=$linkMan?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>
        <div class="row">
            <div class="<?=$colLeft?>">
                <?php
                    if($config['news'][$type]['slug'])
                    {
                        $slugchange = ($act=='edit') ? 1 : 0;
                        include TEMPLATE."slug.php";
                    }
                ?>
                <div class="card card-primary card-outline text-sm">
                    <div class="card-header">
                        <h3 class="card-title">Nội dung <?=$config['news'][$type]['title_main']?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
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
                                            <?php if($config['news'][$type]['mota']) { ?>
                                                <div class="form-group">
                                                    <label for="mota<?=$k?>">Mô tả (<?=$k?>):</label>
                                                    <textarea class="form-control for-seo <?=($config['news'][$type]['mota_cke'])?'form-control-ckeditor':''?>" name="data[mota<?=$k?>]" id="mota<?=$k?>" rows="5" placeholder="Mô tả (<?=$k?>)"><?=htmlspecialchars_decode($item['mota'.$k])?></textarea>
                                                </div>
                                            <?php } ?>
                                            <?php if($config['news'][$type]['noidung']) { ?>
                                                <div class="form-group">
                                                    <label for="noidung<?=$k?>">Nội dung (<?=$k?>):</label>
                                                    <textarea class="form-control for-seo <?=($config['news'][$type]['noidung_cke'])?'form-control-ckeditor':''?>" name="data[noidung<?=$k?>]" id="noidung<?=$k?>" rows="5" placeholder="Nội dung (<?=$k?>)"><?=htmlspecialchars_decode($item['noidung'.$k])?></textarea>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="<?=$colRight?>">
                <?php if($config['news'][$type]['dropdown'] || $config['news'][$type]['tags']) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Danh mục <?=$config['news'][$type]['title_main']?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group-category row">
                                <?php if($config['news'][$type]['dropdown']) { ?>
                                    <?php if($config['news'][$type]['list']) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                                            <?=get_main_list()?>
                                        </div>
                                    <?php } ?>
                                    <?php if($config['news'][$type]['cat']) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_cat">Danh mục cấp 2:</label>
                                            <?=get_main_cat()?>
                                        </div>
                                    <?php } ?>
                                    <?php if($config['news'][$type]['item']) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_item">Danh mục cấp 3:</label>
                                            <?=get_main_item()?>
                                        </div>
                                    <?php } ?>
                                    <?php if($config['news'][$type]['sub']) { ?>
                                        <div class="form-group col-xl-6 col-sm-4">
                                            <label class="d-block" for="id_sub">Danh mục cấp 4:</label>
                                            <?=get_main_sub()?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if($config['news'][$type]['tags']) { ?>
                                    <div class="form-group col-xl-6 col-sm-4">
                                        <label class="d-block" for="id_tags">Danh mục tags:</label>
                                        <?=get_tags($item['id'])?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if($config['news'][$type]['images']) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Hình ảnh <?=$config['news'][$type]['title_main']?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $photoDetail = UPLOAD_NEWS.$item['photo'];
                                $dimension = "Width: ".$config['news'][$type]['width']." px - Height: ".$config['news'][$type]['height']." px (".$config['news'][$type]['img_type'].")";
                                include TEMPLATE."image.php";
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if($flagGallery) { ?>
                    <div class="card card-primary card-outline text-sm">
                        <div class="card-header">
                            <h3 class="card-title">Bộ sưu tập <?=$config['news'][$type]['title_main']?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="filer-gallery" class="label-filer-gallery mb-3">Album hình: (<?=$config['news'][$type]['gallery'][$key]['img_type_photo']?>)</label>
                                <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
                                <input type="hidden" class="col-filer" value="col-xl-6 col-sm-3 col-6">
                                <input type="hidden" class="act-filer" value="man">
                            </div>
                            <?php if(count($gallery)) { ?>
                                <div class="form-group form-group-gallery">
                                    <label class="label-filer">Album hiện tại:</label>
                                    <div class="action-filer mb-3">
                                        <a class="btn btn-sm bg-gradient-primary text-white check-all-filer mr-1"><i class="far fa-square mr-2"></i>Chọn tất cả</a>
                                        <button type="button" class="btn btn-sm bg-gradient-success text-white sort-filer mr-1"><i class="fas fa-random mr-2"></i>Sắp xếp</button>
                                        <a class="btn btn-sm bg-gradient-danger text-white delete-all-filer" data-folder="news"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
                                    </div>
                                    <div class="alert my-alert alert-sort-filer alert-info text-sm text-white bg-gradient-info"><i class="fas fa-info-circle mr-2"></i>Có thể chọn nhiều hình để di chuyển</div>
                                    <div class="jFiler-items my-jFiler-items jFiler-row">
                                        <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
                                            <?php foreach($gallery as $v) $func->galleryFiler($v['stt'],$v['id'],$v['photo'],$v['tenvi'],'news','col-xl-6 col-sm-3 col-6'); ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin <?=$config['news'][$type]['title_main']?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
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
                <?php if($config['news'][$type]['file']) { ?>
                    <div class="form-group">
                        <label class="change-file mb-1 mr-2" for="file-taptin">
                            <p>Upload tập tin:</p>
                            <strong class="ml-2">
                                <span class="btn btn-sm bg-gradient-success"><i class="fas fa-file-upload mr-2"></i>Chọn tập tin</span>
                                <div><b class="text-sm text-split"></b></div>
                            </strong>
                        </label>
                        <strong class="d-block mt-2 mb-2 text-sm"><?php echo $config['news'][$type]['file_type']; ?></strong>
                        <div class="custom-file my-custom-file d-none">
                            <input type="file" class="custom-file-input" name="file-taptin" id="file-taptin">
                            <label class="custom-file-label" for="file-taptin">Chọn file</label>
                        </div>
                        <?php if($item['taptin']) { ?>
                            <a class="btn btn-sm bg-gradient-primary text-white d-inline-block align-middle p-2 rounded mb-1" href="<?=UPLOAD_FILE.$item['taptin']?>" title="Download tập tin hiện tại"><i class="fas fa-download mr-2"></i>Download tập tin hiện tại</a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="row">
                    <?php if($config['news'][$type]['link']) { ?>
                        <div class="form-group col-md-6">
                            <label for="link">Link:</label>
                            <input type="text" class="form-control" name="data[link]" id="link" placeholder="Link" value="<?=$item['link']?>">
                        </div>
                    <?php } ?>
                    <?php if($config['news'][$type]['video']) { ?>
                        <div class="form-group col-md-6">
                            <label for="link_video">Video:</label>
                            <input type="text" class="form-control" name="data[link_video]" id="link_video" onchange="youtubePreview(this.value,'#loadVideo');" placeholder="Video" value="<?=$item['link_video']?>">
                        </div>
                    <?php } ?>
                </div>
                <?php if($config['news'][$type]['attribute']) { $addAttribute = true; ?>
                    <div class="form-group form-group-attribute">
                        <a class="btn btn-sm bg-gradient-success text-white mb-2 add-attribute"><i class="fas fa-plus mr-2"></i>Thêm thuộc tính</a>
                        <div class="grid-attribute row">
                            <?php foreach($attributes as $kattr => $vattr) { ?>
                                <div class="item-attribute item-attribute-<?=$vattr['id']?> col-xl-3 col-sm-4">
                                    <div class="alert my-alert alert-info">
                                        <div class="info-attribute">
                                            <label class="label-attribute">
                                                <strong>STT:</strong>
                                                <input type="number" class="form-control form-control-sm" name="attribute[stt][]" placeholder="STT" value="<?=$vattr['stt']?>" required>
                                            </label>
                                            <div class="info-attribute">
                                                <?php foreach($config['website']['lang'] as $k => $v) { ?>
                                                    <div class="lang-attribute">
                                                        <input type="text" class="form-control form-control-sm title-attribute" name="attribute[tieude<?=$k?>][]" placeholder="Tiêu đề (<?=$v?>)" value="<?=$vattr['tieude'.$k]?>" <?=($k=='vi')?'required':''?>>
                                                        <input type="text" class="form-control form-control-sm value-attribute" name="attribute[giatri<?=$k?>][]" placeholder="Giá trị (<?=$v?>)" value="<?=$vattr['giatri'.$k]?>" <?=($k=='vi')?'required':''?>>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <a class="delete-attribute" data-id="<?=$vattr['id']?>"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if($config['news'][$type]['seo']) { ?>
            <div class="card card-primary card-outline text-sm">
                <div class="card-header">
                    <h3 class="card-title">Nội dung SEO</h3>
                    <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
                </div>
                <div class="card-body">
                    <?php
                        $seo = $func->get_seo($id,$com,'man',$type);
                        include TEMPLATE."seo.php";
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="submit" class="btn btn-sm bg-gradient-success submit-check" name="save-here"><i class="far fa-save mr-2"></i>Lưu tại trang</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?=$linkMan?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?=$item['id']?>">
        </div>
    </form>
</section>