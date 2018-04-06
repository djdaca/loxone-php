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
		self::CONTROL_STATUS
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