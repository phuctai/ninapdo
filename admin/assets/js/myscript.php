<script type="text/javascript">
	/* Validation form */
	function ValidationFormSelf(ele)
	{
	    window.addEventListener('load', function(){
	        var forms = document.getElementsByClassName(ele);
	        var validation = Array.prototype.filter.call(forms, function(form) {
	            form.addEventListener('submit', function(event) {
	                if (form.checkValidity() === false) {
	                    event.preventDefault();
	                    event.stopPropagation();
	                }
	                form.classList.add('was-validated');
	            }, false);
	        });
	        $("."+ele).find("input[type=submit],button[type=submit]").removeAttr("disabled");
	    }, false);
	}

	/* Validation form chung */
	ValidationFormSelf("validation-form");

	/* onChange Category */
	function onchangeList()
    {
        var list = parseInt($("#id_list").val());
        var city = parseInt($("#id_city").val());
        var keyword = $("#keyword").val();
        var url = "<?=$linkFilter?>";

        if(list) url += "&id_list="+list;
        if(city) url += "&id_city="+city;
        if(keyword) url += "&keyword="+encodeURI(keyword);

        window.location = url;
    }
    function onchangeCat()
	{
		var list = parseInt($("#id_list").val());
		var cat = parseInt($("#id_cat").val());
		var city = parseInt($("#id_city").val());
		var district = parseInt($("#id_district").val());
		var keyword = $("#keyword").val();
		var url = "<?=$linkFilter?>";

		if(list) url += "&id_list="+list;
		if(cat) url += "&id_cat="+cat;
		if(city) url += "&id_city="+city;
		if(district) url += "&id_district="+district;
		if(keyword) url += "&keyword="+encodeURI(keyword);

		window.location = url;
	}
	function onchangeItem()
	{
		var list = parseInt($("#id_list").val());
		var cat = parseInt($("#id_cat").val());
		var item = parseInt($("#id_item").val());
		var city = parseInt($("#id_city").val());
		var district = parseInt($("#id_district").val());
		var wards = parseInt($("#id_wards").val());
		var keyword = $("#keyword").val();
		var url = "<?=$linkFilter?>";

		if(list) url += "&id_list="+list;
		if(cat) url += "&id_cat="+cat;
		if(item) url += "&id_item="+item;
		if(city) url += "&id_city="+city;
		if(district) url += "&id_district="+district;
		if(wards) url += "&id_wards="+wards;
		if(keyword) url += "&keyword="+encodeURI(keyword);

		window.location = url;
	}
	function onchangeSub()
	{
		var list = parseInt($("#id_list").val());
		var cat = parseInt($("#id_cat").val());
		var item = parseInt($("#id_item").val());
		var sub = parseInt($("#id_sub").val());
		var city = parseInt($("#id_city").val());
		var district = parseInt($("#id_district").val());
		var wards = parseInt($("#id_wards").val());
		var street = parseInt($("#id_street").val());
		var keyword = $("#keyword").val();
		var url = "<?=$linkFilter?>";

		if(list) url += "&id_list="+list;
		if(cat) url += "&id_cat="+cat;
		if(item) url += "&id_item="+item;
		if(sub) url += "&id_sub="+sub;
		if(city) url += "&id_city="+city;
		if(district) url += "&id_district="+district;
		if(wards) url += "&id_wards="+wards;
		if(street) url += "&id_street="+street;
		if(keyword) url += "&keyword="+encodeURI(keyword);

		window.location = url;
	}
	function onchangeOther()
	{
		var list = parseInt($("#id_list").val());
		var cat = parseInt($("#id_cat").val());
		var item = parseInt($("#id_item").val());
		var sub = parseInt($("#id_sub").val());
		var brand = parseInt($("#id_brand").val());
		var city = parseInt($("#id_city").val());
		var district = parseInt($("#id_district").val());
		var wards = parseInt($("#id_wards").val());
		var street = parseInt($("#id_street").val());
		var keyword = $("#keyword").val();
		var url = "<?=$linkFilter?>";

		if(list) url += "&id_list="+list;
		if(cat) url += "&id_cat="+cat;
		if(item) url += "&id_item="+item;
		if(sub) url += "&id_sub="+sub;
		if(brand) url += "&id_brand="+brand;
		if(city) url += "&id_city="+city;
		if(district) url += "&id_district="+district;
		if(wards) url += "&id_wards="+wards;
		if(street) url += "&id_street="+street;
		if(keyword) url += "&keyword="+encodeURI(keyword);

		window.location = url;
	}

	/* Action order */
	function actionOrder(url)
    {
    	var listid = "";
        var tinhtrang = parseInt($("#tinhtrang").val());
        var httt = parseInt($("#httt").val());
        var ngaydat = $("#ngaydat").val();
        var khoanggia = $("#khoanggia").val();
        var city = parseInt($("#city").val());
        var district = parseInt($("#district").val());
        var wards = parseInt($("#wards").val());
        var keyword = $("#keyword").val();

        $("input.select-checkbox").each(function(){
	        if(this.checked) listid = listid+","+this.value;
	    });
	    listid = listid.substr(1);
	    if(listid) url += "&listid="+listid;
        if(tinhtrang) url += "&tinhtrang="+tinhtrang;
        if(httt) url += "&httt="+httt;
        if(ngaydat) url += "&ngaydat="+ngaydat;
        if(khoanggia) url += "&khoanggia="+khoanggia;
        if(city) url += "&city="+city;
        if(district) url += "&district="+district;
        if(wards) url += "&wards="+wards;
        if(keyword) url += "&keyword="+encodeURI(keyword);

        window.location = url;
    }

	/* Search */
	function doEnter(evt,obj,url)
	{
		if(url=='')
		{
			notifyDialog("Đường dẫn không hợp lệ");
	        return false;
		}

	    if(evt.keyCode == 13 || evt.which == 13) onSearch(obj,url);
	}
	function onSearch(obj,url)
	{
	    var keyword = $("#"+obj).val();
	    var list = parseInt($("#id_list").val());
	    var cat = parseInt($("#id_cat").val());
	    var item = parseInt($("#id_item").val());
	    var sub = parseInt($("#id_sub").val());
	    var brand = parseInt($("#id_brand").val());

		if(url=='')
		{
			notifyDialog("Đường dẫn không hợp lệ");
	        return false;
		}

		if(list) url += "&id_list="+list;
		if(cat) url += "&id_cat="+cat;
		if(item) url += "&id_item="+item;
		if(sub) url += "&id_sub="+sub;
		if(brand) url += "&id_brand="+brand;

	    if(keyword=='')
	    {
	    	document.location = url;
	    }
	    else
	    {
	        document.location = url+"&keyword="+encodeURI(keyword);
	    }
	}

	/* Send email */
	function sendEmail()
	{
		var listemail="";

		$("input.select-checkbox").each(function(){
			if (this.checked) listemail = listemail+","+this.value;
		});
		listemail = listemail.substr(1);
		if(listemail == "")
	    {
	    	notifyDialog("Bạn hãy chọn ít nhất 1 mục để gửi");
	    	return false;
	    }
	    $("#listemail").val(listemail);
	    document.frmsendemail.submit();
	}

	/* Delete item */
	function deleteItem(url)
	{
	    document.location = url;
	}

	/* Delete all */
	function deleteAll(url)
	{
		var listid = "";

	    $("input.select-checkbox").each(function(){
	        if(this.checked) listid = listid+","+this.value;
	    });
	    listid = listid.substr(1);
	    if(listid == "")
	    {
	    	notifyDialog("Bạn hãy chọn ít nhất 1 mục để xóa");
	    	return false;
	    }
	    document.location = url+"&listid="+listid;
	}

	/* Delete filer */
	function deleteFiler(string)
	{
		var str = string.split(",");
		var id = str[0];
		var folder = str[1];
		var cmd = 'delete';

		$.ajax({
			type: 'POST',
			url: 'ajax/ajax_filer.php',
			data: {id:id,folder:folder,cmd:cmd}
		});

		$('.my-jFiler-item-'+id).remove();
		if($(".my-jFiler-items ul li").length==0) $(".form-group-gallery").remove();
	}

	/* Delete all filer */
	function deleteAllFiler(folder)
	{
		var listid = "";
		var cmd = 'delete-all';

	    $("input.filer-checkbox").each(function(){
	        if(this.checked) listid = listid+","+this.value;
	    });
	    listid = listid.substr(1);
	    if(listid == "")
	    {
	    	notifyDialog("Bạn hãy chọn ít nhất 1 mục để xóa");
	    	return false;
	    }

		$.ajax({
			type: 'POST',
			url: 'ajax/ajax_filer.php',
			data: {listid:listid,folder:folder,cmd:cmd}
		});

		listid = listid.split(",");
		for(var i=0;i<listid.length;i++)
		{
			$('.my-jFiler-item-'+listid[i]).remove();
		}

		if($(".my-jFiler-items ul li").length==0) $(".form-group-gallery").remove();
	}

	/* Create sort filer */
	var sortable;
	function createSortFiler()
	{
		sortable = new Sortable.create(document.getElementById('jFilerSortable'),{
			animation: 600,
			swap: true,
			disabled: true,
			// swapThreshold: 0.25,
		    ghostClass: 'ghostclass',
		    multiDrag: true,
			selectedClass: 'selected',
			forceFallback: false,
			fallbackTolerance: 3,
			onEnd: function(){
				/* Get all filer sort */
				listid = new Array();
				jFilerItems = $("#jFilerSortable").find('.my-jFiler-item');
				jFilerItems.each(function(index){
					listid.push($(this).data("id"));
				})

				/* Update number */
				var idmuc = <?=($id)?$id:0?>;
				var com = '<?=($com)?$com:""?>';
				var kind = '<?=($act)?$act:""?>';
				var type = '<?=($type)?$type:""?>';
				var colfiler = $(".col-filer").val();
				var actfiler = $(".act-filer").val();
				$.ajax({
					url: 'ajax/ajax_filer.php',
					type: 'POST',
					dataType: 'json',
					async: false,
					data: {idmuc:idmuc,listid:listid,com:com,kind:actfiler,type:type,colfiler:colfiler,cmd:'updateNumb'},
					success: function(result)
					{
						var arrid = result.id;
						var arrnumb = result.numb;
						for(var i=0;i<arrid.length;i++) $('.my-jFiler-item-'+arrid[i]).find("input[type=number]").val(arrnumb[i]);
					}
				})
			},
		});
	}

	/* Destroy sort filer */
	function destroySortFiler()
	{
		var destroy = sortable.destroy();
	}

	/* Push OneSignal */
	function pushOneSignal(url)
	{
		document.location = url;
	}

	/* Delete Attribute */
	function deleteAttribute(obj)
	{
		var id = obj.data("id");
		if(id)
		{
			$.ajax({
				type: 'POST',
				url: 'ajax/ajax_attribute.php',
				data: {id:id}
			});
			$(".item-attribute-"+id).remove();
		}
		else
		{
			obj.parents(".item-attribute").remove();
		}
	}

	/* HoldOn */
	function holdonOpen(theme="sk-rect",text="Text here",backgroundColor="rgba(0,0,0,0.8)",textColor="white")
	{
		var options = {
			theme: theme,
			message: text,
			backgroundColor: backgroundColor,
			textColor: textColor
		};

		HoldOn.open(options);
	}
	function holdonClose()
	{
		HoldOn.close();
	}

	/* Sweet Alert - Notify */
	function notifyDialog(text)
	{
		const swalconst = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-sm bg-gradient-primary text-sm',
			},
			buttonsStyling: false
		})
		swalconst.fire({
			text: text,
			confirmButtonText: '<i class="fas fa-check mr-2"></i>Đồng ý',
			showClass: {
				popup: 'animated fadeInDown faster'
			},
			hideClass: {
				popup: 'animated fadeOutUp faster'
			}
		})
	}

	/* Sweet Alert - Confirm */
	function confirmDialog(action,text,value)
	{
		const swalconst = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-sm bg-gradient-primary text-sm mr-2',
				cancelButton: 'btn btn-sm bg-gradient-danger text-sm'
			},
			buttonsStyling: false
		})
		swalconst.fire({
			text: text,
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: '<i class="fas fa-check mr-2"></i>Đồng ý',
			cancelButtonText: '<i class="fas fa-times mr-2"></i>Hủy',
			showClass: {
				popup: 'animated fadeInDown faster'
			},
			hideClass: {
				popup: 'animated fadeOutUp faster'
			}
		}).then((result) => {
			if(result.value)
			{
				if(action == "create-seo") seoCreate();
				if(action == "push-onesignal") pushOneSignal(value);
				if(action == "send-email") sendEmail();
				if(action == "delete-attribute") deleteAttribute(value);
				if(action == "delete-filer") deleteFiler(value);
				if(action == "delete-all-filer") deleteAllFiler(value);
				if(action == "delete-item") deleteItem(value);
				if(action == "delete-all") deleteAll(value);
			}
		})
	}

	/* Youtube preview */
	function youtubePreview(url,element)
	{
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    	var match = url.match(regExp);
    	url = (match&&match[7].length==11)? match[7] : false;
        $(element).attr("src","//www.youtube.com/embed/"+url).css({"width": "250","height": "150"});
	}

	/* SEO */
	function seoExist()
	{
		var inputs = $('.card-seo input.check-seo');
		var textareas = $('.card-seo textarea.check-seo');
		var flag = false;

		if(!flag)
		{
			inputs.each(function(index){
				var input = $(this).attr('id');
				value = $("#"+input).val();
				if(value)
				{
					flag = true;
					return false;
				}
			});
		}

		if(!flag)
		{
			textareas.each(function(index){
				var textarea = $(this).attr('id');
				value = $("#"+textarea).val();
				if(value)
				{
					flag = true;
					return false;
				}
			});
		}

		return flag;
	}
	function seoCreate()
	{
		var flag = true;
		var seolang = "<?=$config['website']['seo']['preview']?>";
		var seolangArray = seolang.split(",");
		var seolangCount = seolangArray.length;
		var inputArticle = $('.card-article input.for-seo');
		var textareaArticle = $('.card-article textarea.for-seo');
		var textareaArticleCount = textareaArticle.length;
		var count = 0;
		var inputSeo = $('.card-seo input.check-seo');
		var textareaSeo = $('.card-seo textarea.check-seo');

		/* SEO Create - Input */
		inputArticle.each(function(index){
			var input = $(this).attr('id');
			var lang = input.substr(input.length-2);
			if(seolang.indexOf(lang)>=0)
			{
				ten = $("#"+input).val();
				ten = ten.substr(0,70);
				ten = ten.trim();
				$("#title"+lang+", #keywords"+lang).val(ten);
				seoCount($("#title"+lang));
				seoCount($("#keywords"+lang));
			}
		});

		/* SEO Create - Textarea */
		textareaArticle.each(function(index){
			var textarea = $(this).attr('id');
			var lang = textarea.substr(textarea.length-2);
			if(seolang.indexOf(lang)>=0)
			{
				if(flag)
				{
					var content = $("#"+textarea).val();

					if(!content && CKEDITOR.instances[textarea])
					{
						content = CKEDITOR.instances[textarea].getData();
					}

					if(content)
					{
						content = content.replace(/(<([^>]+)>)/ig,"");
						content = content.substr(0,160);
						content = content.trim();
						content = content.replace(/[\r\n]+/gm," ");
						$("#description"+lang).val(content);
						seoCount($("#description"+lang));
						flag = false;
					}
					else
					{
						flag = true;
					}
				}
				count++;
				if(count == (textareaArticleCount/seolangCount))
				{
					flag = true;
					count = 0;
				}
			}
		});

		/* SEO Preview */
		for(var i=0;i<seolangArray.length;i++) if(seolangArray[i]) seoPreview(seolangArray[i]);
	}
	function seoPreview(lang)
	{
		var titlePreview = "#title-seo-preview"+lang;
		var descriptionPreview = "#description-seo-preview"+lang;
		var title = $("#title"+lang).val();
		var description = $("#description"+lang).val();

		if($(titlePreview).length)
		{
			if(title) $(titlePreview).html(title);
			else $(titlePreview).html("Title");
		}

		if($(descriptionPreview).length)
		{
			if(description) $(descriptionPreview).html(description);
			else $(descriptionPreview).html("Description");
		}
	}
	function seoCount(obj)
	{
		var countseo = parseInt(obj.val().toString().length);
		countseo = (countseo) ? countseo++ : 0;
		obj.parents("div.form-group").children("div.label-seo").find(".count-seo span").html(countseo);
	}
	function seoChange()
	{
		var seolang = "<?=$config['website']['seo']['preview']?>";
		var elementSeo = $('.card-seo .check-seo');

		elementSeo.each(function(index){
			var element = $(this).attr('id');
			var lang = element.substr(element.length-2);
			if(seolang.indexOf(lang)>=0)
			{
				if($("#"+element).length)
				{
					$('body').on("keyup","#"+element,function(){
						seoPreview(lang);
					})
				}
			}
		});
	}

	/* Slug */
	function slugReset(lang)
	{
		$(".alert-slug"+lang).addClass("d-none");
	}
	function slugPreview(slug,lang,preview,self,status)
	{
		var slugnow = $("#slug"+lang).val();
		if(preview || status == 'old') $("#slug"+lang).val(slug);
		if(preview || self || status == 'old') $("#slugurlpreview"+lang+" strong").html(slug);
		if(!slugnow || preview || self || status == 'old') $("#seourlpreview"+lang+" strong").html(slug);
	}
	function slugAlert(error,lang,preview,self,status)
	{
		if(preview || self || status == 'old')
		{
			if(error == 1)
			{
				$("#alert-slug-warning"+lang).removeClass("d-none");
				$("#alert-slug-success"+lang).addClass("d-none");
			}
			else if(error == 2)
			{
				$("#alert-slug-warning"+lang).addClass("d-none");
				$("#alert-slug-success"+lang).removeClass("d-none");
			}
			else if(error == 3)
			{
				$("#alert-slug-warning"+lang).addClass("d-none");
				$("#alert-slug-success"+lang).addClass("d-none");
			}
		}
	}
	function slugPress()
	{
		var sluglang = "<?=$config['website']['slug']['preview']?>";
		var inputArticle = $('.card-article input.for-seo');

		inputArticle.each(function(index){
			var ten = $(this).attr('id');
			var lang = ten.substr(ten.length-2);
			if(sluglang.indexOf(lang)>=0)
			{
				if($("#"+ten).length)
				{
					$('body').on("keyup","#"+ten,function(){
						var title = $("#"+ten).val();

						/* Check slug qua các table */
						slugCheck(title,lang,"input","new");
					})
				}

				if($("#slug"+lang).length)
				{
					$('body').on("keyup","#slug"+lang,function(){
						var title = $("#slug"+lang).val();

						/* Check slug qua các table */
						slugCheck(title,lang,"slug","new");
					})
				}
			}
		});
	}
	function slugChange(obj)
	{
		if(obj.is(':checked'))
		{
			$(".slug-hidden").attr("data-preview",1);
			$(".slugchange").attr("readonly",true);

			/* Load slug theo tiêu đề mới */
			slugStatus("new");
		}
		else
		{
			$(".slug-hidden").attr("data-preview",0);
			$(".slugchange").attr("readonly",false);

			/* Load slug theo tiêu đề cũ */
			slugStatus("old");
		}
	}
	function slugStatus(status)
	{
		var sluglang = "<?=$config['website']['slug']['preview']?>";
		var inputArticle = $('.card-article input.for-seo');

		inputArticle.each(function(index){
			var ten = $(this).attr('id');
			var lang = ten.substr(ten.length-2);
			if(sluglang.indexOf(lang)>=0)
			{
				if($("#"+ten).length)
				{
					title = $("#"+ten).val();

					/* Check slug qua các table */
					slugCheck(title,lang,"input",status);
				}
			}
		});
	}
	function slugCheck(title,lang,type,status)
	{
		var com = $(".slug-hidden").attr("data-com");
		var act = $(".slug-hidden").attr("data-act");
		var id = $(".slug-hidden").attr("data-id");
		
		/* Slug preview */
		var preview = parseInt($(".slug-hidden").attr("data-preview"));

		/* Slug self */
		if(type == "slug") var self = parseInt($("#slug"+lang).attr("data-self"));
		else var self = 0;

		/* Slug check data */
		if(title)
		{
			$.ajax({
				url: 'ajax/ajax_slug.php',
				type: 'POST',
				dataType: 'json',
				async: false,
				data: {title:title,status:status,lang:lang,com:com,act:act,id:id},
				success: function(result){
					slugAlert(result.error,lang,preview,self,status);
					slugPreview(result.slug,lang,preview,self,status);
				}
			});
		}
		else
		{
			slugReset(lang);
		}
	}

	/* Reader image */
	function readImage(inputFile,elementPhoto)
	{
		if(inputFile[0].files[0])
		{
			if(inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif)$/i))
			{
				var size = parseInt(inputFile[0].files[0].size) / 4096;

				if(size <= 4096)
				{
					var reader = new FileReader();
					reader.onload = function(e){
						$(elementPhoto).attr('src', e.target.result);
					}
					reader.readAsDataURL(inputFile[0].files[0]);
				}
				else
				{
					notifyDialog("Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB");
					return false;
				}
			}
			else
			{
				notifyDialog("Hình ảnh không hợp lệ");
				return false;
			}
		}
		else
		{
			notifyDialog("Dữ liệu không hợp lệ");
			return false;
		}
	}

	$(document).ready(function(){
		/* Select 2 */
		$('.select2').select2();

		/* Format price */
		$(".format-price").priceFormat({
			limit: 13,
			prefix: '',
			centsLimit: 0
		});

		/* PhotoZone */
		if($("#photo-zone").length)
		{
			/* Drag over */
			$("#photo-zone").on("dragover",function(){
				$(this).addClass("drag-over");
				return false;
			});

			/* Drag leave */
			$("#photo-zone").on("dragleave",function(){
				$(this).removeClass("drag-over");
				return false;
			});

			/* Drop */
			$("#photo-zone").on("drop",function(e){
				e.preventDefault();
				$(this).removeClass("drag-over");

				var lengthZone = e.originalEvent.dataTransfer.files.length;

				if(lengthZone == 1)
				{
					$("#file-zone").prop("files", e.originalEvent.dataTransfer.files);
					readImage($("#file-zone"),".photoUpload-detail img");
				}
				else if(lengthZone > 1)
				{
					notifyDialog("Bạn chỉ được chọn 1 hình ảnh để upload");
					return false;
				}
				else
				{
					notifyDialog("Dữ liệu không hợp lệ");
					return false;
				}
			});

			/* File zone */
			$("#file-zone").change(function(){
				readImage($(this),".photoUpload-detail img");
			});
		}

		/* Sumoselect */
		window.asd = $('.multiselect').SumoSelect({
			selectAll: true,
			search: true,
			searchText: 'Tìm kiếm'
		});

		/* Ckeditor */
		$(".form-control-ckeditor").each(function(){
			var id = $(this).attr("id");
			CKEDITOR.replace(id);
		})

		/* Ajax category */
		$('body').on('change','.select-category', function(){
			var id = $(this).val();
			var child = $(this).data("child");
			var level = parseInt($(this).data('level'));
			var table = $(this).data('table');
			var type = $(this).data('type');

			if($("#"+child).length)
			{
				$.ajax({
					url: 'ajax/ajax_category.php',
					type: 'POST',
					data: {level:level,id:id,table:table,type:type},
					success: function(result)
					{
						var op = "<option value=''>Chọn danh mục</option>";

						if(level == 0)
						{
							$("#id_cat").html(op);
							$("#id_item").html(op);
							$("#id_sub").html(op);
						}
						else if(level == 1)
						{
							$("#id_item").html(op);
							$("#id_sub").html(op);
						}
						else if(level == 2)
						{
							$("#id_sub").html(op);
						}
						$("#"+child).html(result);
					}
				});

				return false;
			}
		});

		/* Ajax place */
		$('body').on('change','.select-place', function(){
			var id = $(this).val();
			var child = $(this).data("child");
			var level = parseInt($(this).data('level'));
			var table = $(this).data('table');

			$.ajax({
				url: 'ajax/ajax_place.php',
				type: 'POST',
				data: {level:level,id:id,table:table},
				success: function(result)
				{
					var op = "<option value=''>Chọn danh mục</option>";

					if(level == 0)
					{
						$("#district").html(op);
						$("#wards").html(op);
						$("#street").html(op);
					}
					else if(level == 1)
					{
						$("#wards").html(op);
						$("#street").html(op);
					}
					$("#"+child).html(result);
				}
			});

			return false;
		});

		/* Check required form */
		$('.submit-check').click(function(event){
			var element = $('.card-article :required:invalid');
			var $this;

			if(element.length)
			{
				if($('.card').hasClass('collapsed-card'))
				{
					$('.card.collapsed-card .card-body').show();
					$('.card.collapsed-card .btn-tool i').toggleClass('fas fa-plus fas fa-minus');
					$('.card.collapsed-card').removeClass('collapsed-card');
				}

				element.each(function(){
					$this = $(this);
					var closest = element.closest('.tab-pane');
					var id = closest.attr('id');

					$('.nav-tabs a[href="#'+id+'"]').tab('show');

					return false;
				});
				
				setTimeout(function(){
					$('html,body').animate({scrollTop: $this.offset().top - 90},'medium');
				},500)
			}
		});


		/* Attribute */
		$('body').on('click','.add-attribute', function(){
			$html = $("#attribute-temp").html();
			$(".grid-attribute").append($html);
		})
		$('body').on('click','.delete-attribute', function(){
			confirmDialog("delete-attribute","Bạn có chắc muốn xóa mục này ?",$(this));
		})

	    /* Push oneSignal */
		$('body').on('click','#push-onesignal', function(){
			var url = $(this).data("url");
			confirmDialog("push-onesignal","Bạn muốn đẩy tin này ?",url);
	    });

	    /* Send email */
		$('body').on('click','#send-email', function(){
			confirmDialog("send-email","Bạn muốn gửi thông tin cho các mục đã chọn ?","");
	    });

	    /* Check item */
	    var lastChecked = null;
	    var $checkboxItem = $(".select-checkbox");

	    $checkboxItem.click(function(e){
	    	if(!lastChecked)
	    	{
	    		lastChecked = this;
	    		return;
	    	}

	    	if(e.shiftKey)
	    	{
	    		var start = $checkboxItem.index(this);
	    		var end = $checkboxItem.index(lastChecked);
	    		$checkboxItem.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', true);
	    	}

	    	lastChecked = this;
	    });

		/* Check all */
		$('body').on('click','#selectall-checkbox', function(){
			var parentTable = $(this).parents('table');
			var input = parentTable.find('input.select-checkbox');

			if($(this).is(':checked'))
			{
				input.each(function(){
					$(this).prop('checked',true);
				});
			}
			else
			{
				input.each(function(){
					$(this).prop('checked',false); 
				});
			}
		});

	    /* Delete item */
		$('body').on('click','#delete-item', function(){
			var url = $(this).data("url");
			confirmDialog("delete-item","Bạn có chắc muốn xóa mục này ?",url);
	    });

	    /* Delete all */
		$('body').on('click','#delete-all', function(){
			var url = $(this).data("url");
			confirmDialog("delete-all","Bạn có chắc muốn xóa những mục này ?",url);
	    });

		/* Load name input file */
		$('body').on('change','.custom-file input[type=file]', function(){
			var fileName = $(this).val();
			fileName = fileName.substr(fileName.lastIndexOf('\\') + 1, fileName.length);
			$(this).siblings('label').html(fileName);
			$(this).parents("div.form-group").children(".change-photo").find("b.text-sm").html(fileName);
			$(this).parents("div.form-group").children(".change-file").find("b.text-sm").html(fileName);
		});

		/* Change status */
		$('body').on('click','.show-checkbox',function(){
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');
			var loai = $(this).attr('data-loai');
			var $this = $(this);

			$.ajax({
				url: 'ajax/ajax_status.php',
				type: 'POST',
				dataType: 'html',
				data: {id:id,table:table,loai:loai},
				success: function()
				{
					if($this.is(':checked')) $this.prop('checked',false);
					else $this.prop('checked',true); 
				}
			});

			return false;
		})

		/* Change stt */
		$('body').on("change","input.update-stt",function(){
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');
			var value = $(this).val();

			$.ajax({
				url: 'ajax/ajax_stt.php',
				type: 'POST',
				dataType: 'html',
				data: {id:id,table:table,value:value}
			});

			return false;
		})

		/* Slug */
		slugPress();
		$('body').on("click","#slugchange-checkbox",function(){
			slugChange($(this));
		})

		/* SEO */
		seoChange();
		$('body').on("keyup",".title-seo, .keywords-seo, .description-seo",function(){
			seoCount($(this));
		})
		$('body').on("click",".create-seo",function(){
			if(seoExist()) confirmDialog("create-seo","Nội dung SEO đã được thiết lập. Bạn muốn tạo lại nội dung SEO ?","");
			else seoCreate();
		})

		/* Copy */
		$('body').on("click",".copy-now",function(){
			var id = $(this).attr('data-id');
			var table = $(this).attr('data-table');

			holdonOpen("sk-rect","Vui lòng chờ...","rgba(0,0,0,0.8)","white");
			$.ajax({
				url: 'ajax/ajax_copy.php',
				type: 'POST',
				dataType: 'html',
				async: false,
				data: {id:id,table:table},
				success: function(){
					holdonClose();
				}
			});

			window.location.reload(true);
		})

		<?php if($flagGallery && count($gallery)) { ?>
			/* Sort filer */
			createSortFiler();
		<?php } ?>

		/* Check all filer */
		$('body').on('click','.check-all-filer', function(){
			var parentFiler = $(".my-jFiler-items .jFiler-items-list");
			var input = parentFiler.find('input.filer-checkbox');
			var jFilerItems = $("#jFilerSortable").find('.my-jFiler-item');

			$(this).find("i").toggleClass("far fa-square fas fa-check-square");
			if($(this).hasClass('active'))
			{
				$(this).removeClass('active');
				$(".sort-filer").removeClass("active");
				$(".sort-filer").attr('disabled',false);
				input.each(function(){
					$(this).prop('checked',false); 
				});
			}
			else
			{
				sortable.option("disabled",true);
				$(this).addClass('active');
				$(".sort-filer").attr('disabled',true);
				$(".alert-sort-filer").hide();
				$(".my-jFiler-item-trash").show();
				input.each(function(){
					$(this).prop('checked',true);
				});
				jFilerItems.each(function(){
					$(this).find('input').attr('disabled',false);
				});
				jFilerItems.each(function(){
					$(this).removeClass('moved');
				});
			}
		});
		
		/* Check filer */
		$('body').on('click','.filer-checkbox',function(){
			var input = $(".my-jFiler-items .jFiler-items-list").find('input.filer-checkbox:checked');

			if(input.length) $(".sort-filer").attr('disabled',true);
			else $(".sort-filer").attr('disabled',false);
		})

		/* Sort filer */
		$('body').on('click','.sort-filer', function(){
			var jFilerItems = $("#jFilerSortable").find('.my-jFiler-item');

			if($(this).hasClass('active'))
			{
				sortable.option("disabled",true);
				$(this).removeClass('active');
				$(".alert-sort-filer").hide();
				$(".my-jFiler-item-trash").show();
				jFilerItems.each(function(){
					$(this).find('input').attr('disabled',false);
					$(this).removeClass('moved');
				});
			}
			else
			{
				sortable.option("disabled",false);
				$(this).addClass('active');
				$(".alert-sort-filer").show();
				$(".my-jFiler-item-trash").hide();
				jFilerItems.each(function(){
					$(this).find('input').attr('disabled',true);
					$(this).addClass('moved');
				});
			}
		});

		/* Delete filer */
        $(".my-jFiler-item-trash").click(function(){
			var id = $(this).data("id");
			var folder = $(this).data("folder");
			var str = id+","+folder;
			confirmDialog("delete-filer","Bạn có chắc muốn xóa hình ảnh này ?",str);
        });

        /* Delete all filer */
		$(".delete-all-filer").click(function(){
			var folder = $(this).data("folder");
			confirmDialog("delete-all-filer","Bạn có chắc muốn xóa các hình ảnh đã chọn ?",folder);
        });

        /* Change info filer */
        $('body').on('change','.my-jFiler-item-info', function(){
			var id = $(this).data("id");
			var info = $(this).data("info");
			var value = $(this).val();
			var idmuc = <?=($id)?$id:0?>;
			var com = '<?=($com)?$com:""?>';
			var kind = '<?=($act)?$act:""?>';
			var type = '<?=($type)?$type:""?>';
			var colfiler = $(".col-filer").val();
			var actfiler = $(".act-filer").val();
			var cmd = 'info';

			$.ajax({
				type: 'POST',
				dataType: 'html',
				url: 'ajax/ajax_filer.php',
				async: false,
				data: {id:id,idmuc:idmuc,info:info,value:value,com:com,kind:actfiler,type:type,colfiler:colfiler,cmd:cmd},
				success: function(result)
				{
					destroySortFiler();
					$("#jFilerSortable").html(result);
					createSortFiler();
				}
			});

			return false;
        });

		/* Filer */
		$("#filer-gallery").filer({
            limit: null,
            maxSize: null,
            extensions: ["jpg","gif","png","jpeg","gif","JPG","PNG","JPEG","Png","GIF"],
            changeInput: '<a class="jFiler-input-choose-btn border-primary btn btn-sm bg-gradient-primary text-white mb-3"><i class="fas fa-cloud-upload-alt mr-2"></i>Upload hình ảnh</a>',
            showThumbs: true,
            theme: "default",
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid row scroll-bar"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-thumb-overlay">\
                                            <div class="jFiler-item-info">\
                                                <div style="display:table-cell;vertical-align: middle;">\
                                                    <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                    <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li>{{fi-progressBar}}</li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                    <input type="number" class="form-control form-control-sm mb-1" name="stt-filer[]" placeholder="Số thứ tự"/>\
                                    <input type="text" class="form-control form-control-sm" name="ten-filer[]" placeholder="Tiêu đề"/>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                                <div class="jFiler-item-container">\
                                    <div class="jFiler-item-inner">\
                                        <div class="jFiler-item-thumb">\
                                            <div class="jFiler-item-status"></div>\
                                            <div class="jFiler-item-thumb-overlay">\
                                                <div class="jFiler-item-info">\
                                                    <div style="display:table-cell;vertical-align: middle;">\
                                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
                                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                            {{fi-image}}\
                                        </div>\
                                        <div class="jFiler-item-assets jFiler-row">\
                                            <ul class="list-inline pull-left">\
                                                <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                            </ul>\
                                            <ul class="list-inline pull-right">\
                                                <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                            </ul>\
                                        </div>\
                                        <input type="number" class="form-control form-control-sm mb-1" name="stt-filer[]" placeholder="Số thứ tự"/>\
                                    	<input type="text" class="form-control form-control-sm" name="ten-filer[]" placeholder="Tiêu đề"/>\
                                    </div>\
                                </div>\
                            </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                canvasImage: false,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            },
            afterShow: function(){
            	$(".jFiler-items-list li.jFiler-item").each(function(index){
            		var colClass = $(".col-filer").val();
            		if(!$(this).hasClass(colClass)) $("li.jFiler-item").addClass(colClass);
            		$(this).find("input[type=number]").val(index+1);
            	});
            },
            addMore: true,
            allowDuplicates: false,
            clipBoardPaste: false,
            captions: {
                button: "Thêm hình",
                feedback: "Vui lòng chọn hình ảnh",
                feedback2: "Những hình đã được chọn",
                drop: "Kéo hình vào đây để upload",
                removeConfirmation: "Bạn muốn loại bỏ hình ảnh này ?",
                errors: {
                    filesLimit: "Chỉ được upload mỗi lần {{fi-limit}} hình ảnh",
                    filesType: "Chỉ hỗ trợ tập tin là hình ảnh",
                    filesSize: "Hình {{fi-name}} có kích thước quá lớn. Vui lòng upload hình ảnh có kích thước tối đa {{fi-maxSize}} MB.",
                    filesSizeAll: "Những hình ảnh bạn chọn có kích thước quá lớn. Vui lòng chọn những hình ảnh có kích thước tối đa {{fi-maxSize}} MB."
                }
            }
        });
	});
</script>

<?php if($addAttribute) { ?>
	<!-- Template attribute -->
	<script type="html/template" id="attribute-temp">
		<div class="item-attribute col-xl-3 col-sm-4">
			<div class="alert my-alert alert-info">
				<div class="info-attribute">
					<label class="label-attribute">
						<strong>STT:</strong>
						<input type="number" class="form-control form-control-sm" name="attribute[stt][]" placeholder="STT" required>
					</label>
					<div class="info-attribute">
						<?php foreach($config['website']['lang'] as $k => $v) { ?>
							<div class="lang-attribute">
								<input type="text" class="form-control form-control-sm title-attribute" name="attribute[tieude<?=$k?>][]" placeholder="Tiêu đề (<?=$v?>)" <?=($k=='vi')?'required':''?>>
								<input type="text" class="form-control form-control-sm value-attribute" name="attribute[giatri<?=$k?>][]" placeholder="Giá trị (<?=$v?>)" <?=($k=='vi')?'required':''?>>
							</div>
						<?php } ?>
					</div>
				</div>
				<a class="delete-attribute"><i class="fas fa-times"></i></a>
			</div>
		</div>
	</script>
<?php } ?>