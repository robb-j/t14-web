<?php

/*
 * ImageController.php 
 * Rob Anderson - robb-j - 2014

 * Provides URL access to Just In Time (JIT) image resizing
 * Setup the appropriate routes in mysite/-config/routes.yml:
 * 		'image/$ImageId/$Width/$Height': 'ImageController'
*/
class ImageController extends Controller {
	
	public $ResizedImage;
	
	public function index($request) {
		
		// Get Image
		$params = $request->allParams();
		$imageId = intval($params['ImageId']);
		$image = Image::get()->byId($imageId);
		
		// Resize Image
		$width = intval($params['Width']);
		$height = intval($params['Height']);
		$this->ResizedImage = $image->CroppedImage($width, $height);
		
		
		header("Content-Type:image/jpeg");
		$loc = 'http://' . getenv('HTTP_HOST') . Director::baseUrl() . $this->ResizedImage->getRelativePath();
		$res = imagecreatefromjpeg($loc);
		imageJpeg($res);
		
		// Render with a template
		//return $this->renderWith(array('Image'));
	}
	
	public function Output() {
		
		header("Content-Type:image/jpeg");
		$loc = 'http://' . getenv('HTTP_HOST') . Director::baseUrl() . $this->ResizedImage->getRelativePath();
		$res = imagecreatefromjpeg($loc);
		imageJpeg($res);
	}
}