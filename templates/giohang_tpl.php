<script type="text/javascript">
    $(document).ready(function(){
        $(".del-procart").click(function(){
            if(confirm('<?=banmuonxoasanphamnay?>'))
            {
                var code = $(this).data("code");
                var ship = $(".price-ship").val();
                var endow = $(".price-endow").val();

                $.ajax({
                    type: "POST",
                    url:'ajax/ajax_delete_cart.php',
                    dataType: 'json',
                    data: {code:code,ship:ship,endow:endow},
                    success: function(result){
                        if(result.max)
                        {
                            $('.price-temp').val(result.temp);
			                $('.load-price-temp').html(result.tempText);
			                $('.price-total').val(result.total);
			                $('.load-price-total').html(result.totalText);
                            $(".procart-"+code).remove();
                        }
                        else
                        {
                            $(".wrap-cart").html('<a href="" class="empty-cart text-decoration-none"><i class="fa fa-cart-arrow-down"></i><p><?=khongtontaisanphamtronggiohang?></p><span><?=vetrangchu?></span></a>');
                        }
                    }
                });
            }
        })

        $(".payments-label").click(function(){
            var payments = $(this).data("payments");
            $(".payments-cart .payments-label, .payments-info").removeClass("active");
            $(this).addClass("active");
            $(".payments-info-"+payments).addClass("active");
        });

        $("input.quantity-procat").change(function(){
        	var quantity = $(this).val();
            var pid = $(this).data("pid");
            var code = $(this).data("code");
        	update_cart(pid,code,quantity);
        })

        $(".apply-coupon").click(function(){
        	var coupon = $(".code-coupon").val();
        	var ship = $(".price-ship").val();

        	if(coupon=='')
        	{
        		modalNotify("<?=chuanhapmauudai?>")
        		return false;
        	}

        	$.ajax({
                type: "POST",
                url:'ajax/ajax_coupon_cart.php',
                dataType: 'json',
                data: {coupon:coupon,ship:ship},
                success: function(result){
                	$('.price-total').val(result.total);
                	$('.load-price-total').html(result.totalText);
                	$('.price-endowType').val(result.endowType);
                	$('.price-endowID').val(result.endowID);
                	$('.price-endow').val(result.endow);
                	$('.load-price-endow').html(result.endowText);
                    
                    if(result.error!='')
                    {
                    	$(".code-coupon").val("");
                    	modalNotify(result.error);
                    }
                }
            });
        })
    })

    function update_cart(pid,code,quantity)
    {
        var ship = $(".price-ship").val();
        var endow = $(".price-endow").val();

        $.ajax({
	        type: "POST",
	        url: "ajax/ajax_update_cart.php",
	        dataType: 'json',
	        data: {pid:pid,code:code,q:quantity,ship:ship,endow:endow},
	        success: function(result){
	            if(result){
	                $('.load-price-'+code).html(result.gia);
	                $('.load-price-new-'+code).html(result.giamoi);
	                $('.price-temp').val(result.temp);
	                $('.load-price-temp').html(result.tempText);
	                $('.price-total').val(result.total);
	                $('.load-price-total').html(result.totalText);
	            }
	        }
        });
    }

    function quantity_cart(element,pid,code,quantity)
    {
    	$(element+code+" span").click(function(){
            var $button = $(this);
            var oldValue = $button.parent().find("input").val();
            if($button.text() == "+") quantity = parseFloat(oldValue) + 1;
            else if(oldValue > 1) quantity = parseFloat(oldValue) - 1;
            $button.parent().find("input").val(quantity);
            update_cart(pid,code,quantity);
        });
    }

    function load_district(id)
    {
        $.ajax({
            type: 'post',
            url: 'ajax/ajax_district.php',
            data: {id_city:id},
            success: function (result){
            	load_giaship(0);
                $(".select-district").html(result);
                $(".select-wards").html('<option value=""><?=phuongxa?></option>');
            }
        });
    }

    function load_wards(id)
    {
        $.ajax({
            type: 'post',
            url: 'ajax/ajax_wards.php',
            data: {id_district:id},
            success: function (result){
            	load_giaship(0);
                $(".select-wards").html(result);
            }
        });
    }

    function load_giaship(id)
    {
		var endow = $(".price-endow").val();
		$.ajax({
		    type: "POST",
		    url: "ajax/ajax_ship_cart.php",
		    dataType: 'json',
		    data: {id:id,endow:endow},
		    success: function(result){
		        if(result)
		        {
		            $('.load-price-ship').html(result.shipText);
		            $('.load-price-total').html(result.totalText);
		            $('.price-ship').val(result.ship);
		            $('.price-total').val(result.total);
		        }   
		    }
		}); 
    }
</script>

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
						$proinfo = get_product_info($pid); ?>
						<div class="procart procart-<?=$code?> d-flex align-items-start justify-content-between">
							<div class="pic-procart">
								<a class="text-decoration-none" href="<?=get_slug($lang,$proinfo['id'],'product')?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='//placehold.it/85x85';" src="<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
								<a class="del-procart text-decoration-none" data-code="<?=$code?>">
									<i class="fa fa-times-circle"></i>
									<span><?=xoa?></span>
								</a>
							</div>
							<div class="info-procart">
								<h3 class="name-procart"><a class="text-decoration-none" href="<?=get_slug($lang,$proinfo['id'],'product')?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><?=$proinfo['ten'.$lang]?></a></h3>
								<div class="khuyenmai-procart"><?=str_replace("\n","<br/>",htmlspecialchars_decode($proinfo['khuyenmai'.$lang]))?></div>
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
											<?=number_format(get_price_new($pid)*$q,0, ',', '.')."đ"?>
										</p>
										<p class="price-old-cart load-price-<?=$code?>">
											<?=number_format(get_price($pid)*$q,0, ',', '.')."đ"?>
										</p>
									<?php } else { ?>
										<p class="price-new-cart load-price-<?=$code?>">
											<?=number_format(get_price($pid)*$q,0, ',', '.')."đ"?>
										</p>
									<?php } ?>
								</div>
				                <div class="quantity-counter-procart quantity-counter-procart-<?=$code?> d-flex align-items-stretch justify-content-between">
			                        <span class="counter-procart-minus counter-procart">-</span>
			                        <input type="number" class="quantity-procat" min="1" value="<?=$q?>" data-pid="<?=$pid?>" data-code="<?=$code?>"/>
			                        <span class="counter-procart-plus counter-procart">+</span>
			                    </div>
				                <div class="pic-procart pic-procart-rp">
									<a class="text-decoration-none" href="<?=get_slug($lang,$proinfo['id'],'product')?>" target="_blank" title="<?=$proinfo['ten'.$lang]?>"><img onerror="this.src='//placehold.it/85x85';" src="<?=UPLOAD_PRODUCT_L.$proinfo['photo']?>" alt="<?=$proinfo['ten'.$lang]?>"></a>
									<a class="del-procart text-decoration-none" data-code="<?=$code?>">
										<i class="fa fa-times-circle"></i>
										<span><?=xoa?></span>
									</a>
								</div>
				                <script type="text/javascript">
				                	quantity_cart(".quantity-counter-procart-",<?=$pid?>,"<?=$code?>",<?=$q?>);
				                </script>
							</div>
							<div class="price-procart">
								<?php if($proinfo['giamoi']) { ?>
									<p class="price-new-cart load-price-new-<?=$code?>">
										<?=number_format(get_price_new($pid)*$q,0, ',', '.')."đ"?>
									</p>
									<p class="price-old-cart load-price-<?=$code?>">
										<?=number_format(get_price($pid)*$q,0, ',', '.')."đ"?>
									</p>
								<?php } else { ?>
									<p class="price-new-cart load-price-<?=$code?>">
										<?=number_format(get_price($pid)*$q,0, ',', '.')."đ"?>
									</p>
								<?php } ?>
							</div>
						</div>
			        <?php } ?>
				</div>
		        <div class="money-procart">
		        	<div class="total-procart coupon-procart d-flex align-items-center justify-content-between">
		        		<input type="text" class="form-control code-coupon" placeholder="<?=nhapmauudai?>" />
						<input type="button" class="btn-cart btn btn-primary apply-coupon" value="<?=apdung?>">
			        </div>
			        <div class="total-procart d-flex align-items-center justify-content-between">
			        	<p><?=tamtinh?>:</p>
			        	<p class="total-price load-price-temp"><?=number_format(get_order_total(),0, ',', '.')?>đ</p>
			        </div>
		        	<div class="total-procart d-flex align-items-center justify-content-between">
			        	<p><?=phivanchuyen?>:</p>
			        	<p class="total-price load-price-ship">0đ</p>
			        </div>
			        <div class="total-procart d-flex align-items-center justify-content-between">
			        	<p><?=uudai?>:</p>
			        	<p class="total-price load-price-endow"><?=chuacouudai?></p>
			        </div>
			        <div class="total-procart d-flex align-items-center justify-content-between">
			        	<p><?=tongtien?>:</p>
			        	<p class="total-price load-price-total"><?=number_format(get_order_total(),0, ',', '.')?>đ</p>
			        </div>
			        <input type="hidden" class="price-temp" name="price-temp" value="<?=get_order_total()?>">
			        <input type="hidden" class="price-ship" name="price-ship">
			        <input type="hidden" class="price-endow" name="price-endow">
			        <input type="hidden" class="price-endowID" name="price-endowID">
			        <input type="hidden" class="price-endowType" name="price-endowType">
	                <input type="hidden" class="price-total" name="price-total" value="<?=get_order_total()?>">
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
									<option value=""><?=tinhthanh?></option>
									<?php for($i=0;$i<count($city);$i++) { ?>
										<option value="<?=$city[$i]['id']?>"><?=$city[$i]['ten']?></option>
									<?php } ?>
								</select>
								<div class="invalid-feedback"><?=vuilongchontinhthanh?></div>
			            	</div>
			            	<div class="input-cart">
								<select class="select-cart select-district custom-select" required id="district" name="district" onchange="load_wards(this.value);">
									<option value=""><?=quanhuyen?></option>
								</select>
								<div class="invalid-feedback"><?=vuilongchonquanhuyen?></div>
							</div>
							<div class="input-cart">
								<select class="select-cart select-wards custom-select" required id="wards" name="wards" onchange="load_giaship(this.value);">
									<option value=""><?=phuongxa?></option>
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