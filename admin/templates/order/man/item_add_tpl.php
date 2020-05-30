<?php
	function getStatus($status=0)
	{
		global $d;

        $row = $d->rawQuery("select * from table_status order by id");

		$str = '<select id="tinhtrang" name="data[tinhtrang]" class="form-control select2 w-auto">';
		foreach($row as $v)
		{
			if($v["id"] == (int)$status) $selected = "selected";
			else $selected = "";
			$str .= '<option value='.$v["id"].' '.$selected.'>'.$v["trangthai"].'</option>';
		}
		$str .= '</select>';
		
		return $str;
	}

	$linkMan = "index.php?com=order&act=man&p=".$curPage;
    $linkSave = "index.php?com=order&act=save&p=".$curPage;
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item"><a href="<?=$linkMan?>" title="Quản lý đơn hàng">Quản lý đơn hàng</a></li>
                <li class="breadcrumb-item active">Thông tin đơn hàng <span class="text-primary">#<?=$item['madonhang']?></span></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form class="validation-form" novalidate method="post" action="<?=$linkSave?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?=$linkMan?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin chính</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-4 col-sm-6">
					<label>Mã đơn hàng:</label>
					<p class="text-primary"><?=$item['madonhang']?></p>
				</div>
				<div class="form-group col-md-4 col-sm-6">
					<label>Hình thức thanh toán:</label>
					<p class="text-info"><?=get_payments($item['httt'])?></p>
				</div>
				<div class="form-group col-md-4 col-sm-6">
					<label>Họ tên:</label>
					<p class="font-weight-bold text-uppercase text-success"><?=$item['hoten']?></p>
				</div>
				<div class="form-group col-md-4 col-sm-6">
					<label>Điện thoại:</label>
					<p><?=$item['dienthoai']?></p>
				</div>
				<div class="form-group col-md-4 col-sm-6">
					<label>Email:</label>
					<p><?=$item['email']?></p>
				</div>
				<div class="form-group col-md-4 col-sm-6">
					<label>Địa chỉ:</label>
					<p><?=$item['diachi']?></p>
				</div>
				<?php if($config['order']['ship']) { ?>
					<div class="form-group col-md-4 col-sm-6">
						<label>Phí vận chuyển:</label>
						<p class="font-weight-bold text-danger">
							<?php if($item['phiship']) { ?>
								<?=number_format($item['phiship'], 0, ',', '.')?>đ
							<?php } else { ?>
								Không
							<?php } ?>
						</p>
					</div>
				<?php } ?>
				<?php if($config['order']['coupon']) { ?>
					<div class="form-group col-md-4 col-sm-6">
						<label>Ưu đãi:</label>
						<p class="font-weight-bold text-danger">
							<?php if($item['loaicoupon']==1) { ?>
								-<?=number_format($item['phicoupon'], 0, ',', '.')?>%
							<?php } else if($item['loaicoupon']==2) { ?>
								-<?=number_format($item['phicoupon'], 0, ',', '.')?>đ
							<?php } else { ?>
								Không
							<?php } ?>
						</p>
					</div>
				<?php } ?>
				<div class="form-group col-md-4 col-sm-6">
					<label>Ngày đặt:</label>
					<p><?=date("h:i:s A - d/m/Y", $item['ngaytao'])?></p>
				</div>
				<div class="form-group col-12">
					<label for="ghichu">Yêu cầu khác:</label>
					<textarea class="form-control" name="data[yeucaukhac]" id="yeucaukhac" rows="5" placeholder="Yêu cầu khác"><?=$item['yeucaukhac']?></textarea>
				</div>
				<div class="form-group col-12">
					<label for="tinhtrang" class="mr-2">Tình trạng:</label>
					<?=getStatus($item['tinhtrang'])?>
				</div>
				<div class="form-group col-12">
					<label for="ghichu">Ghi chú:</label>
					<textarea class="form-control" name="data[ghichu]" id="ghichu" rows="5" placeholder="Ghi chú"><?=$item['ghichu']?></textarea>
				</div>
			    <?php /* ?>
				    <div class="form-group">
	                    <label for="stt" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
	                    <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[stt]" id="stt" placeholder="Số thứ tự" value="<?=isset($item['stt'])?$item['stt']:1?>">
	                </div>
	            <?php */ ?>
            </div>
        </div>
        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Chi tiết đơn hàng</h3>
            </div>
            <div class="card-body table-responsive p-0">
	            <table class="table table-hover">
	                <thead>
	                    <tr>
	                        <th class="align-middle text-center" width="10%">STT</th>
	                        <th class="align-middle">Hình ảnh</th>
	                        <th class="align-middle" style="width:30%">Tên sản phẩm</th>
	                        <th class="align-middle text-center">Đơn giá</th>
	                        <th class="align-middle text-right">Số lượng</th>
	                        <th class="align-middle text-right">Tạm tính</th>
	                    </tr>
	                </thead>
	                <?php if(empty($chitietdonhang)) { ?>
	                    <tbody><tr><td colspan="100" class="text-center">Không có dữ liệu</td></tr></tbody>
	                <?php } else { ?>
	                    <tbody>
	                        <?php foreach($chitietdonhang as $k => $v) { ?>
	                            <tr>
	                                <td class="align-middle text-center"><?=($k+1)?></td>
	                                <td class="align-middle">
	                                    <a title="<?=$v['ten']?>"><img class="rounded img-preview" onerror="src='assets/images/noimage.png'" src="<?=UPLOAD_PRODUCT.$v['photo']?>" alt="<?=$v['ten']?>"></a>
	                                </td>
	                                <td class="align-middle">
	                                	<p class="text-primary mb-1"><?=$v['ten']?></p>
										<?php if($v['mau']!='' || $v['size']!='') { ?>
											<p class="mb-0">
												<?php if($v['mau']!='') { ?>
													<span class="pr-2">Màu: <?=$v['mau']?></span>
												<?php } ?>
												<?php if($v['size']!='') { ?>
													<span>Size: <?=$v['size']?></span>
												<?php } ?>
											</p>
										<?php } ?>
	                                </td>
	                                <td class="align-middle text-center">
	                                	<div class="price-cart-detail">
											<?php if($v['giamoi']) { ?>
												<span class="price-new-cart-detail"><?=number_format($v['giamoi'], 0, ',', '.')?>đ</span>
												<span class="price-old-cart-detail"><?=number_format($v['gia'], 0, ',', '.')?>đ</span>
											<?php } else { ?>
												<span class="price-new-cart-detail"><?=number_format($v['gia'], 0, ',', '.')?>đ</span>
											<?php } ?>
										</div>
	                                </td>
	                                <td class="align-middle text-right"><?=$v['soluong']?></td>
	                                <td class="align-middle text-right">
	                                	<div class="price-cart-detail">
											<?php if($v['giamoi']) { ?>
												<span class="price-new-cart-detail"><?=number_format($v['giamoi']*$v['soluong'], 0, ',', '.')?>đ</span>
												<span class="price-old-cart-detail"><?=number_format($v['gia']*$v['soluong'], 0, ',', '.')?>đ</span>
											<?php } else { ?>
												<span class="price-new-cart-detail"><?=number_format($v['gia']*$v['soluong'], 0, ',', '.')?>đ</span>
											<?php } ?>
										</div>
	                                </td>
	                            </tr>
	                        <?php } ?>
	                        <?php if($config['order']['ship'] || $config['order']['coupon']) { ?>
		                        <tr>
									<td colspan="5" class="title-money-cart-detail">Tạm tính:</td>
									<td colspan="1" class="cast-money-cart-detail"><?=number_format($item['tamtinh'], 0, ',', '.')?>đ</td>
								</tr>
							<?php } ?>
							<?php if($config['order']['ship']) { ?>
								<tr>
									<td colspan="5" class="title-money-cart-detail">Phí vận chuyển:</td>
									<td colspan="1" class="cast-money-cart-detail">
										<?php if($item['phiship']) { ?>
											<?=number_format($item['phiship'], 0, ',', '.')?>đ
										<?php } else { ?>
											Không
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
							<?php if($config['order']['coupon']) { ?>
								<tr>
									<td colspan="5" class="title-money-cart-detail">Ưu đãi:</td>
									<td colspan="1" class="cast-money-cart-detail">
										<?php if($item['loaicoupon']==1) { ?>
											-<?=number_format($item['phicoupon'], 0, ',', '.')?>%
										<?php } else if($item['loaicoupon']==2) { ?>
											-<?=number_format($item['phicoupon'], 0, ',', '.')?>đ
										<?php } else { ?>
											Không
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="5" class="title-money-cart-detail">Tổng giá trị đơn hàng:</td>
								<td colspan="1" class="cast-money-cart-detail"><?=number_format($item['tonggia'], 0, ',', '.')?>đ</td>
							</tr>
	                    </tbody>
	                <?php } ?>
	            </table>
	        </div>
        </div>
        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary" disabled><i class="far fa-save mr-2"></i>Lưu</button>
            <button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?=$linkMan?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?=$item['id']?>">
        </div>
    </form>
</section>