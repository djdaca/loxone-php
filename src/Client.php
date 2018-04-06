<?php

namespace Loxone;

use GuzzleHttp;

/**
 * Description of Client
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Client
{
	// values
	const V_EIN = 'Ein',
	V_ON = 'On',
	V_AUS = 'Aus',
	V_OFF = 'Off',
	V_IMPULS = 'Impuls',
	V_PULSE = 'Pulse';
	
	// digital impuls values
	const DI_IMPULS_PLUS = 'ImpulsPlus',
	DI_IMPULS_MINUS = 'ImpulsMinus',
	DI_PULSE_DOWN = 'PulseDown',
	DI_PULSE_UP = 'PulseUp',
	DI_IMPULS_AB = 'ImpulsAb',
	DI_IMPULS_AUF = 'ImpulsAuf',
	DI_PULSE_OPEN = 'PulseOpen',
	DI_PULSE_CLOSE = 'PulseClose',
	DI_PLUS_EIN = 'PlusEin',
	DI_PLUS_AUS = 'PlusAus',
	DI_UP_ON = 'UpOn',
	DI_UP_OFF = 'UpOff',
	DI_AUF_EIN = 'AufEin',
	DI_AUF_AUS = 'AufAus',
	DI_OPEN_ON = 'OpenOn',
	DI_OPEN_OFF = 'OpenOff',
	DI_MINUS_EIN = 'MinusEin',
	DI_MINUS_AUS = 'MinusAus',
	DI_DOWN_OFF = 'DownOff',
	DI_AB_AUS = 'AbAus',
	DI_CLOSE_OFF = 'CloseOff',
	DI_ON = 1,
	DI_OFF = 0;
	
	protected $HttpClient = null;
	
	protected $address = null;
	
	protected $command = null;
	
	protected $url = null;
	
	protected $server_info = null;
	
	public function __construct($address = null)
	{
		if( $address ) {
			$this->setAddress($address);
			$this->connect();
		}
	}
	
	public function setHttpClient( GuzzleHttp\ClientInterface $Client): self
	{
		$this->HttpClient = $Client;
		return $this;
	}
	
	public function getHttpClient(): GuzzleHttp\ClientInterface
	{
		return $this->HttpClient;
	}
	
	public function setAddress($address = null): self
	{
		$this->address = $address;
		return $this;
	}
	
	public function getAddress(): string
	{
		return $this->address;
	}
	
	public function connect(): void
	{
		try {
			if( empty($this->HttpClient) ) {
				$this->HttpClient = new GuzzleHttp\Client();
			}
			$body = $this->getCfg()->apiKey();
			if( $body instanceof LL) {
				$this->server_info = $body->getValue();
			}
		} catch (\Exception $exc) {
			echo $exc->getMessage();
			echo $exc->getTraceAsString();
		}
	}
	
	public function isReachable(): bool
	{
		if($this->server_info) {
			return true;
		}
		return false;
	}
	
	public function getServerInfo($key = null)
	{
		if( $key ) {
			if( isset($this->server_info[$key]) ) {
				return $this->server_info[$key];
			}
			return null;
		}
		return $this->server_info;
	}
	
	public function getBus(): Jdev\Bus
	{
		return new Jdev\Bus($this);
	}
	
	public function getCfg(): Jdev\Cfg
	{
		return new Jdev\Cfg($this);
	}
	
	public function getData(): Jdev\Data
	{
		return new Jdev\Data($this);
	}
	
	public function getFs(): Jdev\Fs
	{
		return new Jdev\Fs($this);
	}
	
	public function getLan(): Jdev\Lan
	{
		return new Jdev\Lan($this);
	}
	
	public function getSps(): Jdev\Sps
	{
		return new Jdev\Sps($this);
	}
	
	public function getStats(): string
	{
		return new Jdev\Stats($this);
	}
	
	public function getSys(): Jdev\Sys
	{
		return new Jdev\Sys($this);
	}
	
	public function getTask($number): Jdev\Task
	{
		return new Jdev\Task($this, $number);
	}
	
	public function setCommand($command): self
	{
		$this->command = $command;
		return $this;
	}
	
	public function getCommand(): string
	{
		return $this->command;
	}
	
	public function setUrl($url): self
	{
		$this->url = $url;
		return $this;
	}
	
	public function getUrl($control = null, $value = null): string
	{
		if( $this->url ) {
			return $this->url;
		}
		$url = $this->getAddress();
		if( $this->getCommand() ) {
			$url .= "/".$this->getCommand()."/".$control;
			if( $value ) {
				$url .= "/".$value;
			}
		}
		return $url;
	}
	
	public function getPort(): int
	{
		return (int) parse_url($this->address, PHP_URL_PORT);
	}
	
	public function getCredentials(): array
	{
		return [ 
			parse_url($this->address, PHP_URL_USER), 
			parse_url($this->address, PHP_URL_PASS) 
		];
	}
}
