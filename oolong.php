<?php
	function loadpng($path) {
		$ret = @imagecreatefrompng($path);
		if (!$ret) {
			$ret  = imagecreatetruecolor(150, 30);
        	$bgc = imagecolorallocate($ret, 255, 255, 255);
        	$tc  = imagecolorallocate($ret, 0, 0, 0);
        	imagefilledrectangle($ret, 0, 0, 150, 30, $bgc);
        	imagestring($ret, 1, 5, 5, 'Failed to laod ' . $path, $tc);
		}
		return $ret;
	}
	
	function imagemerge($imgarray) {
		$size = 0;
		foreach ($imgarray as $key => $img) {
			$size += imagesx($img);
		}
		$isize = $size / sizeof($imgarray);
		$ret = imagecreatetruecolor($size, 150);
		$bgc = imagecolorallocate($ret, 255, 255, 255);
		imagefilledrectangle($ret, 0, 0, $size, 150, $bgc);
		foreach ($imgarray as $key => $img) {
			imagecopymerge($ret, $img, $key * $isize, 0, 0, 0, $isize, 150, 100);
		}
		return $ret;
	}
	$seed = $_GET['seed'];
	if (isset($seed) && $seed != 0) {
		mt_srand($seed);
	}
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	header('Content-Type: image/png');
	if (mt_rand(0, 10) > 7) {
		$data = array_diff(scandir("oolongw"), array('..', '.'));
		shuffle($data);
		$imgs = array(loadpng("oolongw/" . $data[0]), loadpng("oolongw/" . $data[1]), loadpng("oolongw/" . $data[2]));
		$img = imagemerge($imgs);
	} else {
		$data = array_diff(scandir("oolong"), array('..', '.'));
		shuffle($data);
		$imgs = array(loadpng("oolong/" . $data[0]), loadpng("oolong/" . $data[1]), loadpng("oolong/" . $data[2]), loadpng("oolong/" . $data[3]), loadpng("oolong/" . $data[4]), loadpng("oolong/" . $data[5]));
		$img = imagemerge($imgs);
	}
	imagepng($img);
	imagedestroy($img);
?>