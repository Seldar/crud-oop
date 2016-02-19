<?php 
class FileUpload {

	public $rootPath;
	public $allowedExtensions;
	public $error;
	public $type;
	
	public function __construct($type, $size = array())
	{
		$this->error = 0;
		$this->type = $type;
		$this->size = $size;
		switch($this->type)
		{
			case "image":
			{
				$this->allowedExtensions = array("jpg","gif","png","jpeg");
				$this->rootPath = Config::$IMAGE_PATH;
				break;
			}

			case "video":
			{
				$this->allowedExtensions = array("mp4");
				$this->rootPath = Config::$VIDEO_PATH;
				break;	
			}
			
			case "audio":
			{
				$this->allowedExtensions = array("mp3");
				$this->rootPath = Config::$AUDIO_PATH;
				break;	
			}			
		}
	}
	
	public function upload($table,$field,$id)
	{
		$posted_file = $_FILES[$field];
		if($posted_file['error'] !== 0)
		{
			$this->error = "File Upload Failed with error " . $posted_file['error']. "!";	
			return array(0,$this->error);
		}
		$filerArr = explode(".",$posted_file['name']);
		if(!in_array($filerArr[1], $this->allowedExtensions))
		{
			$this->error = "Only " . $this->type . " files are allowed!";
			return array(0,$this->error);
		}
		if($this->type == 'image' && count($this->size) > 0)
		{				
			$imgsize = getimagesize($posted_file['tmp_name']);
			if($imgsize[0] != $this->size[0] || $imgsize[1] != $this->size[1])
			{
				$this->error = "Image Size wrong. Should be " . $this->size[0] . "/" . $this->size[1];
				return array(0,$this->error);
			}
		}
		foreach($this->allowedExtensions as $extToDel)
		{
			unlink($this->rootPath . $table . "-" . $id . ".". $extToDel);
		}
		if(!move_uploaded_file($posted_file['tmp_name'], $this->rootPath . $table . "-" . $id . "." . $filerArr[1]))
		{
			$this->error = "File Copy Failed!";
			return array(0,$this->error);
		}

		if($this->type == 'image')
		{
			$assets = $this->assetCheck();
			$fp = fopen($this->rootPath . "assets.json","w+") or die("assets.json open failed");
			fwrite($fp,$assets) or die("assets.json write failed");
			fclose($fp);
		}
		return array(1,$table . "-" . $id . "." . $filerArr[1]);

	}
	
	public function assetCheck()
	{
		$path = $this->rootPath;
		$imageExtensions = array("jpg","gif","png","jpeg");
		$dirlist = scandir($path);
		foreach($dirlist as $filename)
		{
			$filerArr = explode(".",$filename);
			if(in_array($filerArr[1], $this->allowedExtensions) && $filename != "." && $filename != ".." && $filename != "appData.json" && $filename != "userData.php" && $filename != "assets.json" && $filename != "appData.json.gz" && $filename != "video")
			{
				 $data[] = array($filename , filemtime($path . $filename),filesize($path . $filename));
			}
		}
		return json_encode($data);
	}
}
?>