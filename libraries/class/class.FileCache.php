<?php
    class FileCache
    {
        private $d;
        public $Path = 'tmpcache';

        function __construct($d)
        {
            $this->d = $d;
        }

        public function store($key,$data,$ttl)
        {
            $h = fopen($this->getFileName($key),'w');

            if(!$h) throw new Exception('Could not write to cache');

            $data = serialize(array(time()+$ttl,$data));

            if(fwrite($h,$data)===false)
            {
                throw new Exception('Could not write to cache');
            }

            fclose($h);
        }

        private function getFileName($key)
        {
            if(!file_exists($this->Path))
            {
                if(!mkdir($this->Path, 0777, true))
                {
                    die('Failed to create folders...');
                }
            }

            return $this->Path.'/nina_cache' . md5($key);
        }

        public function fetch($key)
        {
            $filename = $this->getFileName($key);

            if(!file_exists($filename) || !is_readable($filename)) return false;

            $data = file_get_contents($filename);
            $data = @unserialize($data);

            if(!$data)
            {
                unlink($filename);
                return false;
            }

            if (time() > $data[0])
            {
                unlink($filename);
                return false;
            }

            return $data[1];
        }

        public function getCache($sql,$type='fetch',$time=600)
        {
            if(!$data = $this->fetch($sql))
            {
                if($type == 'result') $data = $this->d->rawQuery($sql);
                else if($type == 'fetch') $data = $this->d->rawQueryOne($sql);
                $this->store($sql,$data,$time);
            }
            return $data;
        }

        public function DeleteCache()
        {
            if(!is_dir($this->Path)) return false;
            if($handle = opendir($this->Path))
            {
                while(false !== ($file = readdir($handle)))
                {
                    if($file != "." && $file != ".." && $file != ".htaccess" && $file != "thumb.db" && $file != "index.html")
                    {     
                        if(!file_exists($this->Path . "/" . $file) || !is_readable($this->Path . "/" . $file)) return false;
                        unlink($this->Path . "/" . $file);
                    }
                }
                return true;
            }
            else return false;
        }
    }
?>