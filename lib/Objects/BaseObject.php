<?php namespace VP\Objects;
defined('ABSPATH') or die;

class BaseObject
{

	protected $data = [];
	protected $attributes = [];
	protected $meta = [];

	public function __construct() {

	}

	public function loadFromArray($data)
	{

		if (is_object($data))
			$data = (array) $data;

		if (!is_array($data))
			return $this;

		foreach ($data as $item => $value) {

			if (strpos($item, 'post_') === 0) {
				$this->data[preg_replace('/^post_/', '', $item)] = $value;
			} elseif ($item == 'ID') {
				$this->data[$item] = $value;
			} else {
				$this->attributes[$item] = $value;
			}

		}

		return $this;

	}

	public function permalink() {

		$id = $this->get('ID');

		if (!$id)
			return '';

		if ($this->get('permalink'))
			return $this->get('permalink');

		$permalink = \get_permalink($id);

		$this->set('permalink', $permalink);

		return $permalink;

	}

	public function excerpt() {

		$excerpt = $this->get('excerpt');

		if ($excerpt)
			return $excerpt;

		$content = $this->get('content');

		if (!$content)
			return '';

		if (strpos($content, '<!--more-->') !== false)
			return substr($content, 0, strpos($content, '<!--more-->'));

		return trim(substr($content, 500)) . '...';

	}

	public function date($format = '%Y-%m-%d %H:%M:%S')
	{

		$date = $this->get('date_gmt') ?: $this->get('date');

		if (!$date)
			return '';

		return gmstrftime($format, strtotime($date));

	}

	public function set($key, $value = null)
	{
		return $this->_setter($this->data, $key, $value);
	}

	protected function _setter(&$array, $key, $value = null)
	{

		if (is_array($key)) {

			foreach ($key as $singleKey => $value) {
				$array[$singleKey] = $value;
			}

			return $this;

		}

		$array[$key] = $value;

		return $this;

	}

	public function get($key)
	{
		return $this->_getter($this->data, $key);
	}

	public function meta($key)
	{
		return $this->_getter($this->meta, $key);
	}

	public function attr($key)
	{
		return $this->_getter($this->attributes, $key);
	}

	protected function _getter(&$array, $key)
	{

		if (is_array($key)) {

			$collection = [];

			foreach ($key as $singleKey) {
				$collection[$singleKey] = $this->_getter($array, $singleKey);
			}

			return $collection;

		}

		return isset($array[$key]) ?
			$array[$key] :
			null;

	}

	public static function reset()
	{
		\wp_reset_postdata();
	}

}