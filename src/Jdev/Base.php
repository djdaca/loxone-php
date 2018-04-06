<?php

namespace Loxone\Jdev;

use Loxone;
use GuzzleHttp;

/**
 * Description of Base
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
abstract class Base
{
	protected $controls = [];
	
	protected $raw = false;
	
	protected $Client;
	
	public function setClient(Loxone\Client $Client) 
	{
		$this->Client = $Client;
		return $this;
	}
	
	public function control($name = null, $value = null)
	{
		if( $name && in_array($name, $this->controls) == false ) {
			throw new \Exception("control ".$name." not exist");
		}
		$res = $this->Client->getHttpClient()->request("GET", $this->Client->getUrl($name));
		$body = $res->getBody();
		if( $this->raw ) {
			return $body;
		}
		try {
			$body = GuzzleHttp\json_decode($body, true);
		} catch (\InvalidArgumentException $exc) {
			$tmp = simplexml_load_string($body);
			if( $tmp ) {
				$body = $tmp;
				unset($tmp);
			}
		}
		if( is_array($body) && isset($body['LL']) ) {
			return new Loxone\LL($body['LL']);
		}
		return $body;
	}
	
	public function __call($name, $arguments)
	{
		return $this->control($name, ...$arguments);
	}
	
	public function raw($enable = true)
	{
		$this->raw = $enable;
		return $this;
	}
	
	public function availableControls()
	{
		return $this->controls;
	}
}
