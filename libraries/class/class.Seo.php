<?php
	class Seo
	{
		private $d;
		private $data;

		function __construct($d)
		{
			$this->d = $d;
		}

		public function setSeo($key,$value)
		{
			$this->data[$key] = $value;
		}

		public function getSeo($key)
		{
			return $this->data[$key];
		}

		public function getSeoDB($id=0,$com='',$act='',$type='')
		{
			if($id || $act=='capnhat')
			{
				if($id) $row = $this->d->rawQueryOne("select * from table_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,$act,$type));
				else $row = $this->d->rawQueryOne("select * from table_seo where com = ? and act = ? and type = ?",array($com,$act,$type));

				return $row;
			}
		}

		public function updateSeoDB($json='',$table='',$id=0)
		{
			if($table && $id) $this->d->rawQuery("update #_$table set options = ? where id = ?",array($json,$id));
		}
	}
?>