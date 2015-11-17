<?php namespace VP\Objects;
defined('ABSPATH') or die;

use VP\Interfaces;

class Post extends BaseObject
{

	public function __construct($data = null) {

		parent::__construct($data);

		if ($data) {
			$this->loadFromArray($data);
		}

	}

}