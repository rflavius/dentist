<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * here is the gallery module
 * @category   Dentist
 * @package    DentistLibrary
 */

class Dentist_Gallery
{
	public $imageName = '';
	public $imageID = '';
	public $isBackend = false;
	
	/*
	 * the construct method here we initialize the DB and conf objects
	* @access public
	* @param none
	* @return void
	*/
	public function __construct()
	{
		$this->db = Zend_Registry::get('database');
		$this->conf = Zend_Registry::get('settings');
	}
	
	/*
	 * list images
	 * @access public
	 * @param array $limit
	 * @return array
	 */
	public function listImages($limit = false)
	{
		$select = $this->db->select()
							->from('images')
							->where('thumb = ?', 'N')
							->order('id desc')
							->limit('1');
		$results = $this->db->fetchRow($select);
		return $results;
	}
	
	/* 
	 * generate the small thumbs
	 * @access public
	 * @param int $client_id
	 * @return void
	 */
	public function generateSmallThumb($client_id)
	{
		$folders = explode(',', $this->conf->thumbnail_resize);
		foreach ($folders as $key => $value)
		{
			if(!empty($value))
			{
				$this->resizeThumb($client_id, $value);
			}
		}
		$data = array('thumb' => 'Y');
		$this->db->update('images', $data, "id = '".$this->imageID."'");
		return true;
	}
	
	/*
	 * here we make the actual resize based on thumb sizes
	 * @access public
	 * @param none
	 * @return void
	 */
	public function resizeThumb($client, $folder)
	{
		if(!defined('MEMORY_TO_ALLOCATE') && !defined('DEFAULT_QUALITY') && !defined('CURRENT_DIR') && !defined('DOCUMENT_ROOT'))
		{
			define('MEMORY_TO_ALLOCATE', '100M');
			define('DEFAULT_QUALITY', 90);
			define('CURRENT_DIR', dirname(dirname(__FILE__)));
			define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
		}
		
		if($this->isBackend) $cache_dir = CURRENT_DIR . '/../images/gallery/thumbs/'.$folder.'/';
		else $cache_dir = CURRENT_DIR . '/../images/gallery/thumbs/'.$client.'/';
		
		if(is_dir($cache_dir))
		{
			$cache_dir.= $folder.'/';
			if(!is_dir($cache_dir))
			{
				mkdir($cache_dir, 0777, true);
			}
		}
		else 
		{
			mkdir($cache_dir, 0777, true);
			$cache_dir.= $folder.'/';
			if(!is_dir($cache_dir))
			{
				mkdir($cache_dir, 0777, true);
			}
		}
		
		
		$image= '/../images/users_cabinete/'.$client.'/'.$this->imageName;
		
		//echo $cache_dir." => ".$image;exit;
		
		$file_name = $this->imageName;
	
	
		//echo CACHE_DIR.$file_name;exit;
		$img_size = explode('x', $folder);
		$_GET['width'] = $img_size[0];
		$_GET['height'] = $img_size[1];
		if($_GET['width']==$_GET['height']) $_GET['cropratio'] = '1:1';
		else  $_GET['cropratio']='4:3';
	
		$img_type = explode(".", $image);
		$image_type = $img_type[count($img_type)-1];
	
		// Strip the possible trailing slash off the document root
		$docRoot = preg_replace('/\/$/', '', DOCUMENT_ROOT);
		try
		{
			if (!file_exists($docRoot.$image))
			{
				throw new Exception('Image does not exist: '.$docRoot.$image);
			}
				
			// Get the size and MIME type of the requested image
			$size = GetImageSize($docRoot . $image);
			$mime = $size['mime'];
			$width = $size[0];
			$height = $size[1];
				
			$maxWidth = (isset($_GET['width'])) ? (int) $_GET['width'] : 0;
			$maxHeight = (isset($_GET['height'])) ? (int) $_GET['height'] : 0;
				
			if (isset($_GET['color']))
				$color = preg_replace('/[^0-9a-fA-F]/', '', (string) $_GET['color']);
			else $color = FALSE;
				
			// If either a max width or max height are not specified, we default to something
			// large so the unspecified dimension isn't a constraint on our resized image.
			// If neither are specified but the color is, we aren't going to be resizing at
			// all, just coloring.
			if (!$maxWidth && $maxHeight)
			{
				$maxWidth = 99999999999999;
			}
			elseif ($maxWidth && !$maxHeight)
			{
				$maxHeight = 99999999999999;
			}
			elseif ($color && !$maxWidth && !$maxHeight)
			{
				$maxWidth = $width;
				$maxHeight = $height;
			}
				
			// If we don't have a max width or max height, OR the image is smaller than both
			// we do not want to resize it, so we simply output the original image and exit
				
			if ((!$maxWidth && !$maxHeight) || (!$color && $maxWidth >= $width && $maxHeight >= $height))
			{
				$data = file_get_contents($docRoot . '/' . $image);
					
				$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($docRoot . '/' . $image)) . ' GMT';
				$etag = md5($data);
					
			}
			// Ratio cropping
			$offsetX = 0;
			$offsetY = 0;
				
			if (!empty($_GET['cropratio']))
			{
				$cropRatio = explode(':', (string) $_GET['cropratio']);
				if (count($cropRatio) == 2)
				{
					$ratioComputed		= $width / $height;
					$cropRatioComputed	= (float) $cropRatio[0] / (float) $cropRatio[1];
						
					if ($ratioComputed < $cropRatioComputed)
					{ // Image is too tall so we will crop the top and bottom
						$origHeight	= $height;
						$height		= $width / $cropRatioComputed;
						$offsetY	= ($origHeight - $height) / 2;
					}
					else if ($ratioComputed > $cropRatioComputed)
					{ // Image is too wide so we will crop off the left and right sides
						$origWidth	= $width;
						$width		= $height * $cropRatioComputed;
						$offsetX	= ($origWidth - $width) / 2;
					}
				}
			}
				
			// Setting up the ratios needed for resizing. We will compare these below to determine how to
			// resize the image (based on height or based on width)
			$xRatio = $maxWidth / $width;
			$yRatio = $maxHeight / $height;
				
			if ($xRatio * $height < $maxHeight)
			{ // Resize the image based on width
				$tnHeight = ceil($xRatio * $height);
				$tnWidth = $maxWidth;
			}
			else // Resize the image based on height
			{
				$tnWidth = ceil($yRatio * $width);
				$tnHeight = $maxHeight;
			}
				
			// Determine the quality of the output image
			$quality = (isset($_GET['quality'])) ? (int) $_GET['quality'] : DEFAULT_QUALITY;
				
			// Before we actually do any crazy resizing of the image, we want to make sure that we
			// haven't already done this one at these dimensions. To the cache!
			// Note, cache must be world-readable
				
			// We store our cached image filenames as a hash of the dimensions and the original filename
			$resizedImageSource = $tnWidth . 'x' . $tnHeight . 'x' . $quality;
			if ($color)
				$resizedImageSource	.= 'x' . $color;
			if (isset($_GET['cropratio']))
				$resizedImageSource .= 'x' . (string) $_GET['cropratio'];
			$resizedImageSource .= '-' . $image;
				
			$resizedImage = md5($resizedImageSource);
				
			$resized= $cache_dir.$file_name;
				
			// We don't want to run out of memory
			ini_set('memory_limit', MEMORY_TO_ALLOCATE);
				
			// Set up a blank canvas for our resized image (destination)
			$dst	= imagecreatetruecolor($tnWidth, $tnHeight);
				
			// Set up the appropriate image handling functions based on the original image's mime type
			switch ($size['mime'])
			{
				case 'image/gif':
					// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
					// This is maybe not the ideal solution, but IE6 can suck it
					$creationFunction	= 'ImageCreateFromGif';
					$outputFunction		= 'ImagePng';
					$mime				= 'image/png'; // We need to convert GIFs to PNGs
					$doSharpen			= FALSE;
					$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
					break;
						
				case 'image/x-png':
				case 'image/png':
					$creationFunction	= 'ImageCreateFromPng';
					$outputFunction		= 'ImagePng';
					$doSharpen			= FALSE;
					$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
					break;
						
				default:
					$creationFunction	= 'ImageCreateFromJpeg';
					$outputFunction	 	= 'ImageJpeg';
					$doSharpen			= TRUE;
					break;
			}
				
			// Read in the original image
			$src	= $creationFunction($docRoot . $image);
				
			if (in_array($size['mime'], array('image/gif', 'image/png')))
			{
				if (!$color)
				{
					// If this is a GIF or a PNG, we need to set up transparency
					imagealphablending($dst, false);
					imagesavealpha($dst, true);
				}
				else
				{
					// Fill the background with the specified color for matting purposes
					if ($color[0] == '#')
						$color = substr($color, 1);
						
					$background	= FALSE;
						
					if (strlen($color) == 6)
						$background	= imagecolorallocate($dst, hexdec($color[0].$color[1]), hexdec($color[2].$color[3]), hexdec($color[4].$color[5]));
					else if (strlen($color) == 3)
						$background	= imagecolorallocate($dst, hexdec($color[0].$color[0]), hexdec($color[1].$color[1]), hexdec($color[2].$color[2]));
					if ($background)
						imagefill($dst, 0, 0, $background);
				}
			}
				
			// Resample the original image into the resized canvas we set up earlier
			ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);
				
			if ($doSharpen)
			{
				// Sharpen the image based on two things:
				//	(1) the difference between the original size and the final size
				//	(2) the final size
				$sharpness	= $this->findSharp($width, $tnWidth);
					
				$sharpenMatrix	= array(
					array(-1, -2, -1),
					array(-2, $sharpness + 12, -2),
					array(-1, -2, -1)
				);
				$divisor		= $sharpness;
				$offset			= 0;
				imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
			}
				
			// Write the resized image to the cache
			$outputFunction($dst, $resized, $quality);
				
			// Put the data of the resized image into a variable
			ob_start();
			$outputFunction($dst, null, $quality);
			$data	= ob_get_contents();
			ob_end_clean();
				
			// Clean up the memory
			ImageDestroy($src);
			ImageDestroy($dst);
				
			// See if the browser already has the image
			$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($resized)) . ' GMT';
			$etag = md5($data);
				
		}
		catch (Exception $e)
		{
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['admin_info'] = $e->getMessage();
			print_r($e->getMessage());exit;
			return false;
		}
		return true;
	}
	
	public function findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
	{
		$final = $final * (750.0 / $orig);
		$a = 52;
		$b = -0.27810650887573124;
		$c = .00047337278106508946;
	
		$result = $a + $b * $final + $c * $final * $final;
	
		return max(round($result), 0);
	}
}