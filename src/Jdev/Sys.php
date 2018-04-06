<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Sys
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Sys extends Base
{
	const CONTROL_NUM_TASKS = 'numtasks',
	CONTROL_CPU = 'cpu',
	CONTROL_CONTEXT_SWITCHES = 'contextswitches',
	CONTROL_CONTEXT_SWITCHESI = 'contextswitchesi',
	CONTROL_HEAP = 'heap',
	CONTROL_INTS = 'ints',
	CONTROL_COMINTS = 'comints',
	CONTROL_LANINTS = 'lanints',
	CONTROL_WATCHDOG = 'watchdog',
	CONTROL_DATE = 'date',
	CONTROL_TIME = 'time',
	CONTROL_SET_DATE_TIME = 'setdatetime',
	CONTROL_SPS_CYCLE = 'spscycle',
	CONTROL_NTP = 'ntp',
	CONTROL_REBOOT = 'reboot',
	CONTROL_CHECK = 'check',
	CONTROL_LOGOFF = 'logoff',
	CONTROL_SDTEST = 'sdtest',
	CONTROL_LAST_CPU = 'lastcpu',
	CONTROL_SEARCH = 'search',
	CONTROL_SEARCH_DATA = 'search_data',
	CONTROL_EXT_STATISTICS = 'ExtStatistics',
	CONTROL_AIR_STATISTICS = 'AirStatistics',
	CONTROL_UPDATE_EXT = 'updatetext';
	
	protected $controls = [
		self::CONTROL_NUM_TASKS,
		self::CONTROL_CPU,
		self::CONTROL_CONTEXT_SWITCHES,
		self::CONTROL_CONTEXT_SWITCHESI,
		self::CONTROL_HEAP,
		self::CONTROL_INTS,
		self::CONTROL_COMINTS,
		self::CONTROL_LANINTS,
		self::CONTROL_WATCHDOG,
		self::CONTROL_DATE,
		self::CONTROL_TIME,
		self::CONTROL_SET_DATE_TIME,
		self::CONTROL_SPS_CYCLE,
		self::CONTROL_NTP,
		self::CONTROL_REBOOT,
		self::CONTROL_CHECK,
		self::CONTROL_LOGOFF,
		self::CONTROL_SDTEST,
		self::CONTROL_LAST_CPU,
		self::CONTROL_SEARCH,
		self::CONTROL_SEARCH_DATA,
		self::CONTROL_EXT_STATISTICS,
		self::CONTROL_AIR_STATISTICS,
		self::CONTROL_UPDATE_EXT
	];
	
	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('jdev/sys');
		$this->setClient($Client);
	}
}
