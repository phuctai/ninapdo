function modalNotify(text)
{
    $("#popup-notify").find(".modal-body").html(text);
    $('#popup-notify').modal('show');
}
function ValidationFormSelf(ele)
{
    window.addEventListener('load', function() {
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
        $("."+ele).find("input[type=submit]").removeAttr("disabled");
    }, false);
}
function add_to_cart(id,kind)
{
    var mau = $("input[name=color-pro-detail]:checked").val();
    var size = $("input[name=size-pro-detail]:checked").val();
    if(mau == undefined) mau=0;
    if(size == undefined) size=0;
    var qty = $(".qty-pro").val();

    $.ajax({
        url:'ajax/ajax_add_cart.php',
        type: "POST",
        dataType: 'json',
        async: false,
        data: {cmd:'addcart',id:id,mau:mau,size:size,qty:qty},
        success: function(result){
            if(kind=='addnow')
            {
                $('.count-cart').html(result.countcart);
                $.ajax({
                    url:'ajax/ajax_popup_cart.php',
                    type: "POST",
                    dataType: 'html',
                    async: false,
                    success: function(result){
                        $("#popup-cart .modal-body").html(result);
                        $('#popup-cart').modal('show');
                    }
                });
            }
            else if(kind=='buynow')
            {
                window.location = CONFIG_BASE + "gio-hang";
            }
        }
    });
}
function loadPagingAjax(url,eShow='',rowCount=0)
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
function doEnter(evt,obj)
{
    if(evt.keyCode == 13 || evt.which == 13) onSearch(obj);
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