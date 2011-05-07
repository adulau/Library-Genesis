<?php
//
// Pass a filename as an argument to the constructor to give a file out for downloading
//
// EXAMPLE:
//   new getresumable('C:/text.doc');
//
class getresumable {

	var $filename = null;
	var $downloadname = null;
	var $fileext = null;
	var $bufsize = 2048;
	var $seek_start = 0;
	var $seek_end = -1;

	public function __construct($file,$ext,$dlname){
		if (is_readable($file) && is_file($file)){
			$this->filename = $file;
			$this->fileext = $ext;
			$this->downloadname = $dlname;
		}
		else die;

		$this->init();
		$this->download();
	}

	protected function init() {
		global $HTTP_SERVER_VARS;

		if (isset($_SERVER['HTTP_RANGE']) || isset($HTTP_SERVER_VARS['HTTP_RANGE']))
		{
			if (isset($HTTP_SERVER_VARS['HTTP_RANGE'])) $seek_range = substr($HTTP_SERVER_VARS['HTTP_RANGE'] , strlen('bytes='));
			else $seek_range = substr($_SERVER['HTTP_RANGE'] , strlen('bytes='));

			$range = explode('-',$seek_range);

			if ($range[0] > 0) $this->seek_start = intval($range[0]);
			if ($range[1] > 0) $this->seek_end = intval($range[1]);
			else $this->seek_end = -1;
		}
		else
		{
			$this->seek_start = 0;
			$this->seek_end = -1;
		}
	}

	protected function header($size,$seek_start=null,$seek_end=null) {
		header("Content-Type: application/$this->fileext");
		header('Content-Disposition: attachment; filename="'.basename($this->downloadname.'.'.$this->fileext).'"');
		header('HTTP/1.0 206 Partial Content');
		header('Status: 206 Partial Content');
		header('Accept-Ranges: bytes');
		header("Content-Range: bytes $seek_start-$seek_end/$size");
		header("Content-Length: " . ($seek_end - $seek_start + 1));
	}

	protected function download() {
		$seek = $this->seek_start;
		$bufsize = $this->bufsize;

		//do some clean up
		@ob_end_clean();
		$old_status = ignore_user_abort(true);
		@set_time_limit(0);

			$size = filesize($this->filename);
			if ($seek > ($size - 1)) $seek = 0;

			$res = fopen($this->filename,'rb');
			if ($seek) fseek($res , $seek);
			if ($this->seek_end < $seek) $this->seek_end = $size-1;

			$this->header($size,$seek,$this->seek_end); //always use the last seek
			$size = $this->seek_end - $seek + 1;

			while (!(connection_aborted() || connection_status() == 1) && $size > 0)
			{
				if ($size < $bufsize) echo fread($res , $size);
				else echo fread($res , $bufsize);

				$size -= $bufsize;
				flush();
			}
			fclose($res);

		ignore_user_abort($old_status);
		set_time_limit(ini_get('max_execution_time'));

		return true;
	}
}
?>