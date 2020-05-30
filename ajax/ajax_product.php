<?php 
	include "ajax_config.php";

	/* Paginations */
	include LIBRARIES."paginations.php";
	$perPage = new paginations();
	$perPage->perpage = htmlspecialchars($_GET['perpage']);
	$pageLink = "ajax/ajax_product.php?p=";
	$p = htmlspecialchars($_GET["p"]);
	if($p) $page = $p;
	else $page = 1;
	$start = ($page-1) * $perPage->perpage;
	if($start < 0) $start = 0;
	$rowCount = htmlspecialchars($_GET['rowCount']);
	$eShow = htmlspecialchars($_GET['eShow']);

	/* Get data */
	$sql = "SELECT ten$lang, id, photo, gia, giamoi, giakm, type FROM table_product WHERE hienthi=1 AND noibat>0 AND type='san-pham' ORDER BY stt,id DESC";
	$items = $d->rawQuery($sql." LIMIT $start, $perPage->perpage");

	/* Count all data */
	$countItems = count($d->rawQuery($sql));

	/* Get page result */
	if($rowCount==0) $rowCount = $countItems;
	$perPageResult = $perPage->getAllPageLinks($rowCount, $pageLink, $eShow);
?>
<?php if($countItems) { ?>
	<div class="grid-page w-clear">
		<?php for($i=0;$i<count($items);$i++) { ?>
			<div class="product">
				<a class="box-product text-decoration-none" href="<?=get_slug($lang,$items[$i]['id'],'product')?>" title="<?=$items[$i]['ten'.$lang]?>">
					<p class="pic-product scale-img"><img onerror="this.src='//placehold.it/270x270';" src="product/270x270x1/<?=UPLOAD_PRODUCT_L.$items[$i]['photo']?>" alt="<?=$items[$i]['ten'.$lang]?>"/></p>
					<h3 class="name-product text-split"><?=$items[$i]['ten'.$lang]?></h3>
					<p class="price-product">
						<?php if($items[$i]['giakm']) { ?>
							<span class="price-new"><?=number_format($items[$i]['giamoi'],0, ',', '.').'đ'?></span>
							<span class="price-old"><?=number_format($items[$i]['gia'],0, ',', '.').'đ'?></span>
							<span class="price-per"><?='-'.$items[$i]['giakm'].'%'?></span>
						<?php } else { ?>
							<span class="price-new"><?=($items[$i]['gia'])?number_format($items[$i]['gia'],0, ',', '.').'đ':lienhe?></span>
						<?php } ?>
					</p>
				</a>
				<p class="cart-product w-clear">
					<span class="cart-add transition" onclick="add_to_cart(<?=$items[$i]['id']?>,'addnow')">Thêm vào giỏ hàng</span>
					<span class="cart-buy transition" onclick="add_to_cart(<?=$items[$i]['id']?>,'buynow')">Mua ngay</span>
				</p>
			</div>
		<?php } ?>
	</div>
	<div class="pagination-ajax"><?=$perPageResult?></div>
<?php } ?>