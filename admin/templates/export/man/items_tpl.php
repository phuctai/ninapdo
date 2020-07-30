<?php
    function get_main_list()
    {
        global $d, $type;

        $row = $d->rawQuery("select tenvi, id from #_product_list where type = ? order by stt,id desc",array($type));

        $str = '<select id="id_list" name="id_list" data-level="0" data-type="'.$type.'" data-table="#_product_cat" data-child="id_cat" class="form-control select2 select-category"><option value="0">Chọn danh mục</option>';
        foreach($row as $v)
        {
            $str .= '<option value='.$v["id"].'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

    function get_main_cat()
    {
        global $type;

        $str='<select id="id_cat" name="id_cat" data-level="1" data-type="'.$type.'" data-table="#_product_item" data-child="id_item" class="form-control select2 select-category"><option value="0">Chọn danh mục</option></select>';
        return $str;
    }

    function get_main_item()
    {
        global $type;

        $str='<select id="id_item" name="id_item" data-level="2" data-type="'.$type.'" data-table="#_product_sub" data-child="id_sub" class="form-control select2 select-category"><option value="0">Chọn danh mục</option></select>';
        return $str;
    }
    
    function get_main_sub()
    {
        $str='<select id="id_sub" name="id_sub" class="form-control select2 select-category"><option value="0">Chọn danh mục</option></select>';
        return $str;
    }

	$linkExportExcel = "index.php?com=export&act=exportExcel&type=".$type;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Export Excel</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?=$linkExportExcel?>" enctype="multipart/form-data">
        <div class="card card-primary card-outline text-sm mb-0">
            <div class="card-header">
                <h3 class="card-title">Export danh sách dữ liệu</h3>
            </div>
            <div class="card-body">
                <?php if($config['export']['category']) { ?>
                    <div class="form-group-category row">
                        <?php if($config['product'][$type]['list']) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_list">Danh mục cấp 1:</label>
                                <?=get_main_list()?>
                            </div>
                        <?php } ?>
                        <?php if($config['product'][$type]['cat']) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_cat">Danh mục cấp 2:</label>
                                <?=get_main_cat()?>
                            </div>
                        <?php } ?>
                        <?php if($config['product'][$type]['item']) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_item">Danh mục cấp 3:</label>
                                <?=get_main_item()?>
                            </div>
                        <?php } ?>
                        <?php if($config['product'][$type]['sub']) { ?>
                            <div class="form-group col-md-3 col-sm-4">
                                <label class="d-block" for="id_sub">Danh mục cấp 4:</label>
                                <?=get_main_sub()?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="alert my-alert alert-info mb-0" role="alert">Xuất danh sách sản phẩm thành tập tin excel</div>
                <?php } ?>
            </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-success" name="exportExcel"><i class="fas fa-file-export mr-2"></i>Export</button>
        </div>
    </form>
</section>