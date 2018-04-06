<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Stats
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Stats extends Base
{
	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('stats');
		$this->setClient($Client);
	}
	
	public function __toString()
	{
		return (string) $this->raw()->control();
	}
}
