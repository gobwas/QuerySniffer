<?php
namespace Application\Model;
use ReflectionClass;
use Application\Model\Exception\EnumException;


abstract class Enum
{
	/**
	 * @var mixed|null
	 */
	protected $value = null;

	/**
	 * @param $value
	 */
	final public function __construct($value)
	{
		$this->setValue($value);
	}

	/**
	 * @param $value
	 * @throws Exception\EnumException
	 */
	final public function setValue($value)
	{
		if (!in_array($value, static::getConstants(), true)) {
			throw new EnumException("Unknown value '{$value}'; ".print_r(static::getConstants(),1));
		}

		$this->value = $value;
	}

	/**
	 * @return mixed|null
	 */
	final public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param $key
	 * @param $args
	 * @return Enum
	 */
	final public static function __callStatic($key, $args)
	{
		return new static(constant("static::$key"));
	}

	/**
	 * @return array|null
	 */
	public static function getConstants() {
		$reflection = new ReflectionClass(get_called_class());
		return $reflection->getConstants();
	}
}
