<?php
	class cart
	{
		private $d;

		public function __construct($d)
		{
			$this->d = $d;
		}

		public function get_product_info($pid=0)
		{
			$row = $this->d->rawQueryOne("select * from #_product where id = ?",array($pid));
			return $row;
		}
		
		public function get_product_mau($mau=0)
		{
			$row = $this->d->rawQueryOne("select tenvi from #_product_mau where id = ?",array($mau));
			return $row['tenvi'];
		}
		
		public function get_product_size($size=0)
		{
			$row = $this->d->rawQueryOne("select tenvi from #_product_size where id = ?",array($size));
			return $row['tenvi'];
		}
		
		public function get_price($pid=0)
		{
			$row = $this->d->rawQueryOne("select gia from table_product where id = ?",array($pid));
			return $row['gia'];
		}
		
		public function get_price_new($pid=0)
		{
			$row = $this->d->rawQueryOne("select giamoi from table_product where id = ?",array($pid));
			return $row['giamoi'];
		}
		
		public function remove_product($code)
		{
			$max = count($_SESSION['cart']);

			for($i=0;$i<$max;$i++)
			{
				if($code == $_SESSION['cart'][$i]['code'])
				{
					unset($_SESSION['cart'][$i]);
					break;
				}
			}

			$_SESSION['cart'] = array_values($_SESSION['cart']);
		}
		
		public function get_order_total()
		{
			$max = count($_SESSION['cart']);
			$sum = 0;

			for($i=0;$i<$max;$i++)
			{
				$pid = $_SESSION['cart'][$i]['productid'];
				$q = $_SESSION['cart'][$i]['qty'];
				$proinfo = $this->get_product_info($pid);

				if($proinfo['giamoi']) $price = $this->get_price_new($pid);
				else $price = $this->get_price($pid);
				$sum += $price*$q;
			}

			return $sum;
		}
		
		public function addtocart($q,$pid=0,$mau=0,$size=0)
		{
			if($pid<1 or $q<1) return;
			
			$code = md5($pid.$mau.$size);

			if($mau == 0 && $size == 0)
			{
				if(!$this->product_exists($code,$q))
				{
					$max = count($_SESSION['cart']);
					$_SESSION['cart'][$max]['productid'] = $pid;
					$_SESSION['cart'][$max]['qty'] = $q;
					$_SESSION['cart'][$max]['mau'] = $mau;
					$_SESSION['cart'][$max]['size'] = $size;
					$_SESSION['cart'][$max]['code'] = $code;
				}
			}
			else
			{
				if(is_array($_SESSION['cart']))
				{
					if(!$this->product_exists($code,$q))
					{
						$max = count($_SESSION['cart']);
						$_SESSION['cart'][$max]['productid'] = $pid;
						$_SESSION['cart'][$max]['qty'] = $q;
						$_SESSION['cart'][$max]['mau'] = $mau;
						$_SESSION['cart'][$max]['size'] = $size;
						$_SESSION['cart'][$max]['code'] = $code;
					}
				}
				else
				{
					$_SESSION['cart'] = array();
					$_SESSION['cart'][0]['productid'] = $pid;
					$_SESSION['cart'][0]['qty'] = $q;
					$_SESSION['cart'][0]['mau'] = $mau;
					$_SESSION['cart'][0]['size'] = $size;
					$_SESSION['cart'][0]['code'] = $code;
				}
			}
		}
		
		private function product_exists($code,$q)
		{
			$flag = 0;
			$q = ($q>1)?$q:1;
			$max = count($_SESSION['cart']);

			for($i=0;$i<$max;$i++)
			{
				if($code == $_SESSION['cart'][$i]['code'])
				{
					$_SESSION['cart'][$i]['qty'] += $q;
					$flag = 1;
				}
			}

			return $flag;
		}
	}
?>