<?php

namespace Loxone\Websocket;

/**
 * Description of Request
 *
 * @author Daniel Čekan <daniel.cekan@zcom.cz>
 */
class Client implements WebSocketInterface
{
	use Request;
	use Response;
	
	protected $socket = null;
	
	protected static $opcodes = array(
		'continuation' => self::OP_CODE_CONTINUATION,
		'text'         => self::OP_CODE_TEXT,
		'binary'       => self::OP_CODE_BINARY,
		'close'        => self::OP_CODE_CLOSE,
		'ping'         => self::OP_CODE_PING,
		'pong'         => self::OP_CODE_PONG
	);
	
	protected $default_headers = [
		'Connection' => 'Upgrade',
		'Upgrade' => 'websocket',
		'Sec-Websocket-Version' => '13'
	];
	
	protected static $fragment_size = 4096;
	
	protected $is_connected = false;
	
	public function __construct($address = null, array $headers = [], $fragment_size = null)
	{
		$addr = parse_url($address);
		print_r($addr);
		if ($addr === false || !isset($addr['host']) || !isset($addr['port'])) {
			throw new WebSocketException('Invalid address');
		}
		$this->socket = @fsockopen('tcp://'.$addr['host'],$addr['port'], $errno, $errstr);
		if ($this->socket === false) {
			throw new WebSocketException(sprintf('Could not connect: %s', $errstr), $errno);
		}
		if( empty($headers['Sec-Websocket-Key'])) {
			$headers['Sec-Websocket-Key'] = $this->_generateKey();
		}
		$headers = array_merge([
				'Host' => $addr['host'].':'.$addr['port'],
			],
			$this->headers,
			$headers
		);
		array_unshift( $headers, 'GET '.(isset($addr['path']) && strlen($addr['path']) ? $addr['path'] : '/').' HTTP/1.1');
		if( $fragment_size ) {
			self::$fragment_size = $fragment_size;
		}
		$this->sendClear(implode("\r\n", $headers)."\r\n");
		$data = $this->receiveClear();
		if (!preg_match('(Sec-Websocket-Accept:\s*(.*)$)mUi', $data, $matches)) {
			throw new WebSocketException('Bad response');
		}
		if (trim($matches[1]) !== base64_encode(pack('H*', sha1($key.self::RFC_KEY)))) {
			throw new WebSocketException('Bad key');
		}
		$this->is_connected = true;
	}
	
	public function opcode2str($opcode)
	{
		$opcode_ints = array_flip(self::$opcodes);
		return $opcode_ints[$opcode];
	}
	
	public function isConnected()
	{
		return $this->is_connected;
	}
	
	private function _generateKey()
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"$&/()=[]{}0123456789';
		$length = strlen($chars);
		$key = '';
		for ($i = 0; $i < 16; $i++) {
			$key .= $chars[mt_rand(0, $length-1)];
		}
		return base64_encode($key);
	}
	
	public function __destruct() 
	{
		if ($this->socket) {
			if (get_resource_type($this->socket) === 'stream') {
				fclose($this->socket);
			}
			$this->socket = null;
			$this->is_connected = false;
		}
	}
}
