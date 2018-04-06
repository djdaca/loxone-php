<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Bus
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Bus extends Base
{
	const CONTROL_PACKET_SENT = 'packetssent',
	CONTROL_PACKETS_RECEIVED = 'packetsreceived',
	CONTROL_RECEIVE_ERRORS = 'receiveerrors',
	CONTROL_FRAME_ERRORS = 'frameerrors',
	CONTROL_OVER_RUNS = 'overruns',
	CONTROL_PARITY_ERRORS = 'parityerrors';
	
	protected $controls = [
		self::CONTROL_PACKET_SENT,
		self::CONTROL_PACKETS_RECEIVED,
		self::CONTROL_RECEIVE_ERRORS,
		self::CONTROL_FRAME_ERRORS,
		self::CONTROL_OVER_RUNS,
		self::CONTROL_PARITY_ERRORS
	];
	
	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('jdev/bus');
		$this->setClient($Client);
	}
}
