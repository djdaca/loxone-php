<?php

namespace Loxone\Websocket;

/**
 * Description of Receive
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
trait Response
{
	protected $close_status;
	
	protected $last_opcode;
	
	public function getCloseStatus()
	{
		return $this->close_status;
	}
	
	public function getLastOpcode()
	{
		$this->last_opcode = $opcode;
	}
	
	public function receiveClear() : string
	{
		$data = '';
		$read = static::$fragmentSize;
		do {
			$buff = fread($this->socket, $read);
			if ($buff === false) {
				return '';
			}
			$data .= $buff;
			$meta = stream_get_meta_data($this->socket);
			$read = min((int) $meta['unread_bytes'], static::$fragmentSize);
			usleep(1000);
		} while (!feof($this->socket) && (int) $meta['unread_bytes'] > 0);
		if (strlen($data) === 1) {
			$data .= $this->receiveClear();
		}
		return $data;
	}
	
	public function receive() : string
	{
		$data = fread($this->socket, 2);
		if ($data === false) {
			throw new WebSocketException('Could not receive data');
		}
		if (strlen($data) === 1) {
			$data .= fread($this->socket, 1);
		}
		if ($data === false || strlen($data) < 2) {
			throw new WebSocketException('Could not receive data');
		}
		$final = (bool) (ord($data[0]) & 1 << 7);
		$rsv1 = (bool) (ord($data[0]) & 1 << 6);
		$rsv2 = (bool) (ord($data[0]) & 1 << 5);
		$rsv3 = (bool) (ord($data[0]) & 1 << 4);
		$this->last_opcode = ord($data[0]) & 31;
		$masked = (bool) (ord($data[1]) >> 7);
		$payload = '';
		$length = (int) (ord($data[1]) & 127); // Bits 1-7 in byte 1
		if ($length > 125) {
			$temp = $length === 126 ? fread($this->socket, 2) : fread($this->socket, 8);
			if ($temp === false) {
				throw new WebSocketException('Could not receive data');
			}
			$length = '';
			for ($i = 0; $i < strlen($temp); ++$i) {
				$length .= sprintf('%08b', ord($temp[$i]));
			}
			$length = bindec($length);
		}
		$mask = '';
		if ($masked) {
			$mask = fread($this->socket, 4);
			if ($mask === false) {
				throw new WebSocketException('Could not receive mask data');
			}
		}
		if ($length > 0) {
			$temp = '';
			do {
				$buff = fread($this->socket, min($length, static::$fragmentSize));
				if ($buff === false) {
					throw new WebSocketException('Could not receive data');
				}
				$temp .= $buff;
			} while (strlen($temp) < $length);
			if ($masked) {
				for ($i = 0; $i < $length; ++$i) {
					$payload .= ($temp[$i] ^ $mask[$i % 4]);
				}
			} else {
				$payload = $temp;
			}
		}
		if ($this->last_opcode === Client::OP_CODE_CLOSE) {
			if( $length > 2 ) {
				$this->close_status = $status = bindec(sprintf("%08b%08b", ord($payload[0]), ord($payload[1])));
				if (!$this->is_closing) {
					$this->send($payload[0] . $payload[1] . 'Close acknowledged: ' . $status, 'close', true); // Respond.
				}
			}
			$this->is_connected = false;
			throw new WebSocketException('Client disconnect');
		}
		return $final ? $payload : $payload.$this->receive();
	}
}
