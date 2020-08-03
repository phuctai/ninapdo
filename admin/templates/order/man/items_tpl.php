<?php
    function getStatus()
    {
        global $d;

        $row = $d->rawQuery("select * from #_status order by id");

        $str = '<select id="tinhtrang" name="tinhtrang" class="form-control text-sm"><option value="0">Chọn tình trạng</option>';
        foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['tinhtrang']) $selected = "selected";
            else $selected = "";

            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["trangthai"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

    function getPayments()
    {
        global $d;

        $row = $d->rawQuery("select * from #_news where type='hinh-thuc-thanh-toan' order by stt,id desc");

        $str = '<select id="httt" name="httt" class="form-control text-sm"><option value="0">Chọn hình thức thanh toán</option>';
        foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['httt']) $selected = "selected";
            else $selected = "";
            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["tenvi"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

    function getCity()
    {
        global $d;

        $row = $d->rawQuery("select ten,id from #_city order by id asc");

        $str = '<select id="city" name="id_city" data-level="0" data-table="#_district" data-child="district" class="form-control select2 select-place"><option value="0">Chọn danh mục</option>';
        foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['city']) $selected = "selected";
            else $selected = "";
            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["ten"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

    function getDistrict()
    {
        global $d;

        $id_city = htmlspecialchars($_REQUEST['city']);
        $row = $d->rawQuery("select ten,id from #_district where id_city = ? order by id asc",array($id_city));

        $str = '<select id="district" name="id_district" data-level="1" data-type="'.$type.'" data-table="#_wards" data-child="wards" class="form-control select2 select-place"><option value="0">Chọn danh mục</option>';
        foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['district']) $selected = "selected";
            else $selected = "";
            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["ten"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }
    
    function getWards()
    {
        global $d;

        $id_city = htmlspecialchars($_REQUEST['city']);
        $id_district = htmlspecialchars($_REQUEST['district']);
        $row = $d->rawQuery("select ten,id from #_wards where id_city = ? and id_district = ? order by id asc",array($id_city,$id_district));

        $str = '<select id="wards" name="id_wards" class="form-control select2"><option value="0">Chọn danh mục</option>';
        foreach($row as $v)
        {
            if($v["id"] == (int)$_REQUEST['wards']) $selected = "selected";
            else $selected = "";
            $str .= '<option value='.$v["id"].' '.$selected.'>'.$v["ten"].'</option>';
        }
        $str .= '</select>';

        return $str;
    }

	$linkMan = $linkFilter = "index.php?com=order&act=man&p=".$curPage;
    $linkEdit = "index.php?com=order&act=edit&p=".$curPage;
    $linkDelete = "index.php?com=order&act=delete&p=".$curPage;
    $linkExcel = "index.php?com=excelAll";
    $linkWord = "index.php?com=wordAll";
    $arrStatus = array("text-primary","text-info","text-warning","text-success","text-danger");
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Quản lý đơn hàng</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-bag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-primary font-weight-bold text-capitalize text-sm">Mới đặt</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?=$allMoidat?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?=number_format($totalMoidat, 0, ',', '.')?> vnđ</span></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-info font-weight-bold text-capitalize text-sm">Đã xác nhận</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?=$allDaxacnhan?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?=number_format($totalDaxacnhan, 0, ',', '.')?> vnđ</span></p>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-success font-weight-bold text-capitalize text-sm">Đã giao</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?=$allDagiao?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?=number_format($totalDagiao, 0, ',', '.')?> vnđ</span></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-danger font-weight-bold text-capitalize text-sm">Đã hủy</span>
                    <p class="info-box-text text-sm mb-0">Số lượng: <span class="text-danger font-weight-bold"><?=$allDahuy?></span></p>
                    <p class="info-box-text text-sm mb-0">Tổng giá: <span class="text-danger font-weight-bold"><?=number_format($totalDahuy, 0, ',', '.')?> vnđ</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-sm sticky-top">
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?=$linkDelete?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
        <div class="form-inline form-search d-inline-block align-middle ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar text-sm" type="search" id="keyword" placeholder="Tìm kiếm" aria-label="Tìm kiếm" value="<?=$_GET['keyword']?>" onkeypress="doEnter(event,'keyword','<?=$linkMan?>')">
                <div class="input-group-append bg-primary rounded-right">
                    <button class="btn btn-navbar text-white" type="button" onclick="onSearch('keyword','<?=$linkMan?>')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php if($config['order']['search']) { ?>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Tìm kiếm đơn hàng</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-3 col-sm-3">
                    <label>Ngày đặt:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control float-right" name="ngaydat" id="ngaydat" value="<?=$_GET['ngaydat']?>" readonly>
                    </div>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <label>Tình trạng:</label>
                    <?=getStatus()?>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <label>Hình thức thanh toán:</label>
                    <?=getPayments()?>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <label>Tỉnh thành:</label>
                    <?=getCity()?>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <label>Quận huyện:</label>
                    <?=getDistrict()?>
                </div>
                <div class="form-group col-md-3 col-sm-3">
                    <label>Phường xã:</label>
                    <?=getWards()?>
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label>Khoảng giá:</label>
                    <input type="text" class="primary" id="khoanggia" name="khoanggia">
                </div>
                <div class="form-group text-center mt-2 mb-0 col-12">
                    <a class="btn btn-sm bg-gradient-success text-white" onclick="actionOrder('<?=$linkFilter?>')" title="Tìm kiếm"><i class="fas fa-search mr-1"></i>Tìm kiếm</a>
                    <a class="btn btn-sm bg-gradient-danger text-white ml-1" href="<?=$linkMan?>" title="Hủy lọc"><i class="fas fa-times mr-1"></i>Hủy lọc</a>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="card card-primary card-outline text-sm mb-0">
        <div class="card-header">
            <h3 class="card-title card-title-order d-inline-block align-middle float-none">Danh sách đơn hàng</h3>
            <?php if($config['order']['excelall']) { ?>
                <a class="btn btn-sm bg-gradient-success btn-export-excel btn-sm d-inline-block align-middle ml-2 text-white" onclick="actionOrder('<?=$linkExcel?>')" title="Xuất file Excel"><i class="far fa-file-excel mr-1"></i>Xuất file Excel</a>
            <?php } ?>
            <?php if($config['order']['wordall']) { ?>
                <a class="btn btn-sm bg-gradient-primary btn-export-word btn-sm d-inline-block align-middle ml-2 text-white" onclick="actionOrder('<?=$linkWord?>')" title="Xuất file Word"><i class="far fa-file-word mr-1"></i>Xuất file Word</a>
            <?php } ?>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">
                            <div class="custom-control custom-checkbox my-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectall-checkbox">
                                <label for="selectall-checkbox" class="custom-control-label"></label>
                            </div>
                        </th>
                        <?php /* ?><th class="align-middle text-center" width="10%">STT</th><?php */ ?>
                        <th class="align-middle">Mã đơn hàng</th>
                        <th class="align-middle" style="width:15%">Họ tên</th>
                        <th class="align-middle">Ngày đặt</th>
                        <th class="align-middle">Hình thức thanh toán</th>
                        <th class="align-middle">Tổng giá</th>
                        <th class="align-middle">Tình trạng</th>
                        <?php if($config['order']['excel'] || $config['order']['word']) { ?>
                            <th class="align-middle">Export</th>
                        <?php } ?>
                        <th class="align-middle text-center">Thao tác</th>
                    </tr>
                </thead>
                <?php if(empty($items)) { ?>
                    <tbody><tr><td colspan="100" class="text-center">Không có dữ liệu</td></tr></tbody>
                <?php } else { ?>
                    <tbody>
                        <?php for($i=0;$i<count($items);$i++) { ?>
                            <tr>
                                <td class="align-middle">
                                    <div class="custom-control custom-checkbox my-checkbox">
                                        <input type="checkbox" class="custom-control-input select-checkbox" id="select-checkbox-<?=$items[$i]['id']?>" value="<?=$items[$i]['id']?>">
                                        <label for="select-checkbox-<?=$items[$i]['id']?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <?php /* ?>
	                                <td class="align-middle">
	                                    <input type="number" class="form-control form-control-mini m-auto update-stt" min="0" value="<?=$items[$i]['stt']?>" data-id="<?=$items[$i]['id']?>" data-table="order">
	                                </td>
	                            <?php */ ?>
                                <td class="align-middle">
                                    <a class="text-primary" href="<?=$linkEdit?>&id=<?=$items[$i]['id']?>" title="<?=$items[$i]['madonhang']?>"><?=$items[$i]['madonhang']?></a>
                                </td>
                                <td class="align-middle">
                                    <a class="text-primary" href="<?=$linkEdit?>&id=<?=$items[$i]['id']?>" title="<?=$items[$i]['hoten']?>"><?=$items[$i]['hoten']?></a>
                                </td>
                                <td class="align-middle"><?=date("h:i:s A - d/m/Y", $items[$i]['ngaytao'])?></td>
                                <td class="align-middle">
                                    <span class="text-info"><?=$func->get_payments($items[$i]['httt'])?></span>
                                </td>
                                <td class="align-middle">
                                    <span class="text-danger font-weight-bold"><?=number_format($items[$i]['tonggia'], 0, ',', '.')?> VNĐ</span>
                                </td>
                                <td class="align-middle">
                                    <?php
                                        $id_tinhtrang = $items[$i]['tinhtrang'];
                                        $tinhtrang = $d->rawQueryOne("select trangthai from #_status where id = ?",array($id_tinhtrang));
                                    ?>
                                    <span class="<?=$arrStatus[$id_tinhtrang-1]?> text-capitalize"><?=$tinhtrang['trangthai']?></span>
                                </td>
                                <?php if($config['order']['excel'] || $config['order']['word']) { ?>
                                    <td class="align-middle text-center text-lg text-nowrap">
                                        <?php if($config['order']['excel']) { ?>
                                            <a class="text-primary mr-2" href="index.php?com=excel&id=<?=$items[$i]['id']?>" title="Xuất file excel"><i class="far fa-file-excel"></i></a>
                                        <?php } ?>
                                        <?php if($config['order']['word']) { ?>
                                            <a class="text-primary" href="index.php?com=word&id=<?=$items[$i]['id']?>" title="Xuất file word"><i class="far fa-file-word"></i></a>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                                <td class="align-middle text-center text-md text-nowrap">
                                    <a class="text-primary mr-2" href="<?=$linkEdit?>&id=<?=$items[$i]['id']?>" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                    <a class="text-danger" id="delete-item" data-url="<?=$linkDelete?>&id=<?=$items[$i]['id']?>" title="Xóa"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php if($paging) { ?>
        <div class="card-footer text-sm pb-0">
            <?=$paging?>
        </div>
    <?php } ?>
    <div class="card-footer text-sm">
        <a class="btn btn-sm bg-gradient-danger text-white" id="delete-all" data-url="<?=$linkDelete?>" title="Xóa tất cả"><i class="far fa-trash-alt mr-2"></i>Xóa tất cả</a>
    </div>
</section>

<!-- Order js -->
<script type="text/javascript">
    $(document).ready(function(){
        /* Date range picker */
        $('#ngaydat').daterangepicker({
            callback: this.render,
            autoUpdateInput: false,
            timePicker: false,
            timePickerIncrement: 30,
            locale: {
                format: 'DD/MM/YYYY'
                // format: 'DD/MM/YYYY hh:mm A'
            }
        })
        $('#ngaydat').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
        $('#ngaydat').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });

        /* rangeSlider */
        $('#khoanggia').ionRangeSlider({
            skin: "flat",
            min     : <?=($minTotal)?$minTotal:1?>,
            max     : <?=($maxTotal)?$maxTotal:1?>,
            from    : <?=($giatu)?$giatu:1?>,
            to      : <?=($giaden)?$giaden:$maxTotal?>,
            type    : 'double',
            step    : 1,
            // prefix  : 'đ ',
            postfix : ' đ',
            prettify: true,
            hasGrid : true
        })
    })
</script>