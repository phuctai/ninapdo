function modalNotify(text)
{
    $("#popup-notify").find(".modal-body").html(text);
    $('#popup-notify').modal('show');
}

function ValidationFormSelf(ele='')
{
    if(ele)
    {
        $("."+ele).find("input[type=submit]").removeAttr("disabled");
        var forms = document.getElementsByClassName(ele);
        var validation = Array.prototype.filter.call(forms,function(form){
            form.addEventListener('submit', function(event){
                if(form.checkValidity() === false)
                {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }
}

function loadPagingAjax(url='',eShow='',rowCount=0)
{
    if($(eShow).length && url)
    {
        $.ajax({
            url: url,
            type: "GET",
            data: {
                rowCount: rowCount,
                perpage: 8,
                eShow: eShow
            },
            success: function(result){
                $(eShow).html(result);
            }
        });
    }
}

function doEnter(event,obj)
{
    if(event.keyCode == 13 || event.which == 13) onSearch(obj);
}

function onSearch(obj) 
{           
    var keyword = $("#"+obj).val();
    
    if(keyword=='')
    {
        modalNotify(LANG['no_keywords']);
        return false;
    }
    else
    {
        location.href = "tim-kiem?keyword="+encodeURI(keyword);
        loadPage(document.location);            
    }
}

function ResizeWebsite()
{
    $(".footer").css({marginBottom:$(".toolbar").innerHeight()});
}

function update_cart(pid=0,code='',quantity=1)
{
    if(pid)
    {
        var ship = $(".price-ship").val();
        var endow = $(".price-endow").val();

        $.ajax({
            type: "POST",
            url: "ajax/ajax_update_cart.php",
            dataType: 'json',
            data: {pid:pid,code:code,q:quantity,ship:ship,endow:endow},
            success: function(result){
                if(result)
                {
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
}

function load_district(id=0)
{
    $.ajax({
        type: 'post',
        url: 'ajax/ajax_district.php',
        data: {id_city:id},
        success: function(result){
            load_ship();
            $(".select-district").html(result);
            $(".select-wards").html('<option value="">'+LANG['wards']+'</option>');
        }
    });
}

function load_wards(id=0)
{
    $.ajax({
        type: 'post',
        url: 'ajax/ajax_wards.php',
        data: {id_district:id},
        success: function(result){
            load_ship();
            $(".select-wards").html(result);
        }
    });
}

function load_ship(id=0)
{
    if(SHIP_CART)
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
}