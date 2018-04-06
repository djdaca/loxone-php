<?php

namespace Loxone\Jdev;

use Loxone;

/**
 * Description of Cfg
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Cfg extends Base
{
	const CONTROL_API = 'api',
	CONTROL_API_KEY = 'apiKey',
	CONTROL_MAC = 'mac',
	CONTROL_VERSION = 'version',
	CONTROL_VERSION_DATE = 'version_date',
	CONTROL_DHCP = 'dhcp',
	CONTROL_IP = 'ip',
	CONTROL_MASK = 'mask',
	CONTROL_GATEWAY = 'gateway',
	CONTROL_DEVICE = 'device',
	CONTROL_DNS1  = 'dns1',
	CONTROL_DNS2  = 'dns2',
	CONTROL_NTP  = 'ntp',
	CONTROL_TIMEZONE_OFFSET  = 'timezoneOffset',
	CONTROL_HTTP  = 'http',
	CONTROL_FTP  = 'ftp',
	CONTROL_LOX_PLAN = 'LoxPLAN',
	CONTROL_FTLLOCALONLY = 'ftllocalonly';
	
	protected $controls = [
		self::CONTROL_API,
		self::CONTROL_API_KEY,
		self::CONTROL_MAC,
		self::CONTROL_VERSION,
		self::CONTROL_VERSION_DATE,
		self::CONTROL_DHCP,
		self::CONTROL_IP,
		self::CONTROL_MASK,
		self::CONTROL_GATEWAY,
		self::CONTROL_DEVICE,
		self::CONTROL_DNS1,
		self::CONTROL_DNS2,
		self::CONTROL_NTP,
		self::CONTROL_TIMEZONE_OFFSET,
		self::CONTROL_HTTP,
		self::CONTROL_FTP,
		self::CONTROL_LOX_PLAN,
		self::CONTROL_FTLLOCALONLY
	];
	
	public function __construct(Loxone\Client $Client)
	{
		$Client->setCommand('jdev/cfg');
		$this->setClient($Client);
	}
}
