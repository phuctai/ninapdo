<div class="header">
	<div class="header-top">
		<div class="wrap-content d-flex align-items-center justify-content-between">
			<p class="info-header"><?=$slogan['ten'.$lang]?></p>
			<p class="info-header"><i class="fas fa-envelope"></i>Email: <?=$setting['email']?></p>
			<p class="info-header"><i class="fas fa-phone-square-alt"></i>Hotline: <?=$setting['hotline']?></p>
			<ul class="social social-header">
				<?php for($i=0;$i<count($social1);$i++) { ?>
					<li><a href="<?=$social1[$i]['link']?>" target="_blank"><img src="<?=UPLOAD_PHOTO_L.$social1[$i]['photo']?>" alt="<?=$social1[$i]['ten'.$lang]?>"></a></li>
				<?php } ?>
			</ul>
			<div class="lang-header">
	            <a href="ngon-ngu/vi/"><img src="assets/images/vi.jpg" alt="Tiếng Việt"></a>
	            <a href="ngon-ngu/en/"><img src="assets/images/en.jpg" alt="Tiếng Anh"></a>
	        </div>
	        <?php if($_SESSION[$login_name][$login_name]) { ?>
	        	<div class="user-header">
		        	<a href="account/thong-tin">
		        		<span>Hi, <?=$_SESSION[$login_name]['username']?></span>
		        	</a>
		        	<a href="account/dang-xuat">
		        		<i class="fas fa-sign-out-alt"></i>
		        		<span><?=dangxuat?></span>
		        	</a>
		        </div>
	        <?php } else { ?>
	        	<div class="user-header">
		        	<a href="account/dang-nhap">
		        		<i class="fas fa-sign-in-alt"></i>
		        		<span><?=dangnhap?></span>
		        	</a>
		        	<a href="account/dang-ky">
		        		<i class="fas fa-user-plus"></i>
		        		<span><?=dangky?></span>
		        	</a>
		        </div>
	        <?php } ?>
		</div>
	</div>
	<div class="header-bottom">
		<div class="wrap-content d-flex align-items-center justify-content-between">
			<a class="logo-header" href=""><img onerror="this.src='//placehold.it/120x100';" src="<?=UPLOAD_PHOTO_L.$logo['photo']?>"/></a>
			<a class="banner-header" href=""><img onerror="this.src='//placehold.it/730x120';" src="<?=UPLOAD_PHOTO_L.$banner['photo']?>"/></a>
			<a class="hotline-header">
				<p>Hotline hỗ trợ:</p>
				<span><?=$setting['hotline']?></span>
			</a>
		</div>
	</div>
</div>