<?php
	class Functions
	{
		private $d;

		function __construct($d)
		{
			$this->d = $d;
		}

		/* Check URL */
		public function checkURL($index)
		{
			global $config_base;
			
			$url = '';
			$urls = array('index','index.html','trang-chu','trang-chu.html');

			if($_SERVER['REDIRECT_URL'])
			{
				$root = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
				$url = str_replace($root."/", "", $_SERVER['REDIRECT_URL']);
			}
			else
			{
				$url = explode("/", $_SERVER['REQUEST_URI']);
				$url = $url[count($url)-1];
				if(strpos($url, "?"))
				{
					$url = explode("?", $url);
					$url = $url[0];
				}
			}
			if($index) array_push($urls,"index.php");
			else if(array_search('index.php', $urls)) $urls = array_diff($urls, ["index.php"]);
			if(in_array($url, $urls)) $this->redirect($config_base,301);
		}

		/* Create sitemap */
		public function createSitemap($com, $type='', $field='', $table='', $time='', $changefreq='', $priority='', $lang, $orderby='', $menu=true)
		{
			global $config_base;

			$urlsm = '';
			if($type)
			{
				$sitemap = $this->d->rawQuery("SELECT tenkhongdau$lang, ngaytao FROM table_$table WHERE type = ? ORDER BY $orderby DESC",array($type));
			}

			if($menu && $field == 'id')
			{
				$urlsm = $config_base.$com;
				echo '<url>';
				echo '<loc>'.$urlsm.'</loc>';
				echo '<lastmod>'.date('c',time()).'</lastmod>';
				echo '<changefreq>'.$changefreq.'</changefreq>';
				echo '<priority>'.$priority.'</priority>';
				echo '</url>';
			}

			foreach($sitemap as $value)
			{
				$urlsm = $config_base.$value['tenkhongdau'.$lang];
				echo '<url>';
				echo '<loc>'.$urlsm.'</loc>';
				echo '<lastmod>'.date('c',$value['ngaytao']).'</lastmod>';
				echo '<changefreq>'.$changefreq.'</changefreq>';
				echo '<priority>'.$priority.'</priority>';
				echo '</url>';
			}
		}

		/* Kiểm tra dữ liệu nhập vào */
		public function cleanInput($input)
		{
			$search = array(
				'@<script[^>]*?>.*?</script>@si',   // Loại bỏ javascript
				'@<[\/\!]*?[^<>]*?>@si',            // Loại bỏ HTML tags
				'@<style[^>]*?>.*?</style>@siU',    // Loại bỏ style tags
				'@<![\s\S]*?--[ \t\n\r]*>@'         // Loại bỏ multi-line comments
			);
			$output = preg_replace($search, '', $input);
			return $output;
		}

		/* Kiểm tra dữ liệu nhập vào */
		public function sanitize($input)
		{
			if(is_array($input))
			{
				foreach($input as $var=>$val)
				{
					$output[$var] = $this->sanitize($val);
				}
			}
			else
			{
				if(get_magic_quotes_gpc())
				{
					$input = stripslashes($input);
				}
				$input  = $this->cleanInput($input);
				$output = addslashes($input);
			}
			return $output;
		}

		/* Kiểm tra đăng nhập */
		public function check_login()
		{
			$token = $_SESSION['login_admin']['token'];
			$row = $this->d->rawQuery("select quyen from #_user where quyen = ? and hienthi>0",array($token));

			if(count($row)==1 && $row[0]['quyen']!='')
			{
				return true;
			}
			else
			{
				$_SESSION['login_admin'] = NULL;
				session_unset();
				return false;
			}
		}

		/* Mã hóa mật khẩu admin */
		public function encrypt_password($secret, $str, $salt)
		{
			return md5($secret.$str.$salt);
		}

		/* Kiểm tra phân quyền menu */
		public function check_access($com='', $act='', $type='', $array=null, $case='')
		{
			$str = $com;
			
			if($act) $str .= '_'.$act;

			if($case == 'phrase-1')
			{
				if($type!='') $str .= '_'.$type;
				if(!in_array($str, $_SESSION['list_quyen'])) return true;
				else return false;
			}
			else if($case == 'phrase-2')
			{
				if($array)
				{
					foreach($array as $key => $value)
					{
						if(!in_array($str."_".$key, $_SESSION['list_quyen'])) return true;
					}
				}
				else return false;
			}
			else if($case == 'phrase-3')
			{
				$count = 0;

				if($array)
				{
					foreach($array as $key => $value)
					{
						if(!in_array($str."_".$key, $_SESSION['list_quyen'])) $count++;
					}

					if($count == count($array)) return true;
				}
				else return false;
			}

			return false;
		}

		/* Kiểm tra phân quyền */
		public function check_permission()
		{
			global $config;
			
			if($_SESSION['login_admin']['username']=="admin" || $config['website']['debug-developer']) return false;
			else return true;
		}

		/* Lấy tình trạng nhận tin */
		public function get_status_newsletter($tinhtrang=0, $type='')
		{
			global $config;

			$loai == '';
			foreach($config['newsletter'][$type]['tinhtrang'] as $key => $value)
			{
				if($key == $tinhtrang)
				{
					$loai = $value;
					break;
				}
			}

			if($loai == '') $loai="Đang chờ duyệt...";

			return $loai;
		}

		/* Lấy hình thức thanh toán */
		public function get_payments($id=0)
		{
			$row = $this->d->rawQueryOne("select tenvi from #_news where id = ?",array($id));
			return $row['tenvi'];
		}

		/* Lấy màu cart */
		public function get_color_cart($id=0)
		{
			$row = $this->d->rawQueryOne("select mau, loaihienthi, photo, tenvi from #_product_mau where id = ?",array($id));
			return $row;
		}

		/* Lấy places */
		public function get_places($table='', $id=0)
		{
			if($table)
			{
				$row = $this->d->rawQueryOne("select ten from #_$table where id = ?",array($id));
				return $row['ten'];
			}
			else return false;
		}

		/* Check recaptcha */
		public function checkRecaptcha($response='')
		{
			global $config;

			if($config['googleAPI']['recaptcha']['active'] && $response)
		    {
		        $recaptcha = file_get_contents($config['googleAPI']['recaptcha']['urlapi'].'?secret='.$config['googleAPI']['recaptcha']['secretkey'].'&response='.$response);
				$recaptcha = json_decode($recaptcha);
				$recaptcha = $recaptcha->score;
		    }
		    else $recaptcha = 1;

		    return $recaptcha;
		}

		/* Login */
		public function checkLogin()
		{
			global $d, $config_base, $login_member;

			$flag = true;
			$iduser = ($_COOKIE['login_member_id']) ? $_COOKIE['login_member_id'] : $_SESSION['login_member']['id'];

			if($iduser)
			{
				$row = $this->d->rawQueryOne("select login_session, id, username, dienthoai, diachi, email, ten from #_member where id = ? and hienthi = 1",array($iduser));

				if($row['id'])
			    {
			    	$login_session = ($_COOKIE['login_member_session']) ? $_COOKIE['login_member_session'] : $_SESSION['login_member']['login_session'];

			    	if($login_session == $row['login_session'])
			    	{
			    		$_SESSION[$login_member] = true;
				        $_SESSION['login_member']['id'] = $row['id'];
				        $_SESSION['login_member']['username'] = $row['username'];
				        $_SESSION['login_member']['dienthoai'] = $row['dienthoai'];
				        $_SESSION['login_member']['diachi'] = $row['diachi'];
				        $_SESSION['login_member']['email'] = $row['email'];
				        $_SESSION['login_member']['ten'] = $row['ten'];
			    	}
			    	else $flag = false;
			    }
			    else $flag = false;

			    if(!$flag)
			    {
			    	$_SESSION[$login_member] = false;
					unset($_SESSION['login_member']);
					setcookie('login_member_id',"",-1,'/');
					setcookie('login_member_session',"",-1,'/');

					$this->transfer("Tài khoản của bạn đã hết hạn đăng nhập hoặc đã đăng nhập trên thiết bị khác", $config_base, false);
			    }
			}
		}

		/* Lấy youtube */
		public function getYoutube($url='') 
		{
			if($url)
			{
			    $parts = parse_url($url);
			    if(isset($parts['query'])) 
			    {
			        parse_str($parts['query'], $qs);
			        if(isset($qs['v'])) return $qs['v'];
			        else if($qs['vi']) return $qs['vi'];
			    }

			    if(isset($parts['path'])) 
			    {
			        $path = explode('/', trim($parts['path'], '/'));
			        return $path[count($path) - 1];
			    }
			}

		    return false;
		}

		/* Template gallery admin */
		public function galleryFiler($stt=1, $id=0, $photo='', $name='', $folder='', $col='')
		{
			?>
				<li class="jFiler-item my-jFiler-item my-jFiler-item-<?=$id?> <?=$col?>" data-id="<?=$id?>">
			        <div class="jFiler-item-container">
			            <div class="jFiler-item-inner">
			                <div class="jFiler-item-thumb">
			                    <div class="jFiler-item-thumb-image">
			                    	<img src="../upload/<?=$folder?>/<?=$photo?>" alt="<?=$name?>">
			                    	<i class="fas fa-arrows-alt"></i>
			                    </div>
			                </div>
			                <div class="jFiler-item-assets jFiler-row">
			                    <ul class="list-inline pull-right d-flex align-items-center justify-content-between">
			                        <li class="ml-1"><a class="icon-jfi-trash jFiler-item-trash-action my-jFiler-item-trash" data-id="<?=$id?>" data-folder="<?=$folder?>"></a></li>
			                        <li class="mr-1">
			                        	<div class="custom-control custom-checkbox d-inline-block align-middle text-md">
					                        <input type="checkbox" class="custom-control-input filer-checkbox" id="filer-checkbox-<?=$id?>" value="<?=$id?>">
					                        <label for="filer-checkbox-<?=$id?>" class="custom-control-label font-weight-normal">Chọn</label>
					                    </div>
			                        </li>
			                    </ul>
			                </div>
			                <input type="number" class="form-control form-control-sm my-jFiler-item-info rounded mb-1" value="<?=$stt?>" placeholder="Số thứ tự" data-info="stt" data-id="<?=$id?>"/>
			                <input type="text" class="form-control form-control-sm my-jFiler-item-info rounded" value="<?=$name?>" placeholder="Tiêu đề" data-info="tieude" data-id="<?=$id?>"/>
			            </div>
			        </div>
			    </li>
			<?php
		}

		/* Lấy date */
		public function make_date($time, $dot='.', $lang='vi', $f=false)
		{
			$str = ($lang == 'vi') ? date("d{$dot}m{$dot}Y",$time) : date("m{$dot}d{$dot}Y",$time);

			if($f)
			{
				$thu['vi'] = array('Chủ nhật','Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy');
				$thu['en'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
				$str = $thu[$lang][date('w',$time)].', '.$str;
			}

			return $str;
		}

		/* Alert */
		public function alert($notify)
		{
			echo '<script language="javascript">alert("'.$notify.'")</script>';
		}

		/* Delete file */
		public function delete_file($file)
		{
			return @unlink($file);
		}

		/* Transfer */
		public function transfer($msg, $page='', $stt=true)
		{
			global $config_base;

			$basehref = $config_base;
			$showtext = $msg;
			$page_transfer = $page;
			$stt = $stt;
			
			include("./templates/layout/transfer.php");
			exit();
		}

		/* Redirect */
		public function redirect($url='', $response=null)
		{
			header("location:$url", true, $response);
			exit();
		}

		/* Dump */
		public function dump($arr, $exit=1)
		{
			echo "<pre>";	
			var_dump($arr);
			echo "<pre>";	
			if($exit) exit();
		}

		/* Pagination */
		public function pagination($totalq, $per_page=10, $page=1, $url='?')
		{
			$urlpos = strpos($url, "?");
			$url = ($urlpos) ? $url."&" : $url."?";
			$total = $totalq;
			$adjacents = "2";
			$firstlabel = "First";
			$prevlabel = "Prev";
			$nextlabel = "Next";
			$lastlabel = "Last";
			$page = ($page == 0 ? 1 : $page);
			$start = ($page - 1) * $per_page;
			$prev = $page - 1;
			$next = $page + 1;
			$lastpage = ceil($total/$per_page);
			$lpm1 = $lastpage - 1;
			$pagination = "";

			if($lastpage > 1)
			{
				$pagination .= "<ul class='pagination justify-content-center mb-0'>";
				$pagination .= "<li class='page-item'><a class='page-link'>Page {$page} / {$lastpage}</a></li>";

				if($page > 1)
				{
					$pagination.= "<li class='page-item'><a class='page-link' href='{$this->getCurrentPageURL()}'>{$firstlabel}</a></li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$prev}'>{$prevlabel}</a></li>";
				}

				if($lastpage < 7 + ($adjacents * 2))
				{
					for($counter = 1; $counter <= $lastpage; $counter++)
					{
						if($counter == $page) $pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
						else $pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))
				{
					if($page < 1 + ($adjacents * 2))
					{
						for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if($counter == $page) $pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
							else $pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
						}

						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$lastpage}'>{$lastpage}</a></li>";
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=1'>1</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=2'>2</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";

						for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if($counter == $page) $pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
							else $pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
						}

						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$lastpage}'>{$lastpage}</a></li>";
					}
					else
					{
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=1'>1</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=2'>2</a></li>";
						$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=1'>...</a></li>";

						for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if($counter == $page) $pagination.= "<li class='page-item active'><a class='page-link'>{$counter}</a></li>";
							else $pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$counter}'>{$counter}</a></li>";
						}
					}
				}

				if($page < $counter - 1)
				{
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$next}'>{$nextlabel}</a></li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}p=$lastpage'>{$lastlabel}</a></li>";
				}

				$pagination.= "</ul>";
			}

			return $pagination;
		}

		/* UTF8 convert */
		public function utf8convert($str='')
		{
			if(!$str) return false;
			$utf8 = array(
				'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
				'd'=>'đ|Đ',
				'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
				'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
				'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
				'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
				'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
				''=>'`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
			);
			foreach($utf8 as $ascii => $uni)
				$str = preg_replace("/($uni)/i",$ascii,$str);
			return $str;
		}

		/* Change title */
		public function changeTitle($text)
		{
			$text = strtolower($this->utf8convert($text));
			$text = preg_replace("/[^a-z0-9-\s]/", "",$text);
			$text = preg_replace('/([\s]+)/', '-', $text);
			$text = str_replace(array('%20', ' '), '-', $text);
			$text = preg_replace("/\-\-\-\-\-/","-",$text);
			$text = preg_replace("/\-\-\-\-/","-",$text);
			$text = preg_replace("/\-\-\-/","-",$text);
			$text = preg_replace("/\-\-/","-",$text);
			$text = '@'.$text.'@';
			$text = preg_replace('/\@\-|\-\@|\@/', '', $text);
			return $text;
		}

		/* Lấy IP */
		public function getRealIPAddress()
		{
			if(!empty($_SERVER['HTTP_CLIENT_IP']))
			{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
			elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		/* Lấy getPageURL */
		public function getPageURL()
		{
			$pageURL = 'http';
			if($_SERVER["HTTPS"] == "on") $pageURL .= "s";
			$pageURL .= "://";
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			return $pageURL;
		}

		/* Lấy getCurrentPageURL */
		public function getCurrentPageURL() 
		{
			$pageURL = 'http';
			if($_SERVER["HTTPS"] == "on") $pageURL .= "s";
			$pageURL .= "://";
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			$urlpos = strpos($pageURL, "?p");
			$pageURL = ($urlpos) ? explode("?p=", $pageURL) : explode("&p=", $pageURL);
			return $pageURL[0];
		}

		/* Lấy getCurrentPageURL Cano */
		public function getCurrentPageURL_CANO()
		{
			$pageURL = 'http';
			if($_SERVER["HTTPS"] == "on") $pageURL .= "s";
			$pageURL .= "://";
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			$pageURL = str_replace("amp/", "", $pageURL);
			$urlpos = strpos($pageURL, "?p");
			$pageURL = ($urlpos) ? explode("?p=", $pageURL) : explode("&p=", $pageURL);
			$pageURL = explode("?", $pageURL[0]);
			$pageURL = explode("#", $pageURL[0]);
			$pageURL = explode("index", $pageURL[0]);
			return $pageURL[0];
		}

		/* Get Img size */
		public function getImgSize($photo='', $patch='')
		{
			$x = getimagesize($patch);
			return array("p"=>$photo,"w"=>$x[0],"h"=>$x[1],"m"=>$x['mime']);
		}

		/* Upload name */
		public function uploadName($name='')
		{
			$rand = rand(1000,9999);
			$ten_anh = pathinfo($name, PATHINFO_FILENAME);
			$result = $this->changeTitle($ten_anh)."-".$rand;
			return $result;
		}

		/* Resize images */
		function smartResizeImage($file, $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100, $grayscale = false)
		{
		    if($height <= 0 && $width <= 0) return false;
		    if($file === null && $string === null) return false;
		    $info = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
		    $image = '';
		    $final_width = 0;
		    $final_height = 0;
		    list($width_old, $height_old) = $info;
		    $cropHeight = $cropWidth = 0;
		    if($proportional)
		    {
		        if($width == 0) $factor = $height / $height_old;
		        elseif($height == 0) $factor = $width / $width_old;
		        else $factor = min($width / $width_old, $height / $height_old);
		        $final_width = round($width_old * $factor);
		        $final_height = round($height_old * $factor);
		    }
		    else
		    {
		        $final_width = ($width <= 0) ? $width_old : $width;
		        $final_height = ($height <= 0) ? $height_old : $height;
		        $widthX = $width_old / $width;
		        $heightX = $height_old / $height;
		        $x = min($widthX, $heightX);
		        $cropWidth = ($width_old - $width * $x) / 2;
		        $cropHeight = ($height_old - $height * $x) / 2;
		    }
		    switch($info[2])
		    {
		        case IMAGETYPE_JPEG:
		            $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);
		        break;
		        case IMAGETYPE_GIF:
		            $file !== null ? $image = imagecreatefromgif($file) : $image = imagecreatefromstring($string);
		        break;
		        case IMAGETYPE_PNG:
		            $file !== null ? $image = imagecreatefrompng($file) : $image = imagecreatefromstring($string);
		        break;
		        default:
		            return false;
		    }
		    if($grayscale)
		    {
		        imagefilter($image, IMG_FILTER_GRAYSCALE);
		    }
		    $image_resized = imagecreatetruecolor($final_width, $final_height);
		    if(($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG))
		    {
		        $transparency = imagecolortransparent($image);
		        $palletsize = imagecolorstotal($image);
		        if($transparency >= 0 && $transparency < $palletsize)
		        {
		            $transparent_color = imagecolorsforindex($image, $transparency);
		            $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
		            imagefill($image_resized, 0, 0, $transparency);
		            imagecolortransparent($image_resized, $transparency);
		        }
		        elseif($info[2] == IMAGETYPE_PNG)
		        {
		            imagealphablending($image_resized, false);
		            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
		            imagefill($image_resized, 0, 0, $color);
		            imagesavealpha($image_resized, true);
		        }
		    }
		    imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
		    if($delete_original)
		    {
		        if($use_linux_commands) exec('rm ' . $file);
		        else @unlink($file);
		    }
		    switch(strtolower($output))
		    {
		        case 'browser':
		            $mime = image_type_to_mime_type($info[2]);
		            header("Content-type: $mime");
		            $output = NULL;
		        break;
		        case 'file':
		            $output = $file;
		        break;
		        case 'return':
		            return $image_resized;
		        break;
		        default:
		        break;
		    }
		    switch($info[2])
		    {
		        case IMAGETYPE_GIF:
		            imagegif($image_resized, $output);
		        break;
		        case IMAGETYPE_JPEG:
		            imagejpeg($image_resized, $output, $quality);
		        break;
		        case IMAGETYPE_PNG:
		            $quality = 9 - (int)((0.9 * $quality) / 10.0);
		            imagepng($image_resized, $output, $quality);
		        break;
		        default:
		            return false;
		    }
		    return true;
		}

		/* Upload images */
		public function uploadImage($file, $extension, $folder, $newname='')
		{
			global $config;

			if(isset($_FILES[$file]) && !$_FILES[$file]['error'])
			{
				$postMaxSize = ini_get('post_max_size');
				$MaxSize = explode('M', $postMaxSize);
				$MaxSize = $MaxSize[0];
				if($_FILES[$file]['size'] > $MaxSize*1048576)
				{
					$this->alert('Dung lượng file không được vượt quá '.$postMaxSize);
					return false;
				}

				$ext = explode('.', $_FILES[$file]['name']);
				$ext = strtolower($ext[count($ext)-1]);
				$name = basename($_FILES[$file]['name'], '.'.$ext);

				if(strpos($extension, $ext)===false)
				{
					$this->alert('Chỉ hỗ trợ upload file dạng '.$extension);
					return false;
				}

				if($newname=='' && file_exists($folder.$_FILES[$file]['name']))
					for($i=0; $i<100; $i++)
					{
						if(!file_exists($folder.$name.$i.'.'.$ext))
						{
							$_FILES[$file]['name'] = $name.$i.'.'.$ext;
							break;
						}
					}
				else
				{
					$_FILES[$file]['name'] = $newname.'.'.$ext;
				}

				if(!copy($_FILES[$file]["tmp_name"], $folder.$_FILES[$file]['name']))	
				{
					if(!move_uploaded_file($_FILES[$file]["tmp_name"], $folder.$_FILES[$file]['name']))	
					{
						return false;
					}
				}

				/* Resize image if width origin > config max width */
				$array = getimagesize($folder.$_FILES[$file]['name']);
				list($image_w, $image_h) = $array;
				$maxWidth = $config['website']['upload']['max-width'];
				$maxHeight = $config['website']['upload']['max-height'];
				if($image_w > $maxWidth) $this->smartResizeImage($folder.$_FILES[$file]['name'],null,$maxWidth,$maxHeight,true);

				return $_FILES[$file]['name'];
			}
			return false;
		}

		/* Xóa folder */
		public function removeDir($dirname)
		{
			if(is_dir($dirname)) $dir_handle = opendir($dirname);
			if(!$dir_handle) return false;
			while($file = readdir($dir_handle))
			{
				if($file != "." && $file != "..")
				{
					if(!is_dir($dirname."/".$file)) unlink($dirname."/".$file);
					else $this->removeDir($dirname.'/'.$file);
				}
			}
			closedir($dir_handle);
			rmdir($dirname);
			return true;
		}

		/* Remove Sub folder */
		public function RemoveEmptySubFolders($path)
		{
			$empty=true;

			foreach(glob($path.DIRECTORY_SEPARATOR."*") as $file)
			{
				if(is_dir($file))
				{
					if(!$this->RemoveEmptySubFolders($file)) $empty=false;
				}
				else
				{
					$empty=false;
				}
			}

			if($empty) rmdir($path);

			return $empty;
		}

		/* Remove files from dir in x seconds */
		public function RemoveFilesFromDirInXSeconds($dir, $seconds=3600)
		{
		    $files = glob(rtrim($dir, '/')."/*");
		    $now = time();

		    foreach($files as $file)
		    {
		        if(is_file($file))
		        {
		            if($now - filemtime($file) >= $seconds)
		            {
		                unlink($file);
		            }
		        }
		        else
		        {
		            $this->RemoveFilesFromDirInXSeconds($file,$seconds);
		        }
		    }
		}

		/* Filter opacity */
		public function filterOpacity(&$img, $opacity)
		{
			if(!isset($opacity)) return false;

			$opacity /= 100;
			$w = imagesx($img);
			$h = imagesy($img);
			imagealphablending($img, false);
			$minalpha = 127;

			for($x = 0; $x < $w; $x++)
			{
				for($y = 0; $y < $h; $y++)
				{
					$alpha = (imagecolorat($img, $x, $y) >> 24) & 0xFF;
					if($alpha < $minalpha) $minalpha = $alpha;
				}
			}

			for($x = 0; $x < $w; $x++)
			{
				for($y = 0; $y < $h; $y++)
				{
					$colorxy = imagecolorat($img, $x, $y);
					$alpha = ($colorxy >> 24) & 0xFF;
					if($minalpha !== 127) $alpha = 127 + 127 * $opacity * ($alpha - 127) / (127 - $minalpha);
					else $alpha += 127 * $opacity;
					$alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
					if(!imagesetpixel($img, $x, $y, $alphacolorxy)) return false;
				}
			}

			return true;
		}

		/* Create thumb */
		public function createThumb($width_thumb, $height_thumb, $zoom_crop='1', $src, $watermark=null, $path=THUMBS, $preview=false, $args=array())
		{
			$t = 3600*24*3;
			$this->RemoveFilesFromDirInXSeconds(UPLOAD_TEMP_L, 1);
			$this->RemoveFilesFromDirInXSeconds($path."/", $t);
			$this->RemoveEmptySubFolders($path."/");

			$src = str_replace("%20"," ",$src);
			if(!file_exists($src)) die("NO IMAGE $src");

			$image_url = $src;
			$origin_x = 0;
			$origin_y = 0;
			$new_width = $width_thumb;
			$new_height = $height_thumb;

			$array = getimagesize($image_url);
			if($array) list($image_w, $image_h) = $array;
			else die("NO IMAGE $image_url");

			$width = $image_w;
			$height = $image_h;

			if($new_height && !$new_width) $new_width = $width * ($new_height / $height);
			else if($new_width && !$new_height) $new_height = $height * ($new_width / $width);

			$image_ext = trim(strtolower(end(explode('.', $image_url))));
			$image_name = trim(strtolower(end(explode('/', $image_url))));

			switch(strtoupper($image_ext))
			{
				case 'JPG':
				case 'JPEG':
					$image = imagecreatefromjpeg($image_url);
					$func='imagejpeg';
					$mime_type = 'jpeg';
					break;

				case 'PNG':
					$image = imagecreatefrompng($image_url);
					$func='imagepng';
					$mime_type = 'png';
					break;

				case 'GIF':
					$image = imagecreatefromgif($image_url);
					$func='imagegif';
					$mime_type = 'png';
					break;

				default: die("UNKNOWN IMAGE TYPE: $image_url");
			}

			if($zoom_crop == 3)
			{
				$final_height = $height * ($new_width / $width);
				if($final_height > $new_height) $new_width = $width * ($new_height / $height);
				else $new_height = $final_height;
			}

			$canvas = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($canvas, false);
			$color = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
			imagefill ($canvas, 0, 0, $color);
			
			if($zoom_crop == 2)
			{
				$final_height = $height * ($new_width / $width);
				if($final_height > $new_height)
				{
					$origin_x = $new_width / 2;
					$new_width = $width * ($new_height / $height);
					$origin_x = round($origin_x - ($new_width / 2));
				}
				else
				{
					$origin_y = $new_height / 2;
					$new_height = $final_height;
					$origin_y = round($origin_y - ($new_height / 2));
				}
			}

			imagesavealpha($canvas, true);

			if($zoom_crop > 0)
			{
				$src_x = $src_y = 0;
				$src_w = $width;
				$src_h = $height;

				$cmp_x = $width / $new_width;
				$cmp_y = $height / $new_height;

				if($cmp_x > $cmp_y)
				{
					$src_w = round($width / $cmp_x * $cmp_y);
					$src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
				}
				else if($cmp_y > $cmp_x)
				{
					$src_h = round($height / $cmp_y * $cmp_x);
					$src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
				}

				if($align)
				{
					if(strpos($align, 't') !== false)
					{
						$src_y = 0;
					}
					if(strpos($align, 'b') !== false)
					{
						$src_y = $height - $src_h;
					}
					if(strpos($align, 'l') !== false)
					{
						$src_x = 0;
					}
					if(strpos($align, 'r') !== false)
					{
						$src_x = $width - $src_w;
					}
				}

				imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
			}
			else
			{
				imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			}

			if($preview)
			{
				$watermark = array();
				$watermark['hienthi'] = 1;
				$options = $args;
				$overlay_url = $args['watermark'];
			}
			
			$folder_old = str_replace($image_name, '', $image_url);

			if($watermark['hienthi'])
			{
				$upload_dir = WATERMARK.'/'.$path.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;
			}
			else
			{
				if($watermark) $upload_dir = WATERMARK.'/'.$path.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;
				else $upload_dir = $path.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;
			}

			if(!file_exists($upload_dir)) if(!mkdir($upload_dir, 0777, true)) die('Failed to create folders...');

			if($watermark['hienthi'])
			{
				$options = (isset($options))?$options:json_decode($watermark['options'],true)['watermark'];
				$per_scale = $options['per'];
				$per_small_scale = $options['small_per'];
				$max_width_w = $options['max'];
				$min_width_w = $options['min'];
				$opacity = $options['opacity'];
				$overlay_url = (isset($overlay_url))?$overlay_url:UPLOAD_PHOTO_L.$watermark['photo'];
				$overlay_ext = trim(strtolower(end(explode('.', $overlay_url))));

				switch(strtoupper($overlay_ext))
				{
					case 'JPG':
					case 'JPEG':
						$overlay_image = imagecreatefromjpeg($overlay_url);
						break;

					case 'PNG':
						$overlay_image = imagecreatefrompng($overlay_url);
						break;

					case 'GIF':
						$overlay_image = imagecreatefromgif($overlay_url);
						break;

					default: die("UNKNOWN IMAGE TYPE: $overlay_url");
				}
				
				$this->filterOpacity($overlay_image,$opacity);
				$overlay_width = imagesx($overlay_image);
				$overlay_height = imagesy($overlay_image);
				$overlay_padding = 5;				
		        imagealphablending($canvas, true);
				
				if(min($new_width,$new_height) <= 300) $per_scale = $per_small_scale;
					
				$oz = max($overlay_width,$overlay_height);
				$scale = $new_width/$oz;
				if($new_height > $new_width) $scale = $new_height/$oz;
				$new_overlay_width = (floor($overlay_width*$scale) - $overlay_padding*2)/$per_scale;
				$new_overlay_height = (floor($overlay_height*$scale) - $overlay_padding*2)/$per_scale;
				$scale_w = $new_overlay_width/$new_overlay_height;
				$new_overlay_height = $new_overlay_width/$scale_w;

				if($new_overlay_height > $new_height)
				{
					$new_overlay_height = $new_height / $per_scale;
					$new_overlay_width = $new_overlay_height * $scale_w;
				}
				if($new_overlay_width > $new_width)
				{
					$new_overlay_width = $new_width/$per_scale;
					$new_overlay_height = $new_overlay_width * $scale_w;
				}
				if(($new_width / $new_overlay_width) < $per_scale)
				{
					$new_overlay_width = $new_width/$per_scale;
					$new_overlay_height = $new_overlay_width * $scale_w;
				}
				if($new_height < $new_width && ($new_height / $new_overlay_height) < $per_scale)
				{
					$new_overlay_height = $new_height/$per_scale;
					$new_overlay_width = $new_overlay_height / $scale_w;
				}
				if($new_overlay_width > $max_width_w && $new_ove)
				{
					$new_overlay_width = $max_width_w;
					$new_overlay_height = $new_overlay_width * $scale_w;
				}
				if($new_overlay_width < $min_width_w && $new_width <= $min_width_w*3)
				{
					$new_overlay_width = $min_width_w;	
					$new_overlay_height = $new_overlay_width * $scale_w;						
				}
				$new_overlay_width = round($new_overlay_width);
				$new_overlay_height = round($new_overlay_height);
				
				switch($options['position'])
				{
					case 1:
						$khoancachx = $overlay_padding;
						$khoancachy = $overlay_padding;
						break;

					case 2:
						$khoancachx = abs($new_width - $new_overlay_width)/2;
						$khoancachy = $overlay_padding;
						break;

					case 3:
						$khoancachx = abs($new_width - $new_overlay_width) - $overlay_padding;
						$khoancachy = $overlay_padding;
						break;

					case 4:
						$khoancachx = abs($new_width - $new_overlay_width) - $overlay_padding;
						$khoancachy = abs($new_height - $new_overlay_height)/2;
						break;

					case 5:
						$khoancachx = abs($new_width - $new_overlay_width) - $overlay_padding;
						$khoancachy = abs($new_height - $new_overlay_height) - $overlay_padding;
						break;

					case 6:
						$khoancachx = abs($new_width - $new_overlay_width)/2;
						$khoancachy = abs($new_height - $new_overlay_height) - $overlay_padding;
						break;

					case 7:
						$khoancachx = $overlay_padding;
						$khoancachy = abs($new_height - $new_overlay_height) - $overlay_padding;
						break;

					case 8:
						$khoancachx = $overlay_padding;
						$khoancachy = abs($new_height - $new_overlay_height)/2;
						break;

					case 9:
						$khoancachx = abs($new_width - $new_overlay_width)/2;
						$khoancachy = abs($new_height - $new_overlay_height)/2;
						break;
					
					default:
						$khoancachx = $overlay_padding;
						$khoancachy = $overlay_padding;
						break;
				}
				
	            $overlay_new_image = imagecreatetruecolor($new_overlay_width, $new_overlay_height);					
	            imagealphablending($overlay_new_image, false);
	            imagesavealpha($overlay_new_image, true);
	            imagecopyresampled($overlay_new_image, $overlay_image, 0, 0, 0, 0, $new_overlay_width, $new_overlay_height, $overlay_width, $overlay_height);
	            imagecopy($canvas, $overlay_new_image, $khoancachx, $khoancachy, 0, 0, $new_overlay_width, $new_overlay_height);
				imagealphablending($canvas, false);
				imagesavealpha($canvas, true);
			}

			if($preview)
			{
				$upload_dir = '';
				$this->RemoveEmptySubFolders(WATERMARK.'/'.$path."/");
			}

			if($upload_dir)
			{
				if($func == 'imagejpeg') $func($canvas, $upload_dir.$image_name,100);
				else $func($canvas, $upload_dir.$image_name,floor($quality * 0.09));	
			}
			header('Content-Type: image/' . $mime_type);
			if($func=='imagejpeg') $func($canvas, NULL,100);
			else $func($canvas, NULL,floor($quality * 0.09));

			imagedestroy($canvas);
		}

		/* String random */
		public function stringRandom($sokytu)
		{
			$chuoi="ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789";
			for($i=0; $i < $sokytu; $i++)
			{
				$vitri = mt_rand( 0 ,strlen($chuoi) );
				$giatri= $giatri . substr($chuoi,$vitri,1 );
			}
			return $giatri;
		}

		/* Digital random */
		public function digitalRandom($min, $max, $num)
		{
			$result='';
			for($i=0;$i<$num;$i++)
			{
				$result.=rand($min,$max);
			}
			return $result;	
		}

		/* Scroll load addons */
		public function getAddonsOnline($url="", $element="", $type="", $width=0, $height=0, $widththumb=0, $heightthumb=0)
		{
		    $showtext = "";
		    switch($type)
		    {
		        case 'scriptMain':
		            $showtext='<div id="'.$element.'"></div>';
		            $showtext.='<script>$(function(){var a=!1;$(window).scroll(function(){$(window).scrollTop()>1 && !a&&($("#'.$element.'").load("ajax/ajax_load_addons.php?type='.$type.'"),a=!0)})});</script>';
		            break;

		        case 'shareMain':
		            $showtext='<div id="'.$element.'"></div>';
		            $showtext.='<script>$(function(){var a=!1;$(window).scroll(function(){$(window).scrollTop()>1 && !a&&($("#'.$element.'").load("ajax/ajax_load_addons.php?type='.$type.'"),a=!0)})});</script>';
		            break;
		        
		        case 'fanpage':
		            if($url!='')
		            {
			            $showtext='<div id="'.$element.'"></div>';
			            $showtext.='<script>$(function(){var a=!1;$(window).scroll(function(){$(window).scrollTop()>10 && !a&&($("#'.$element.'").load("ajax/ajax_load_addons.php?url='.$url.'&width='.$width.'&height='.$height.'&type='.$type.'"),a=!0)})});</script>';
		            }
		            break;

		        case 'messages':
		            if($url!='')
		            {
		                $showtext='<div id="'.$element.'"></div>';
		                $showtext.='<script>$(function(){var a=!1;$(window).scroll(function(){$(window).scrollTop()>10 && !a&&($("#'.$element.'").load("ajax/ajax_load_addons.php?url='.$url.'&type='.$type.'"),a=!0)})});</script>';
		            }
		            break;

		        case 'videoFotorama':
		            $showtext='<div id="'.$element.'"></div>';
		            $showtext.='<script>$(function(){var a=!1;$(window).scroll(function(){$(window).scrollTop()>10 && !a&&($("#'.$element.'").load("ajax/ajax_load_addons.php?height='.$height.'&widththumb='.$widththumb.'&heightthumb='.$heightthumb.'&type='.$type.'"),a=!0)})});</script>';
		            break;

		        case 'videoSelect':
		        case 'mapFooter':
		            $showtext='<div id="'.$element.'"></div>';
		            $showtext.='<script>$(function(){var a=!1;$(window).scroll(function(){$(window).scrollTop()>10 && !a&&($("#'.$element.'").load("ajax/ajax_load_addons.php?type='.$type.'"),a=!0)})});</script>';
		            break;
		            
		        default:
		            break;
		    }
		    echo $showtext;
		}
	}
?>