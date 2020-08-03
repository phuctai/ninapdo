<?php 
	include "ajax_config.php";

	/* Paginations */
	include LIBRARIES."class/class.PaginationsAjax.php";
	$perPage = new PaginationsAjax();
	$perPage->perpage = (htmlspecialchars($_GET['perpage'])) ? htmlspecialchars($_GET['perpage']) : 1;
	$rowCount = htmlspecialchars($_GET['rowCount']);
	$eShow = htmlspecialchars($_GET['eShow']);
	$idList = (htmlspecialchars($_GET['idList'])) ? htmlspecialchars($_GET['idList']) : 0;
	$p = htmlspecialchars($_GET["p"]);
	$pageLink = "ajax/ajax_product.php?perpage=".$perPage->perpage;
	$tempLink = "";
	$where = "";
	if($p) $page = $p;
	else $page = 1;
	$start = ($page-1) * $perPage->perpage;
	if($start < 0) $start = 0;

	/* Math url */
	if($idList)
	{
		$tempLink .= "&idList=".$idList;
		$where .= " and id_list = ".$idList;
	}
	$tempLink .= "&p=";
	$pageLink .= $tempLink;

	/* Get data */
	$sql = "select ten$lang, tenkhongdauvi, tenkhongdauen, id, photo, gia, giamoi, giakm, type from #_product where type='san-pham' $where and noibat > 0 and hienthi > 0 order by stt,id desc";
	$sqlCache = $sql." limit $start, $perPage->perpage";
    $items = $cache->getCache($sqlCache,'result',7200);

	/* Count all data */
	$countItems = count($cache->getCache($sql,'result',7200));

	/* Get page result */
	if($rowCount==0) $rowCount = $countItems;
	$perPageResult = $perPage->getAllPageLinks($rowCount, $pageLink, $eShow);
?>
<?php if($countItems) { ?>
	<div class="grid-page w-clear">
		<?php for($i=0;$i<count($items);$i++) { ?>
			<div class="product">
				<a class="box-product text-decoration-none" href="<?=$items[$i][$sluglang]?>" title="<?=$items[$i]['ten'.$lang]?>">
					<p class="pic-product scale-img"><img onerror="this.src='<?=THUMBS?>/270x270x2/assets/images/noimage.png';" src="<?=WATERMARK?>/product/270x270x1/<?=UPLOAD_PRODUCT_L.$items[$i]['photo']?>" alt="<?=$items[$i]['ten'.$lang]?>"/></p>
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
					<span class="cart-add addcart transition" data-id="<?=$items[$i]['id']?>" data-action="addnow">Thêm vào giỏ hàng</span>
					<span class="cart-buy addcart transition" data-id="<?=$items[$i]['id']?>" data-action="buynow">Mua ngay</span>
				</p>
			</div>
		<?php } ?>
	</div>
	<div class="pagination-ajax"><?=$perPageResult?></div>
<?php } ?>