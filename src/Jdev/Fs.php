<?php

namespace Loxone\Jdev;

use Loxone;
/**
 * Description of Fs
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Fs extends Base
{
	const CONTROL_LIST = 'list',
	CONTROL_GET = 'get',
	CONTROL_DEL = 'del';
	
	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('jdev/fs');
		$this->setClient($Client);
	}
	
	public function fsList($path = null)
	{
		$url = $this->getUrl() . self::CONTROL_LIST.'/';
		if( $path ) {
			$url .= $path;
		}
		$this->Client->setUrl($url);
		return $this->control();
	}
	
	public function fsGet($path)
	{
		return $this->Client->setUrl($this->getUrl() . 'get/'.$path.'/');
	}
	
	public function fsDel($path)
	{
		return $this->Client->setUrl($this->getUrl() . 'del/'.$path.'/');
	}
	
	protected function getUrl()
	{
		return $this->Client->getAddress() .'/'. $this->Client->getCommand();
	}
}

/*
 * http://miniserver/dev/fslist/	Zobrazí list kořenového adresáře na SD kartě
http://miniserver/dev/fslist/path/	Zobrazí se list adresářové cesty na SD kartě
http://miniserver/dev/fsget/filepath/	Načíst soubr (cesta k souboru k nahrazení)
http://miniserver/dev/fsdel/filepath/	Odstraní soubor (podle cesty souboru)
http://miniserver/dev/fsget/log/def.log	Slouží k získání informací v souboru def.log
 */