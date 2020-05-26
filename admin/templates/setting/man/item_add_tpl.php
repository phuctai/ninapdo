<?php
	$linkSave = "index.php?com=setting&act=save";
?>
<!-- Content Header -->
<section class="content-header text-sm">
	<div class="container-fluid">
		<div class="row">
			<ol class="breadcrumb float-sm-left">
				<li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
				<li class="breadcrumb-item active">Thông tin công ty</li>
			</ol>
		</div>
	</div>
</section>

<!-- Main content -->
<section class="content">
	<form class="validation-form" novalidate method="post" action="<?=$linkSave?>" enctype="multipart/form-data">
		<div class="card-footer text-sm sticky-top">
			<button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
			<button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
		</div>
		<?php if($config['website']['debug-developer']) { ?>
			<div class="card card-primary card-outline text-sm">
				<div class="card-header">
					<h3 class="card-title">Cấu hình mailer</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="custom-control custom-radio d-inline-block mr-3 text-md">
							<input class="custom-control-input mailertype" type="radio" id="mailertype-host" name="data[mailertype]" <?=($item['mailertype']==1 || $item['mailertype']==0)?"checked":""?> value="1">
							<label for="mailertype-host" class="custom-control-label font-weight-normal">Host email</label>
						</div>
						<div class="custom-control custom-radio d-inline-block mr-3 text-md">
							<input class="custom-control-input mailertype" type="radio" id="mailertype-gmail" name="data[mailertype]" <?=($item['mailertype']==2)?"checked":""?> value="2">
							<label for="mailertype-gmail" class="custom-control-label font-weight-normal">Gmail email</label>
						</div>
					</div>
					<div class="host-email <?=($item['mailertype']==1 || $item['mailertype']==0)?'d-block':'d-none'?>">
						<div class="row">
							<div class="form-group col-md-4 col-sm-6">
								<label for="ip_host">Host:</label>
								<input type="text" class="form-control" name="data[ip_host]" id="ip_host" placeholder="Host" value="<?=$item['ip_host']?>">
							</div>
							<div class="form-group col-md-4 col-sm-6">
								<label for="email_host">Email host:</label>
								<input type="text" class="form-control" name="data[email_host]" id="email_host" placeholder="Email host" value="<?=$item['email_host']?>">
							</div>
							<div class="form-group col-md-4 col-sm-6">
								<label for="password_host">Password host:</label>
								<input type="text" class="form-control" name="data[password_host]" id="password_host" placeholder="Password host" value="<?=$item['password_host']?>">
							</div>
						</div>
					</div>
					<div class="gmail-email <?=($item['mailertype']==2)?'d-block':'d-none'?>">
						<div class="row">
							<div class="form-group col-md-4 col-sm-6">
								<label for="host_gmail">Host:</label>
								<input type="text" class="form-control" name="data[host_gmail]" id="host_gmail" placeholder="Host" value="<?=$item['host_gmail']?>">
							</div>
							<div class="form-group col-md-4 col-sm-6">
								<label for="port_gmail">Port:</label>
								<input type="text" class="form-control" name="data[port_gmail]" id="port_gmail" placeholder="Port" value="<?=$item['port_gmail']?>">
							</div>
							<div class="form-group col-md-4 col-sm-6">
								<label for="secure_gmail">Secure:</label>
								<select class="form-control" name="data[secure_gmail]" id="secure_gmail">
									<option <?=($item['secure_gmail']=='tls')?'selected':''?> value="tls">TLS</option>
									<option <?=($item['secure_gmail']=='ssl')?'selected':''?> value="ssl">SSL</option>
								</select>
							</div>
							<div class="form-group col-md-4 col-sm-6">
								<label for="email_gmail">Email:</label>
								<input type="text" class="form-control" name="data[email_gmail]" id="email_gmail" placeholder="Email" value="<?=$item['email_gmail']?>">
							</div>
							<div class="form-group col-md-4 col-sm-6">
								<label for="password_gmail">Password:</label>
								<input type="text" class="form-control" name="data[password_gmail]" id="password_gmail" placeholder="Password" value="<?=$item['password_gmail']?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="card card-primary card-outline text-sm">
			<div class="card-header">
				<h3 class="card-title">Thông tin chung</h3>
			</div>
			<div class="card-body">
				<?php if(count($config['website']['lang'])>1) { ?>
					<div class="form-group">
						<label>Ngôn ngữ mặc định:</label>
						<div class="form-group">
							<?php foreach($config['website']['lang'] as $k => $v) { ?>
								<div class="custom-control custom-radio d-inline-block mr-3 text-md">
									<input class="custom-control-input" type="radio" id="lang_default-<?=$k?>" name="data[lang_default]" <?=($k=='vi')?"checked":($k==$item['lang_default'])?"checked":""?> value="<?=$k?>">
									<label for="lang_default-<?=$k?>" class="custom-control-label font-weight-normal"><?=$v?></label>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="row">
					<?php if($config['setting']['diachi']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="diachi">Địa chỉ:</label>
							<input type="text" class="form-control" name="data[diachi]" id="diachi" placeholder="Địa chỉ" value="<?=$item['diachi']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['email']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="email">Email:</label>
							<input type="email" class="form-control" name="data[email]" id="email" placeholder="Email" value="<?=$item['email']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['hotline']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="hotline">Hotline:</label>
							<input type="text" class="form-control" name="data[hotline]" id="hotline" placeholder="Hotline" value="<?=$item['hotline']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['dienthoai']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="dienthoai">Điện thoại:</label>
							<input type="text" class="form-control" name="data[dienthoai]" id="dienthoai" placeholder="Điện thoại" value="<?=$item['dienthoai']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['zalo']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="zalo">Zalo:</label>
							<input type="text" class="form-control" name="data[zalo]" id="zalo" placeholder="Zalo" value="<?=$item['zalo']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['oaidzalo']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="oaidzalo">OAID Zalo:</label>
							<input type="text" class="form-control" name="data[oaidzalo]" id="oaidzalo" placeholder="OAID Zalo" value="<?=$item['oaidzalo']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['website']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="website">Website:</label>
							<input type="text" class="form-control" name="data[website]" id="website" placeholder="Website" value="<?=$item['website']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['fanpage']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="fanpage">Fanpage:</label>
							<input type="text" class="form-control" name="data[fanpage]" id="fanpage" placeholder="Fanpage" value="<?=$item['fanpage']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['copyright']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="copyright">Copyright:</label>
							<input type="text" class="form-control" name="data[copyright]" id="copyright" placeholder="Copyright" value="<?=$item['copyright']?>">
						</div>
					<?php } ?>
					<?php if($config['setting']['toado']) { ?>
						<div class="form-group col-md-4 col-sm-6">
							<label for="toado">Tọa độ google map:</label>
							<input type="text" class="form-control" name="data[toado]" id="toado" placeholder="Tọa độ google map" value="<?=$item['toado']?>">
						</div>
					<?php } ?>
				</div>
				<?php if($config['setting']['toado_iframe']) { ?>
					<div class="form-group">
						<label for="toado_iframe">
							<span>Tọa độ google map iframe:</span>
							<a class="text-sm font-weight-normal ml-1" href="https://www.google.com/maps" target="_blank" title="Lấy mã nhúng google map">(Lấy mã nhúng)</a>
						</label>

						<textarea class="form-control" name="data[toado_iframe]" id="toado_iframe" rows="5" placeholder="Tọa độ google map iframe"><?=htmlspecialchars_decode($item['toado_iframe'])?></textarea>
					</div>
				<?php } ?>
				<div class="form-group">
					<label for="analytics">Google analytics:</label>
					<textarea class="form-control" name="data[analytics]" id="analytics" rows="5" placeholder="Google analytics"><?=htmlspecialchars_decode($item['analytics'])?></textarea>
				</div>
				<div class="form-group">
					<label for="mastertool">Google Webmaster Tool:</label>
					<textarea class="form-control" name="data[mastertool]" id="mastertool" rows="5" placeholder="Google Webmaster Tool"><?=htmlspecialchars_decode($item['mastertool'])?></textarea>
				</div>
				<div class="form-group">
					<label for="headjs">Head JS:</label>
					<textarea class="form-control" name="data[headjs]" id="headjs" rows="5" placeholder="Head JS"><?=htmlspecialchars_decode($item['headjs'])?></textarea>
				</div>
				<div class="form-group">
					<label for="bodyjs">Body JS:</label>
					<textarea class="form-control" name="data[bodyjs]" id="bodyjs" rows="5" placeholder="Body JS"><?=htmlspecialchars_decode($item['bodyjs'])?></textarea>
				</div>
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
									<?php if($config['setting']['mota']) { ?>
										<div class="form-group">
											<label for="mota<?=$k?>">Mô tả (<?=$k?>):</label>
											<textarea class="form-control for-seo <?=($config['setting']['mota_cke'])?'form-control-ckeditor':''?>" name="data[mota<?=$k?>]" id="mota<?=$k?>" rows="5" placeholder="Mô tả (<?=$k?>)"><?=htmlspecialchars_decode($item['mota'.$k])?></textarea>
										</div>
                                    <?php } ?>
                                    <?php if($config['setting']['noidung']) { ?>
										<div class="form-group">
											<label for="noidung<?=$k?>">Nội dung (<?=$k?>):</label>
											<textarea class="form-control for-seo <?=($config['setting']['noidung_cke'])?'form-control-ckeditor':''?>" name="data[noidung<?=$k?>]" id="noidung<?=$k?>" rows="5" placeholder="Nội dung (<?=$k?>)"><?=htmlspecialchars_decode($item['noidung'.$k])?></textarea>
										</div>
                                    <?php } ?>
								</div>
                            <?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	    <div class="card card-primary card-outline text-sm">
	        <div class="card-header">
	            <h3 class="card-title">Nội dung SEO</h3>
	            <a class="btn btn-sm bg-gradient-success d-inline-block text-white float-right create-seo" title="Tạo SEO">Tạo SEO</a>
	        </div>
	        <div class="card-body">
	            <?php
	                $seo = $item;
	                include _TEMPLATE."seo.php";
	            ?>
	        </div>
	    </div>
		<div class="card-footer text-sm">
			<button type="submit" class="btn btn-sm bg-gradient-primary submit-check"><i class="far fa-save mr-2"></i>Lưu</button>
			<button type="reset" class="btn btn-sm bg-gradient-secondary"><i class="fas fa-redo mr-2"></i>Làm lại</button>
			<input type="hidden" name="id" value="<?=$item['id']?>">
		</div>
	</form>
</section>

<!-- Setting js -->
<script type="text/javascript">
	$(document).ready(function(){
		$(".mailertype").click(function(){
			var value = parseInt($(this).val());

			if(value == 1)
			{
				$(".host-email").removeClass("d-none");
				$(".host-email").addClass("d-block");
				$(".gmail-email").removeClass("d-block");
				$(".gmail-email").addClass("d-none");
			}
			if(value == 2)
			{
				$(".gmail-email").removeClass("d-none");
				$(".gmail-email").addClass("d-block");
				$(".host-email").removeClass("d-block");
				$(".host-email").addClass("d-none");
			}
		})
	})
</script>