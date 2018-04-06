<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Sps
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Sps extends Base
{
	const CONTROL_STATE = 'state',
	CONTROL_RESTART = 'restart',
	CONTROL_STOP = 'stop',
	CONTROL_RUN = 'run',
	CONTROL_LOG = 'log',
	CONTROL_NOLOG = 'nolog',
	CONTROL_ENUMDEV = 'enumdev',
	CONTROL_ENUMIN = 'enumin',
	CONTROL_ENUMOUT = 'enumout',
	CONTROL_IDENTIFY = 'identify',
	CONTROL_IO = 'io';
	
	protected $controls = [
		self::CONTROL_STATE,
		self::CONTROL_RESTART,
		self::CONTROL_STOP,
		self::CONTROL_RUN,
		self::CONTROL_LOG,
		self::CONTROL_NOLOG,
		self::CONTROL_ENUMDEV,
		self::CONTROL_ENUMIN,
		self::CONTROL_ENUMOUT,
		self::CONTROL_IDENTIFY,
		self::CONTROL_IO
	];
	
	/*****
	 * States:
	 * 1 – PLC startuje
	 * 2 – PLC program je načten
	 * 3 – PLC se spustí
	 * 4 – spuštění sběrnice
	 * 5 – PLC běží
	 * 6 – PLC změna
	 * 7 – PLC chyba
	 * 8 – v současné době se provádí aktualizace
	 ****/
		
	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('jdev/sps');
		$this->setClient($Client);
	}
}
