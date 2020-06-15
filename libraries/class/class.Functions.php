<?php
	class Functions
	{
		private $d;

		function __construct($d)
		{
			$this->d = $d;
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
			global $d;

			$token = $_SESSION['login']['token'];
			$reuslr_products = $this->d->rawQuery("select * from #_user where quyen = ? and hienthi>0",array($token));

			if(count($reuslr_products)==1 && $reuslr_products[0]['quyen']!='')
			{
				return true;
			}
			else
			{
				$_SESSION['login']=NULL;
				session_unset();
				return false;
			}
		}

		/* Mã hóa mật khẩu admin */
		public function encrypt_password($secret,$str,$salt)
		{
			return md5($secret.$str.$salt);
		}

		/* Kiểm tra phân quyền - ẩn/hiện menu admin */
		public function check_access($com='',$act='',$type='')
		{
			$str=$com;
			
			if($act!='') $str.='_'.$act;
			if($type!='') $str.='_'.$type;

			if(!in_array($str, $_SESSION['list_quyen'])) return true; /* Không tồn tại quyền */
			else return false;
		}

		/* Kiểm tra phân quyền 2 - ẩn/hiện menu admin */
		public function check_access2($com='',$act='',$arr=array())
		{
			$str=$com;

			if($act!='') $str.='_'.$act;

			if($arr!=NULL)
			{
				foreach ($arr as $key => $value)
				{
					if(!in_array($str."_".$key, $_SESSION['list_quyen'])) return true; /* Không tồn tại quyền */
				}
			}
			return false;
		}

		/* Kiểm tra phân quyền 2.1 - ẩn/hiện menu seopage */
		public function check_access21($com='',$act='',$arr=array())
		{
			$str=$com;
			$dem=0;

			if($act!='') $str.='_'.$act;

			if($arr!=NULL)
			{
				foreach ($arr as $key => $value)
				{
					if(!in_array($str."_".$key, $_SESSION['list_quyen'])) $dem++; /* Cập nhật biến đếm */
				}
				if($dem == count($arr))
				{
					return true; /* Không tồn tại quyền */
				}
			}
			return false;
		}

		/* Kiểm tra phân quyền */
		public function check_access3()
		{
			global $config;
			
			if($_SESSION['login']['username']=="admin" || $config['website']['debug-developer']) return false;
			else return true;
		}

		/* Lấy tình trạng của đăng ký nhận tin */
		public function get_status_email($tinhtrang,$type)
		{
			global $config;
			$loai=='';
			foreach ($config['newsletter'][$type]['tinhtrang'] as $key => $value)
			{
				if($key==$tinhtrang)
				{
					$loai=$value;
					break;
				}
			}
			if($loai=='') $loai="Đang chờ duyệt...";
			return $loai;
		}

		/* Lấy seo */
		public function get_seo($id=0,$com='',$act='',$type='')
		{
			if($id || $act=='capnhat')
			{
				global $d;

				if($id) $row = $this->d->rawQueryOne("select * from table_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,$act,$type));
				else $row = $this->d->rawQueryOne("select * from table_seo where com = ? and act = ? and type = ?",array($com,$act,$type));

				return $row;
			}
		}

		/* Lấy hình thức thanh toán */
		public function get_payments($payments=0)
		{
			global $d;

			$row = $this->d->rawQueryOne("select tenvi from #_news where id = ?",array($payments));

			return $row['tenvi'];
		}

		/* Lấy màu cart */
		public function get_mau_cart($id)
		{
			global $d;

			$row = $this->d->rawQueryOne("select mau, loaihienthi, photo, tenvi from #_product_mau where id = ?",array($id));

			return $row;
		}

		/* Lấy places */
		public function get_places($table,$id)
		{
			global $d;

			$row = $this->d->rawQueryOne("select ten from #_$table where id = ?",array($id));

			return $row['ten'];
		}

		/* Check recaptcha */
		public function checkRecaptcha($response)
		{
			global $config;

			if($config['googleAPI']['recaptcha']['active'])
		    {
		        $recaptcha = file_get_contents($config['googleAPI']['recaptcha']['urlapi'].'?secret='.$config['googleAPI']['recaptcha']['secretkey'].'&response='.$response);
				$recaptcha = json_decode($recaptcha);
				$recaptcha = $recaptcha->score;
		    }
		    else $recaptcha = 1;

		    return $recaptcha;
		}

		/* Send email */
		public function sendEmail($owner, $arrayEmail=null, $subject="", $message="", $file=false)
		{
			global $setting;

			require_once LIBRARIES."phpmailer/class.phpmailer.php";
			$mail = new PHPMailer();

			if($setting['mailertype']==1)
		    {
		        $config_ip = $setting['ip_host'];
		        $config_email = $setting['email_host'];
		        $config_pass = $setting['password_host'];

		        $mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Host = $config_ip;
				$mail->Username = $config_email;
				$mail->Password = $config_pass;
				$mail->SetFrom($setting['email'],$setting['ten'.$lang]);
		    }
		    else if($setting['mailertype']==2)
		    {
		        $config_ip = $setting['host_gmail'];
		        $config_port = $setting['port_gmail'];
		        $config_secure = $setting['secure_gmail'];
		        $config_email = $setting['email_gmail'];
		        $config_pass = $setting['password_gmail'];

		        $mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Host = $config_ip;
				$mail->Port = $config_port;
				$mail->SMTPSecure = $config_secure;
				$mail->Username = $config_email;
				$mail->Password = $config_pass;
				$mail->SetFrom($config_email,$setting["ten".$lang]);
				$mail->From = $config_email;
				$mail->FromName = $setting["ten".$lang];
		    }

		    if($owner == 'admin')
		    {
		    	$mail->AddAddress($setting['email'],$setting['ten'.$lang]);
		    }
		    else if($owner == 'customer')
		    {
		    	if($arrayEmail) foreach($arrayEmail as $vEmail) $mail->AddAddress($vEmail['email'],$vEmail['name']);
		    }
		    $mail->AddReplyTo($setting['email'],$setting['ten'.$lang]);
		    $mail->Subject = $subject;
		    $mail->CharSet = "utf-8";
		    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
		    $mail->MsgHTML($message);
		    if($file) $mail->AddAttachment(UPLOAD_FILE_L.$file);

		    if($mail->Send()) return true;
		    else return false;
		}

		/* Xóa cache */
		public function removeCacheThumb($dir)
		{
			if(is_dir($dir))
			{
				$structure = glob(rtrim($dir,"/").'/*');
				if(is_array($structure))
				{
					foreach($structure as $file)
					{
						if(is_dir($file)) recursiveRemove($file);
						else if(is_file($file)) @unlink($file);
					}
					copy("../upload/.htaccess","../upload!@#cache/.htaccess");
				}
			}
		}

		/* Login */
		public function checkLogin()
		{
			global $d, $config_base;

			$flag = true;
			$iduser = ($_COOKIE['login_id']) ? $_COOKIE['login_id'] : $_SESSION[$login_name]['id'];

			if($iduser)
			{
				$row = $this->d->rawQueryOne("select login_session, id, username, dienthoai, diachi, email, ten from #_member where id = ? and hienthi = 1",array($iduser));

				if($row['id'])
			    {
			    	$login_session = ($_COOKIE['login_session']) ? $_COOKIE['login_session'] : $_SESSION[$login_name]['login_session'];

			    	if($login_session == $row['login_session'])
			    	{
			    		$_SESSION[$login_name][$login_name] = true;
				        $_SESSION[$login_name]['id'] = $row['id'];
				        $_SESSION[$login_name]['username'] = $row['username'];
				        $_SESSION[$login_name]['dienthoai'] = $row['dienthoai'];
				        $_SESSION[$login_name]['diachi'] = $row['diachi'];
				        $_SESSION[$login_name]['email'] = $row['email'];
				        $_SESSION[$login_name]['ten'] = $row['ten'];
			    	}
			    	else $flag = false;
			    }
			    else $flag = false;

			    if(!$flag)
			    {
			    	$_SESSION[$login_name][$login_name] = false;
					unset($_SESSION[$login_name]);
					setcookie('login_id',"",-1,'/');
					setcookie('login_session',"",-1,'/');

					$this->transfer("Tài khoản của bạn đã hết hạn đăng nhập hoặc đã đăng nhập trên thiết bị khác", $config_base,0);
			    }
			}
		}

		/* Lấy youtube */
		public function getYoutube($url) 
		{
		    $parts = parse_url($url);
		    if (isset($parts['query'])) 
		    {
		        parse_str($parts['query'], $qs);
		        if (isset($qs['v'])) {
		            return $qs['v'];
		        } else if ($qs['vi']) {
		            return $qs['vi'];
		        }
		    }
		    if (isset($parts['path'])) 
		    {
		        $path = explode('/', trim($parts['path'], '/'));
		        return $path[count($path) - 1];
		    }
		    return false;
		}

		/* Lấy hình từ google - facebook */
		public function uploadUrl($url,$savePath,$imageRestrict,$imageSizeRestrcit)
		{
			$type_upload = explode(',',$imageRestrict);
			$ext = substr(basename($url),strrpos(basename($url),".")+1);
			$tmp = explode('?',$ext);
			$ext = $tmp[0];
			$name = $this->stringRandom(6);
			$result = "ERROR 1";
			if(!in_array($ext,$type_upload))
			{
			    return 'ERROR 2';
			}
			else
			{
				for($i=0;$i<5;$i++)
				{
			    	$rd.=rand(0,9);
				}
				$fn = $savePath.$rd.$name.'.'.$ext;
				$fp = fopen($fn,"w");
				$noidung = file_get_contents($url);
				fwrite($fp,$noidung,strlen($noidung));
				fclose($fp);
				$result = $rd.$name.'.'.$ext;
			}
			return $result;
		}

		/* Template gallery admin */
		public function galleryFiler($stt,$id,$photo,$name,$folder,$col)
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
		public function make_date($time,$dot='.',$lang='vi',$f=false)
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
		public function alert($s)
		{
			echo '<script language="javascript"> alert("'.$s.'") </script>';
		}

		/* Delete file */
		public function delete_file($file)
		{
			return @unlink($file);
		}

		/* Transfer */
		public function transfer($msg, $page="index.html", $stt=1)
		{
			global $config_base;

			$basehref = $config_base;
			$showtext = $msg;
			$page_transfer = $page;
			$stt = $stt;
			
			include("./templates/transfer_tpl.php");
			exit();
		}

		/* Redirect */
		public function redirect($url='')
		{
			echo '<script language="javascript">window.location = "'.$url.'" </script>';
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
		public function pagination($totalq,$per_page=10,$page=1,$url='?')
		{
			$urlpos = strpos($url, "?");
			$url = ($urlpos) ? $url."&" : $url."?";
			$total = $totalq;
			$adjacents = "2";
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

				if($page > 1) $pagination.= "<li class='page-item'><a class='page-link' href='{$url}p={$prev}'>{$prevlabel}</a></li>";

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
		public function utf8convert($str)
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
			foreach($utf8 as $ascii=>$uni)
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
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			return $pageURL;
		}

		/* Lấy getCurrentPageURL */
		public function getCurrentPageURL() 
		{
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
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
			if ($_SERVER["HTTPS"] == "on")
			{
				$pageURL .= "s";
			}
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

		/* Upload name */
		public function uploadName($name)
		{
			$rand = rand(1000,9999);
			$ten_anh = pathinfo($name, PATHINFO_FILENAME);
			$result = $this->changeTitle($ten_anh)."-".$rand;
			return $result;
		}

		/* Upload images */
		public function uploadImage($file, $extension, $folder, $newname='')
		{
			if(isset($_FILES[$file]) && !$_FILES[$file]['error'])
			{
				if($_FILES[$file]['size'] > 4*1048576)
				{
					$this->alert('Dung lượng file không được vượt quá 4MB');
					return false;
				}

				$ext = explode('.', $_FILES[$file]['name']);
				$ext = $ext[count($ext)-1];
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

				return $_FILES[$file]['name'];
			}
			return false;
		}

		/* Remove Sub folder */
		function RemoveEmptySubFolders($path)
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
		function RemoveFilesFromDirInXSeconds($dir,$seconds = 3600)
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

		/* Create thumb */
		public function createThumb($width_thumb, $height_thumb, $zoom_crop='1', $src)
		{
			$t = 3600*24*3;
			$this->RemoveFilesFromDirInXSeconds(THUMBS."/",$t);
			$this->RemoveEmptySubFolders(THUMBS."/");
			$new_width = $width_thumb;
			$new_height = $height_thumb;

			if($new_width && !$new_height)
			{
				$new_height = floor($height_thumb * ($new_width / $width_thumb));
			}
			else if($new_height && !$new_width)
			{
				$new_width = floor($width_thumb * ($new_height / $height_thumb));
			}

			$src = str_replace("%20"," ",$src);
			if(!file_exists($src)) die("NO IMAGE $src");

			$image_url = $src;
			$origin_x = 0;
			$origin_y = 0;

			$array = getimagesize($image_url);
			if($array) list($image_w, $image_h) = $array;
			else die("NO IMAGE $image_url");

			$width = $image_w;
			$height = $image_h;
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
				if($final_height > $new_height)
				{
					$new_width = $width * ($new_height / $height);
				}
				else
				{
					$new_height = $final_height;
				}
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

			$folder_old = str_replace($image_name, '', $image_url);
			$upload_dir = THUMBS.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;

			if(!file_exists($upload_dir))
			{
				if(!mkdir($upload_dir, 0777, true))
				{
					die('Failed to create folders...');
				}
			}

			$new_file = $image_name;
			if($func == 'imagejpeg') $func($canvas, $upload_dir.$new_file,100);
			else $func($canvas, $upload_dir.$new_file,floor($quality * 0.09));	
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
		public function digitalRandom($min,$max,$num)
		{
			$result='';
			for($i=0;$i<$num;$i++)
			{
				$result.=rand($min,$max);
			}
			return $result;	
		}

		/* Scroll load */
		public function getAddonsOnline($url="",$element="",$type="",$width=0,$height=0,$widththumb=0,$heightthumb=0)
		{
		    $showtext = "";
		    switch($type)
		    {
		        case 'scriptMain':
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