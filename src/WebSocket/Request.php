<?php

namespace Loxone\Websocket;

/**
 * Description of Request
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
trait Request
{
	public function sendClear($data) : bool
	{
		return fwrite($this->socket, $data) > 0;
	}
	
	public function send($data, $opcode = Client::OP_CODE_TEXT, $masked = false)
	{
		while (strlen($data)) {
			$temp = substr($data, 0, static::$fragmentSize);
			$data = substr($data, static::$fragmentSize);
			if ($data === false) {
				$data = '';
			}
			$temp = $this->_encode($temp, $opcode, $masked, strlen($data) === 0);

			if (!is_resource($this->socket) || get_resource_type($this->socket) !== "stream") {
				return false;
			}
			$meta = stream_get_meta_data($this->socket);
			if ($meta['timed_out']) {
				return false;
			}
			if ($this->sendClear($temp) === false) {
				return false;
			}
			$opcode = Client::OP_CODE_CONTINUATION;
		}
		return true;
	}
	
	private function _encode($data, $opcode = self::OP_CODE_TEXT, $masked = true, $final = true)
	{
		$length = strlen($data);
		$head = '';
		$head .= (bool) $final ? '1' : '0';
		$head .= '000';
		$head .= sprintf('%04b', $opcode);
		$head .= (bool) $masked ? '1' : '0';
		if ($length > 65535) {
			$head .= decbin(127);
			$head .= sprintf('%064b', $length);
		} elseif ($length > 125) {
			$head .= decbin(126);
			$head .= sprintf('%016b', $length);
		} else {
			$head .= sprintf('%07b', $length);
		}
		$frame = '';
		foreach (str_split($head, 8) as $binstr) {
			$frame .= chr((int)bindec($binstr));
		}
		$mask = '';
		if ($masked) {
			for ($i = 0; $i < 4; ++$i) {
				$mask .= chr(rand(0, 255));
			}
			$frame .= $mask;
		}
		for ($i = 0; $i < $length; ++$i) {
			$frame .= ($masked === true) ? $data[$i] ^ $mask[$i % 4] : $data[$i];
		}
		return $frame;
	}
}
