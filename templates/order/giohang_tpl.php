<form class="form-cart validation-cart" novalidate method="post" action="" enctype="multipart/form-data">
	<div class="wrap-cart d-flex align-items-stretch justify-content-between">
		<?php if(count($_SESSION['cart'])) { ?>
			<div class="top-cart">
				<p class="title-cart"><?=giohangcuaban?>:</p>
				<div class="list-procart">
					<div class="procart procart-label d-flex align-items-start justify-content-between">
						<div class="pic-procart"><?=hinhanh?></div>
						<div class="info-procart"><?=tensanpham?></div>
						<div class="quantity-procart">
							<p><?=soluong?></p>
							<p><?=thanhtien?></p>
						</div>
						<div class="price-procart"><?=thanhtien?></div>
					</div>
					<?php $max = count($_SESSION['cart']); for($i=0;$i<$max;$i++) {
						$pid = $_SESSION['cart'][$i]['productid'];
						$q = $_SESSION['cart'][$i]['qty'];
						$mau = ($_SESSION['cart'][$i]['mau'])?$_SESSION['cart'][$i]['mau']:0;
						$size = ($_SESSION['cart'][$i]['size'])?$_SESSION['cart'][$i]['size']:0;
						$code = ($_SESSION['cart'][$i]['code'])?$_SESSION['cart'][$i]['code']:'';
						$proinfo = $cart->get_product_info($pid);
						$pro_price = $proinfo['gia'];
						$pro_price_new = $proinfo['giamoi'];
						$pro_price_qty = $pro_price*$q;
						$pro_price_new_qty = $pro_price_new*$q; ?>
						<div class="procart procart-<?=$code?> d-flex align-items-start justify-content-between">
							<div class="pic-procart">
								<a class="text-decoration-none" href="<?=$proinfo[$sluglang]?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='//placehold.it/85x85';" src="<?=THUMBS?>/85x85x1/<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
								<a class="del-procart text-decoration-none" data-code="<?=$code?>">
									<i class="fa fa-times-circle"></i>
									<span><?=xoa?></span>
								</a>
							</div>
							<div class="info-procart">
								<h3 class="name-procart"><a class="text-decoration-none" href="<?=$proinfo[$sluglang]?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><?=$proinfo['ten'.$lang]?></a></h3>
								<div class="properties-procart">
									<?php if($mau) { $maudetail = $d->rawQueryOne("SELECT ten$lang FROM table_product_mau WHERE type = ? AND id = ?",array($proinfo['type'],$mau)); ?>
										<p>Màu: <strong><?=$maudetail['ten'.$lang]?></strong></p>
									<?php } ?>
									<?php if($size) { $sizedetail = $d->rawQueryOne("SELECT ten$lang FROM table_product_size WHERE type = ? AND id = ?",array($proinfo['type'],$size)); ?>
										<p>Size: <strong><?=$sizedetail['ten'.$lang]?></strong></p>
									<?php } ?>
								</div>
							</div>
							<div class="quantity-procart">
								<div class="price-procart price-procart-rp">
									<?php if($proinfo['giamoi']) { ?>
										<p class="price-new-cart load-price-new-<?=$code?>">
											<?=number_format($pro_price_new_qty,0, ',', '.')."đ"?>
										</p>
										<p class="price-old-cart load-price-<?=$code?>">
											<?=number_format($pro_price_qty,0, ',', '.')."đ"?>
										</p>
									<?php } else { ?>
										<p class="price-new-cart load-price-<?=$code?>">
											<?=number_format($pro_price_qty,0, ',', '.')."đ"?>
										</p>
									<?php } ?>
								</div>
				                <div class="quantity-counter-procart quantity-counter-procart-<?=$code?> d-flex align-items-stretch justify-content-between">
			                        <span class="counter-procart-minus counter-procart">-</span>
			                        <input type="number" class="quantity-procat" min="1" value="<?=$q?>" data-pid="<?=$pid?>" data-code="<?=$code?>"/>
			                        <span class="counter-procart-plus counter-procart">+</span>
			                    </div>
				                <div class="pic-procart pic-procart-rp">
									<a class="text-decoration-none" href="<?=$proinfo[$sluglang]?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='//placehold.it/85x85';" src="<?=THUMBS?>/85x85x1/<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
									<a class="del-procart text-decoration-none" data-code="<?=$code?>">
										<i class="fa fa-times-circle"></i>
										<span><?=xoa?></span>
									</a>
								</div>
							</div>
							<div class="price-procart">
								<?php if($proinfo['giamoi']) { ?>
									<p class="price-new-cart load-price-new-<?=$code?>">
										<?=number_format($pro_price_new_qty,0, ',', '.')."đ"?>
									</p>
									<p class="price-old-cart load-price-<?=$code?>">
										<?=number_format($pro_price_qty,0, ',', '.')."đ"?>
									</p>
								<?php } else { ?>
									<p class="price-new-cart load-price-<?=$code?>">
										<?=number_format($pro_price_qty,0, ',', '.')."đ"?>
									</p>
								<?php } ?>
							</div>
						</div>
			        <?php } ?>
				</div>
		        <div class="money-procart">
		        	<?php if($config['order']['coupon']) { ?>
			        	<div class="total-procart coupon-procart d-flex align-items-center justify-content-between">
			        		<input type="text" class="form-control code-coupon" placeholder="<?=nhapmauudai?>" />
							<input type="button" class="btn-cart btn btn-primary apply-coupon" value="<?=apdung?>">
				        </div>
				    <?php } ?>
				    <?php if($config['order']['ship'] || $config['order']['coupon']) { ?>
				        <div class="total-procart d-flex align-items-center justify-content-between">
				        	<p><?=tamtinh?>:</p>
				        	<p class="total-price load-price-temp"><?=number_format($cart->get_order_total(),0, ',', '.')?>đ</p>
				        </div>
				    <?php } ?>
			        <?php if($config['order']['ship']) { ?>
			        	<div class="total-procart d-flex align-items-center justify-content-between">
				        	<p><?=phivanchuyen?>:</p>
				        	<p class="total-price load-price-ship">0đ</p>
				        </div>
				    <?php } ?>
				    <?php if($config['order']['coupon']) { ?>
				        <div class="total-procart d-flex align-items-center justify-content-between">
				        	<p><?=uudai?>:</p>
				        	<p class="total-price load-price-endow"><?=chuacouudai?></p>
				        </div>
				    <?php } ?>
			        <div class="total-procart d-flex align-items-center justify-content-between">
			        	<p><?=tongtien?>:</p>
			        	<p class="total-price load-price-total"><?=number_format($cart->get_order_total(),0, ',', '.')?>đ</p>
			        </div>
			        <input type="hidden" class="price-temp" name="price-temp" value="<?=$cart->get_order_total()?>">
			        <input type="hidden" class="price-ship" name="price-ship">
			        <input type="hidden" class="price-endow" name="price-endow">
			        <input type="hidden" class="price-endowID" name="price-endowID">
			        <input type="hidden" class="price-endowType" name="price-endowType">
	                <input type="hidden" class="price-total" name="price-total" value="<?=$cart->get_order_total()?>">
		        </div>
		    </div>
		    <div class="bottom-cart">
			    <div class="section-cart">
		    		<p class="title-cart"><?=hinhthucthanhtoan?>:</p>
			    	<div class="information-cart">
			    		<?php foreach($httt as $key => $value) { ?>
			    			<div class="payments-cart custom-control custom-radio">
								<input type="radio" class="custom-control-input" id="payments-<?=$value['id']?>" name="payments" value="<?=$value['id']?>" required>
								<label class="payments-label custom-control-label" for="payments-<?=$value['id']?>" data-payments="<?=$value['id']?>"><?=$value['ten'.$lang]?></label>
								<div class="payments-info payments-info-<?=$value['id']?> transition"><?=str_replace("\n","<br>",$value['mota'.$lang])?></div>
							</div>
			    		<?php } ?>
			    	</div>
			    	<p class="title-cart"><?=thongtingiaohang?>:</p>
			    	<div class="information-cart">
			    		<div class="input-double-cart w-clear">
			    			<div class="input-cart">
				                <input type="text" class="form-control" id="ten" name="ten" placeholder="<?=hoten?>" required />
				                <div class="invalid-feedback"><?=vuilongnhaphoten?></div>
				            </div>
				            <div class="input-cart">
				                <input type="number" class="form-control" id="dienthoai" name="dienthoai" placeholder="<?=sodienthoai?>" required />
				                <div class="invalid-feedback"><?=vuilongnhapsodienthoai?></div>
				            </div>
			    		</div>
			            <div class="input-cart">
			                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
			                <div class="invalid-feedback"><?=vuilongnhapdiachiemail?></div>
			            </div>
			            <div class="input-triple-cart w-clear">
			            	<div class="input-cart">
								<select class="select-cart select-city custom-select" required id="city" name="city" onchange="load_district(this.value);">
									<option value="0"><?=tinhthanh?></option>
									<?php for($i=0;$i<count($city);$i++) { ?>
										<option value="<?=$city[$i]['id']?>"><?=$city[$i]['ten']?></option>
									<?php } ?>
								</select>
								<div class="invalid-feedback"><?=vuilongchontinhthanh?></div>
			            	</div>
			            	<div class="input-cart">
								<select class="select-cart select-district custom-select" required id="district" name="district" onchange="load_wards(this.value);">
									<option value="0"><?=quanhuyen?></option>
								</select>
								<div class="invalid-feedback"><?=vuilongchonquanhuyen?></div>
							</div>
							<div class="input-cart">
								<select class="select-cart select-wards custom-select" required id="wards" name="wards" onchange="load_ship(this.value);">
									<option value="0"><?=phuongxa?></option>
								</select>
								<div class="invalid-feedback"><?=vuilongchonphuongxa?></div>
							</div>
						</div>
						<div class="input-cart">
			                <input type="text" class="form-control" id="diachi" name="diachi" placeholder="<?=diachi?>" required />
			                <div class="invalid-feedback"><?=vuilongnhapdiachi?></div>
			            </div>
						<div class="input-cart">
			                <textarea class="form-control" id="yeucaukhac" name="yeucaukhac" placeholder="<?=yeucaukhac?>" /></textarea>
			            </div>
			    	</div>
		    		<input type="submit" class="btn-cart btn btn-primary btn-lg btn-block" name="thanhtoan" value="<?=thanhtoan?>" disabled>
			    </div>
		    </div>
		<?php } else { ?>
			<a href="" class="empty-cart text-decoration-none">
				<i class="fa fa-cart-arrow-down"></i>
				<p><?=khongtontaisanphamtronggiohang?></p>
				<span><?=vetrangchu?></span>
			</a>
		<?php } ?>
	</div>
</form>