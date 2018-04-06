<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Sys
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Lan extends Base
{
	const CONTROL_TXP = 'txp',
	CONTROL_TXE = 'txe',
	CONTROL_TXC = 'txc',
	CONTROL_EXH = 'exh',
	CONTROL_TXU = 'txu',
	CONTROL_RXP = 'rxp',
	CONTROL_EOF = 'eof',
	CONTROL_RXO = 'rxo',
	CONTROL_NOB = 'nob';
	
	protected $controls = [
		self::CONTROL_TXP,
		self::CONTROL_TXE,
		self::CONTROL_TXC,
		self::CONTROL_EXH,
		self::CONTROL_TXU,
		self::CONTROL_RXP,
		self::CONTROL_EOF,
		self::CONTROL_RXO,
		self::CONTROL_NOB
	];

	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('jdev/lan');
		$this->setClient($Client);
	}
}
