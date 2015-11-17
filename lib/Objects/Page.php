<?php namespace VP\Objects;
defined('ABSPATH') or die;

use VP\Interfaces;

class Page extends BaseObject implements Interfaces\SluggableObjectsInterface
{

	public function __construct($data = null) {

		parent::__construct($data);

		if ($data) {
			$this->loadFromArray($data);
		}

	}

	public static function fetch($slug) {

		$page = \get_page_by_path($slug, ARRAY_A, 'page');

		if (!$page)
			return null;

		return new static($page);

	}

	public static function link($slug)
	{
		// TODO: Do it using Wordpress' function for it
		return \get_site_url(null, $slug);
	}

}