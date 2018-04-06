<?php

namespace Loxone;

use ArrayAccess;

/**
 * Description of LL
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class LL implements ArrayAccess
{
	protected $control = null;
	
	protected $value = null;
	
	protected $code = null;
	
	public function __construct(array $arr)
	{
		if( isset($arr['control']) ) {
			$this->control = $arr['control'];
		}
		if( isset($arr['value']) ) {
			$this->value = $arr['value'];
		}
		if( isset($arr['Code']) ) {
			$this->code = $arr['Code'];
		}
	}
	
	public function getControl()
	{
		return $this->control;
	}
	
	public function getValue()
	{
		$value = $this->value;
		$values = explode(',', str_replace(['\'', '{', '}', ' '], '', $value));
		if( count($values) > 1 ) {
			$value = [];
			foreach($values as $line) {
				$valuePart = explode(':', $line, 2);
				$value[$valuePart[0]] = $valuePart[1];
			}
			return $value;
		} 
		return (string) $value;
	}
	
	public function getRawValue()
	{
		return $this->value;
	}
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function offsetSet($offset, $value)
	{
		if ($offset) {
			$this[$offset] = $value;
		}
	}

	public function offsetExists($offset)
	{
		return isset($this[$offset]);
	}

	public function offsetUnset($offset) 
	{
		unset($this[$offset]);
	}

	public function offsetGet($offset) 
	{
		$name = 'get'.ucfirst($offset);
		if(method_exists($this, $name) ) {
			return call_user_func(array($this, $name));
		}
		return null;
	}
}
