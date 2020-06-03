<!-- Main Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 text-sm">
    <!-- Logo -->
    <a class="brand-link" href="index.php">
        <img class="brand-image" src="assets/images/nina.png" alt="Nina">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Bảng điều khiển -->
                <?php
                    $active = "";
                    if($com=='index' || $com=='') $active = 'active';
                ?>
                <li class="nav-item <?=$active?>">
                    <a class="nav-link <?=$active?>" href="index.php" title="Bảng điều khiển">
                        <i class="nav-icon text-sm fas fa-tachometer-alt"></i>
                        <p>Bảng điều khiển</p>
                    </a>
                </li>

                <!-- Sản phẩm -->
                <?php if(count($config['product'])>0) { ?>
                    <?php foreach($config['product'] as $k => $v) { ?>
                        <?php
                            $none = "";
                            $active = "";
                            $menuopen = "";
                            if($kiemtra) if(check_access('product','man_list',$k) && check_access('product','man_cat',$k) && check_access('product','man_item',$k) && check_access('product','man_sub',$k) && check_access('product','man_brand',$k) && check_access('product','man',$k) && check_access('import','man',$k) && check_access('export','man',$k)) $none = "d-none";
                            if((($com=='product') || ($com=='import') || ($com=='export')) && ($k==$_GET['type']))
                            {
                                $active = 'active';
                                $menuopen = 'menu-open';
                            }
                        ?>
                        <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                            <a class="nav-link <?=$active?>" href="#" title="Quản lý <?=$v['title_main']?>">
                                <i class="nav-icon text-sm fas fa-boxes"></i>
                                <p>
                                    Quản lý <?=$v['title_main']?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if($v['list']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_list',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_list' || $act=='add_list' || $act=='edit_list' || $kind=='man_list') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_list&type=<?=$k?>" title="Danh mục cấp 1"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 1</p></a></li>
                                <?php } ?>
                                <?php if($v['cat']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_cat',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_cat' || $act=='add_cat' || $act=='edit_cat' || $kind=='man_cat') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_cat&type=<?=$k?>" title="Danh mục cấp 2"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 2</p></a></li>
                                <?php } ?>
                                <?php if($v['item']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_item',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_item' || $act=='add_item' || $act=='edit_item' || $kind=='man_item') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_item&type=<?=$k?>" title="Danh mục cấp 3"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 3</p></a></li>
                                <?php } ?>
                                <?php if($v['sub']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_sub',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_sub' || $act=='add_sub' || $act=='edit_sub' || $kind=='man_sub') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_sub&type=<?=$k?>" title="Danh mục cấp 4"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 4</p></a></li>
                                <?php } ?>
                                <?php if($v['brand']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_brand',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_brand' || $act=='add_brand' || $act=='edit_brand') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_brand&type=<?=$k?>" title="Danh mục hãng"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục hãng</p></a></li>
                                <?php } ?>
                                <?php if($v['mau']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_mau',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_mau' || $act=='add_mau' || $act=='edit_mau') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_mau&type=<?=$k?>" title="Danh mục màu sắc"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục màu sắc</p></a></li>
                                <?php } ?>
                                <?php if($v['size']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man_size',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man_size' || $act=='add_size' || $act=='edit_size') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man_size&type=<?=$k?>" title="Danh mục kích thước"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục kích thước</p></a></li>
                                <?php } ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('product','man',$k)) $none = "d-none";
                                    if($com=='product' && ($act=='man' || $act=='add' || $act=='edit' || $kind=='man') && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=product&act=man&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a></li>
                                <?php if($v['import']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('import','man',$k)) $none = "d-none";
                                    if(($com=='import') && ($k==$_GET['type'])) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>">
                                        <a class="nav-link <?=$active?>" href="index.php?com=import&act=man&type=<?=$k?>" title="Import"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Import</p></a>
                                    </li>
                                <?php } ?>
                                <?php if($v['export']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('export','man',$k)) $none = "d-none";
                                    if(($com=='export') && ($act=='man') && ($k==$_GET['type'])) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>">
                                        <a class="nav-link <?=$active?>" href="index.php?com=export&act=man&type=<?=$k?>" title="Export"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Export</p></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                <?php } ?>

                <!-- Bài viết (Có cấp) -->
                <?php if(count($config['news'])) { ?>
                    <?php foreach($config['news'] as $k => $v) { if($v['dropdown']) { ?>
                        <?php
                            $none = "";
                            $active = "";
                            $menuopen = "";
                            if($kiemtra) if(check_access('news','man_list',$k) && check_access('news','man_cat',$k) && check_access('news','man_item',$k) && check_access('news','man_sub',$k) && check_access('news','man',$k)) $none = "d-none";
                            if(($com=='news') && ($k==$_GET['type']))
                            {
                                $active = 'active';
                                $menuopen = 'menu-open';
                            }
                        ?>
                        <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                            <a class="nav-link <?=$active?>" href="#" title="Quản lý <?=$v['title_main']?>">
                                <i class="nav-icon text-sm fas fa-book"></i>
                                <p>
                                    Quản lý <?=$v['title_main']?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if($v['list']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('news','man_list',$k)) $none = "d-none";
                                    if($com=='news' && ($act=='man_list' || $act=='add_list' || $act=='edit_list' || $kind=='man_list' || $kind=='man_list') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=news&act=man_list&type=<?=$k?>" title="Danh mục cấp 1"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 1</p></a></li>
                                <?php } ?>
                                <?php if($v['cat']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('news','man_cat',$k)) $none = "d-none";
                                    if($com=='news' && ($act=='man_cat' || $act=='add_cat' || $act=='edit_cat' || $kind=='man_cat' || $kind=='man_cat') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=news&act=man_cat&type=<?=$k?>" title="Danh mục cấp 2"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 2</p></a></li>
                                <?php } ?>
                                <?php if($v['item']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('news','man_item',$k)) $none = "d-none";
                                    if($com=='news' && ($act=='man_item' || $act=='add_item' || $act=='edit_item' || $kind=='man_item' || $kind=='man_item') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=news&act=man_item&type=<?=$k?>" title="Danh mục cấp 3"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 3</p></a></li>
                                <?php } ?>
                                <?php if($v['sub']) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('news','man_sub',$k)) $none = "d-none";
                                    if($com=='news' && ($act=='man_sub' || $act=='add_sub' || $act=='edit_sub' || $kind=='man_sub' || $kind=='man_sub') && $k==$_GET['type']) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=news&act=man_sub&type=<?=$k?>" title="Danh mục cấp 4"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Danh mục cấp 4</p></a></li>
                                <?php } ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('news','man',$k)) $none = "d-none";
                                    if($com=='news' && ($act=='man' || $act=='add' || $act=='edit' || $kind=='man') && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>"><a class="nav-link <?=$active?>" href="index.php?com=news&act=man&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a></li>
                            </ul>
                        </li>
                    <?php } } ?>
                <?php } ?>

                <!-- Bài viết (Không cấp) -->
                <?php if($config['shownews']) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access2('news','man',$config['news'])) $none = "d-none";
                        if(($com=='news') && !$config['news'][$_GET['type']]['dropdown'])
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý bài viết">
                            <i class="nav-icon text-sm far fa-newspaper"></i>
                            <p>
                                Quản lý bài viết
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php foreach($config['news'] as $k => $v) { if(!$v['dropdown']) { ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('news','man',$k)) $none = "d-none";
                                    if($com=='news' && ($act=='man' || $act=='add' || $act=='edit' || $kind=='man') && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>">
                                    <a class="nav-link <?=$active?>" href="index.php?com=news&act=man&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a>
                                </li>
                            <?php } } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Cart -->
                <?php if($config['order']['active']) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        if($kiemtra) if(check_access('order','man','')) $none = "d-none";
                        if($com=='order') $active = 'active';
                    ?>
                    <li class="nav-item <?=$active?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="index.php?com=order&act=man" title="Quản lý đơn hàng">
                            <i class="nav-icon text-sm fas fa-shopping-bag"></i>
                            <p>Quản lý đơn hàng</p>
                        </a>
                    </li>
                <?php } ?>

                <!-- Coupon -->
                <?php if($config['coupon']['active']) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        if($kiemtra) if(check_access('coupon','man','')) $none = "d-none";
                        if($com=='coupon') $active = 'active';
                    ?>
                    <li class="nav-item <?=$active?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="index.php?com=coupon&act=man" title="Quản lý mã ưu đãi">
                            <i class="nav-icon text-sm fas fa-qrcode"></i>
                            <p>Quản lý mã ưu đãi</p>
                        </a>
                    </li>
                <?php } ?>

                <!-- Tags -->
                <?php if(count($config['tags'])) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access2('tags','man',$config['tags'])) $none = "d-none";
                        if($com=='tags')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý tags">
                            <i class="nav-icon text-sm fas fa-tags"></i>
                            <p>
                                Quản lý tags
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php foreach($config['tags'] as $k => $v) { ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('tags','man',$k)) $none = "d-none";
                                    if($com=='tags' && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>">
                                    <a class="nav-link <?=$active?>" href="index.php?com=tags&act=man&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Newsletter -->
                <?php if(count($config['newsletter'])) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access2('newsletter','man',$config['newsletter'])) $none = "d-none";
                        if($com=='newsletter')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý nhận tin">
                            <i class="nav-icon text-sm fas fa-envelope"></i>
                            <p>
                                Quản lý nhận tin
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php foreach($config['newsletter'] as $k => $v) { ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('newsletter','man',$k)) $none = "d-none";
                                    if($com=='newsletter' && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>">
                                    <a class="nav-link <?=$active?>" href="index.php?com=newsletter&act=man&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Static -->
                <?php if(count($config['static'])) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access2('static','capnhat',$config['static'])) $none = "d-none";
                        if($com=='static')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý trang tĩnh">
                            <i class="nav-icon text-sm fas fa-bookmark"></i>
                            <p>
                                Quản lý trang tĩnh
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php foreach($config['static'] as $k => $v) { ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('static','capnhat',$k)) $none = "d-none";
                                    if($com=='static' && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>">
                                    <a class="nav-link <?=$active?>" href="index.php?com=static&act=capnhat&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Gallery -->
                <?php if(count($config['photo'])) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access2('photo','photo_static',$config['photo']['photo_static']) && check_access2('photo','man_photo',$config['photo']['man_photo'])) $none = "d-none";
                        if($com=='photo')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý hình ảnh - video">
                            <i class="nav-icon text-sm fas fa-photo-video"></i>
                            <p>
                                Quản lý hình ảnh - video
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if(count($config['photo']['photo_static'])) { ?>
                                <?php foreach($config['photo']['photo_static'] as $k => $v) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('photo','photo_static',$k)) $none = "d-none";
                                    if($com=='photo' && $_GET['type']==$k && $act=='photo_static') $active = "active"; ?>
                                    <li class="nav-item <?=$none?>">
                                        <a class="nav-link <?=$active?>" href="index.php?com=photo&act=photo_static&type=<?=$k?>" title="<?=$v['title_main']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main']?></p></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                            <?php if(count($config['photo']['man_photo'])) { ?>
                                <?php foreach($config['photo']['man_photo'] as $k => $v) {
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('photo','man_photo',$k)) $none = "d-none";
                                    if($com=='photo' && $_GET['type']==$k && ($act=='man_photo' || $act=='add_photo' || $act=='edit_photo')) $active = "active"; ?>
                                    <li class="nav-item <?=$none?>">
                                        <a class="nav-link <?=$active?>" href="index.php?com=photo&act=man_photo&type=<?=$k?>" title="<?=$v['title_main_photo']?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v['title_main_photo']?></p></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Địa điểm -->
                <?php if($config['places']['active']) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access('places','man_city','') && check_access('places','man_district','') && check_access('places','man_wards','') && check_access('places','man_street','')) $none = "d-none";
                        if($com=='places')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý địa điểm">
                            <i class="nav-icon text-sm fas fa-building"></i>
                            <p>
                                Quản lý địa điểm
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php
                                $none = "";
                                $active = "";
                                if($kiemtra) if(check_access('places','man_city','')) $none = "d-none";
                                if($com=='places' && ($act=='man_city' || $act=='add_city' || $act=='edit_city')) $active = "active";
                            ?>
                            <li class="nav-item <?=$none?>">
                                <a class="nav-link <?=$active?>" href="index.php?com=places&act=man_city" title="Tỉnh thành"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Tỉnh thành</p></a>
                            </li>
                            <?php
                                $none = "";
                                $active = "";
                                if($kiemtra) if(check_access('places','man_district','')) $none = "d-none";
                                if($com=='places' && ($act=='man_district' || $act=='add_district' || $act=='edit_district')) $active = "active";
                            ?>
                            <li class="nav-item <?=$none?>">
                                <a class="nav-link <?=$active?>" href="index.php?com=places&act=man_district" title="Quận huyện"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Quận huyện</p></a>
                            </li>
                            <?php
                                $none = "";
                                $active = "";
                                if($kiemtra) if(check_access('places','man_wards','')) $none = "d-none";
                                if($com=='places' && ($act=='man_wards' || $act=='add_wards' || $act=='edit_wards')) $active = "active";
                            ?>
                            <li class="nav-item <?=$none?>">
                                <a class="nav-link <?=$active?>" href="index.php?com=places&act=man_wards" title="Phường xã"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Phường xã</p></a>
                            </li>
                            <?php
                                $none = "";
                                $active = "";
                                if($kiemtra) if(check_access('places','man_street','')) $none = "d-none";
                                if($com=='places' && ($act=='man_street' || $act=='add_street' || $act=='edit_street')) $active = "active";
                            ?>
                            <li class="nav-item <?=$none?>">
                                <a class="nav-link <?=$active?>" href="index.php?com=places&act=man_street" title="Đường"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Đường</p></a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <!-- User -->
                <?php if($config['user']['active'] && !check_access3()) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($com=='user' && $act!='login' && $act!='logout')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý user">
                            <i class="nav-icon text-sm fas fa-users"></i>
                            <p>
                                Quản lý user
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if($config['permission']) {
                                $active = "";
                                if($act=='permission_group' || $act=='add_permission_group' || $act=='edit_permission_group') $active = "active"; ?>
                                <li class="nav-item"><a class="nav-link <?=$active?>" href="index.php?com=user&act=permission_group" title="Nhóm quyền"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Nhóm quyền</p></a></li>
                            <?php } ?>
                            <?php
                                $active = "";
                                if($act=='admin_edit') $active = "active";
                            ?>
                            <li class="nav-item"><a class="nav-link <?=$active?>" href="index.php?com=user&act=admin_edit" title="Thông tin admin"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Thông tin admin</p></a></li>
                            <?php if($config['user']['admin']) {
                                $active = "";
                                if($act=='man_admin' || $act=='add_admin' || $act=='edit_admin') $active = "active"; ?>
                                <li class="nav-item"><a class="nav-link <?=$active?>" href="index.php?com=user&act=man_admin" title="Tài khoản admin"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Tài khoản admin</p></a></li>
                            <?php } ?>
                            <?php if($config['user']['visitor']) {
                                $active = "";
                                if($com=='user' && ($act=='man' || $act=='add' || $act=='edit')) $active = "active"; ?>
                                <li class="nav-item"><a class="nav-link <?=$active?>" href="index.php?com=user&act=man" title="Tài khoản khách"><i class="nav-icon text-sm far fa-caret-square-right"></i><p>Tài khoản khách</p></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Onesignal -->
                <?php if($config['onesignal']) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        if($kiemtra) if(check_access('pushOnesignal','man','')) $none = "d-none";
                        if($com=='pushOnesignal') $active = 'active';
                    ?>
                    <li class="nav-item <?=$active?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="index.php?com=pushOnesignal&act=man" title="Quản lý thông báo đẩy">
                            <i class="nav-icon text-sm fas fa-bell"></i>
                            <p>Quản lý thông báo đẩy</p>
                        </a>
                    </li>
                <?php } ?>

                <!-- SEO page -->
                <?php if(count($config['seopage'])) { ?>
                    <?php
                        $none = "";
                        $active = "";
                        $menuopen = "";
                        if($kiemtra) if(check_access21('seopage','capnhat',$config['seopage']['page'])) $none = "d-none";
                        if($com=='seopage')
                        {
                            $active = 'active';
                            $menuopen = 'menu-open';
                        }
                    ?>
                    <li class="nav-item has-treeview <?=$menuopen?> <?=$none?>">
                        <a class="nav-link <?=$active?>" href="#" title="Quản lý SEO page">
                            <i class="nav-icon text-sm fas fa-share-alt"></i>
                            <p>
                                Quản lý SEO page
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php foreach($config['seopage']['page'] as $k => $v) { ?>
                                <?php
                                    $none = "";
                                    $active = "";
                                    if($kiemtra) if(check_access('seopage','capnhat',$k)) $none = "d-none";
                                    if($com=='seopage' && $k==$_GET['type']) $active = "active";
                                ?>
                                <li class="nav-item <?=$none?>">
                                    <a class="nav-link <?=$active?>" href="index.php?com=seopage&act=capnhat&type=<?=$k?>" title="<?=$v?>"><i class="nav-icon text-sm far fa-caret-square-right"></i><p><?=$v?></p></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <!-- Thiết lập thông tin -->
                <?php
                    $none = "";
                    $active = "";
                    if($kiemtra) if(check_access('setting','capnhat','')) $none = "d-none";
                    if($com=='setting') $active = 'active';
                ?>
                <li class="nav-item <?=$active?> <?=$none?>">
                    <a class="nav-link <?=$active?>" href="index.php?com=setting&act=capnhat" title="Thiết lập thông tin">
                        <i class="nav-icon text-sm fas fa-cogs"></i>
                        <p>Thiết lập thông tin</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>