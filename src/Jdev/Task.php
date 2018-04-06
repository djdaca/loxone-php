<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Task
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Task extends Base
{
	const CONTROL_NAME = 'name',
	CONTROL_PRIORITY = 'priority',
	CONTROL_STACTK = 'stack',
	CONTROL_CONTEXT_SWITCHES = 'contextswitches',
	CONTROL_WAIT_TIMEOUT = 'waittimeout',
	CONTROL_STATE = 'state';
	
	protected $controls = [
		self::CONTROL_NAME,
		self::CONTROL_PRIORITY,
		self::CONTROL_STACK,
		self::CONTROL_CONTEXT_SWITCHES,
		self::CONTROL_WAIT_TIMEOUT,
		self::CONTROL_STATE
	];
	
	public function __construct(Loxone\Client $Client, $number)
	{
		$Client->setCommand(sprintf('jdev/task%d', $number));
		$this->setClient($Client);
	}
}
