<?php namespace VP\Interfaces;
defined('ABSPATH') or die;

interface SluggableObjectsInterface {

	public static function fetch($slug);

}