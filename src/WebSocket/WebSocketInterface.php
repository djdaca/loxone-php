<?php

namespace Loxone\Websocket;

interface WebSocketInterface
{
	const OP_CODE_CONTINUATION = 0,
		OP_CODE_TEXT = 1,
		OP_CODE_BINARY = 2,
		OP_CODE_CLOSE = 8,
		OP_CODE_PING = 9,
		OP_CODE_PONG = 10;
	
	const RFC_KEY = '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
	
	public function isConnected();
	
	public function getLastOpcode();
	
	public function getCloseStatus();
	
	public function send($data, $opcode = WebSocketInterface::OP_CODE_TEXT, $masked = false);
	
	public function receive();
}