<?php

namespace Loxone\Jdev;

use Loxone;
/**
 * Description of Data
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Data extends Base
{
	const CONTROL_STATUS = 'status',
	CONTROL_WEATHERU = 'weatheru.xml',
	CONTROL_LOXAPP2 = 'LoxAPP2.xml';
	
	protected $controls = [
		self::CONTROL_STATUS,
		self::CONTROL_WEATHERU,
		self::CONTROL_LOXAPP2
	];

	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('data');
		$this->setClient($Client);
	}
	
	public function weatheru()
	{
		return $this->control(self::CONTROL_WEATHERU);
	}
	
	public function LoxAPP2()
	{
		return $this->control(self::CONTROL_LOXAPP2);
	}
}

/*
 * http://miniserver/data/status	Zobrazuje stav Miniserveru a všech Extensionů
 * http://miniserver/data/weatheru.xml	Zobrazuje údaje o počasí
 * http://miniserver/data/LoxAPP2.xml	Struktura souboru pro vizualizaci
 * http://miniserver/stats	Stav statistiky
 */