<?php
namespace QuerySniffer\Filter;

abstract class AbstractFilter implements IFilter
{
	/**
	 * @var array
	 */
	protected $options = array();

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array())
	{
		$this->setOptions($options);
	}

	/**
	 * @param array $options
	 */
	public function setOptions(array $options)
	{
		$this->options = $options;
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	public function __invoke($value)
	{
		return $this->filter($value);
	}
}
