<?php

namespace Silar\Misc;

class LoginImageManager
{
	private $images;
	private $image;
	private $totalImages;
	private $bnkimg;

	public function __construct()
	{
		$di =  \Phalcon\DI\FactoryDefault::getDefault();
		$this->bnkimg = $di['imgbnk'];
		$this->findLoginImages();
	}

	private function findLoginImages()
	{
		$this->images = \Imagebank::find();
		$this->totalImages = \count($this->images);

		if ($this->totalImages > 0) {
			$this->getRandomImage();
		}
		else {
			$this->image = 'none.jpg';
		}
	}

	private function getRandomImage()
	{
		$this->imgselected = rand(0, $this->totalImages - 1);
		$this->image = $this->images[$this->imgselected]->name;
	}

	public function loadImageDir()
	{
		return $this->bnkimg->relativeloginimages . '/' . $this->image;
	}
}
