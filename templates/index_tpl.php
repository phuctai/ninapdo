<?php if(count($brand)) { ?>
	<div class="wrap-brand">
		<div class="wrap-content d-flex align-items-center justify-content-between">
			<p class="control-carousel prev-carousel prev-brand transition"><i class="fas fa-chevron-left"></i></p>
			<div class="owl-carousel owl-theme owl-brand">
				<?php foreach($brand as $v) { ?>
					<div>
						<a class="brand text-decoration-none" href="<?=get_slug($lang,$v['id'],'product_brand')?>" title="<?=$v['ten'.$lang]?>">
							<img onerror="this.src='//placehold.it/150x150';" src="<?=_upload_product_l?>150x150x2/<?=$v['photo']?>" alt="<?=$v['ten'.$lang]?>"/>
						</a>
					</div>
				<?php } ?>
			</div>
			<p class="control-carousel next-carousel next-brand transition"><i class="fas fa-chevron-right"></i></p>
		</div>
	</div>
<?php } ?>

<?php if(count($pronb)) { ?>
	<div class="wrap-product wrap-content">
		<div class="title-main"><span>Sản phẩm nổi bật</span></div>
		<div class="paging-product"></div>
	</div>
<?php } ?>

<?php if(count($newsnb) || count($videonb)) { ?>
	<div class="wrap-intro wrap-content d-flex align-items-start justify-content-between">
		<div class="left-intro">
			<p class="title-intro"><span>Tin tức mới</span></p>
			<div class="newshome-intro w-clear">
				<a class="newshome-best text-decoration-none" href="<?=get_slug($lang,$newsnb[0]['id'],'news')?>" title="<?=$newsnb[0]['ten'.$lang]?>">
					<p class="pic-newshome-best scale-img"><img onerror="this.src='//placehold.it/360x200';" src="<?=_upload_news_l?>360x200x1/<?=$newsnb[0]['photo']?>" alt="<?=$newsnb[0]['ten'.$lang]?>"></p>
					<h3 class="name-newshome text-split"><?=$newsnb[0]['ten'.$lang]?></h3>
					<p class="time-newshome">Ngày đăng: <?=date("d/m/Y",$newsnb[0]['ngaytao'])?></p>
					<p class="desc-newshome text-split"><?=$newsnb[0]['mota'.$lang]?></p>
					<span class="view-newshome transition"><?=_xemthem?></span>
				</a>
				<div class="newshome-scroll">
					<ul>
						<?php foreach($newsnb as $v) { ?>
							<li>
								<a class="newshome-normal text-decoration-none w-clear" href="<?=get_slug($lang,$v['id'],'news')?>" title="<?=$v['ten'.$lang]?>">
									<p class="pic-newshome-normal scale-img"><img onerror="this.src='//placehold.it/150x120';" src="<?=_upload_news_l?>150x120x1/<?=$v['photo']?>" alt="<?=$v['ten'.$lang]?>"></p>
									<div class="info-newshome-normal">
										<h3 class="name-newshome text-split"><?=$v['ten'.$lang]?></h3>
										<p class="time-newshome"><?=_ngaydang?>: <?=date("d/m/Y",$v['ngaytao'])?></p>
										<p class="desc-newshome text-split"><?=$v['mota'.$lang]?></p>
									</div>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="right-intro">
			<p class="title-intro"><span>Video clip</span></p>
			<div class="videohome-intro">
				<?=getAddonsOnline("","videoHomeFotorama","videoFotorama",0,350,120,95)?>
	            <?php //getAddonsOnline("","videoHomeSelect","videoSelect",0,0)?>
			</div>
		</div>
	</div>
<?php } ?>

<?php if(count($partner)) { ?>
	<div class="wrap-partner">
		<div class="wrap-content d-flex align-items-center justify-content-between">
			<p class="control-carousel prev-carousel prev-partner transition"><i class="fas fa-chevron-left"></i></p>
			<div class="owl-carousel owl-theme owl-partner">
				<?php foreach($partner as $v) { ?>
					<div>
						<a class="partner text-decoration-none" href="<?=$v['link']?>" target="_blank" title="<?=$v['ten'.$lang]?>">
							<img onerror="this.src='//placehold.it/175x95';" src="<?=_upload_photo_l?>175x95x2/<?=$v['photo']?>" alt="<?=$v['ten'.$lang]?>"/>
						</a>
					</div>
				<?php } ?>
			</div>
			<p class="control-carousel next-carousel next-partner transition"><i class="fas fa-chevron-right"></i></p>
		</div>
	</div>
<?php } ?>