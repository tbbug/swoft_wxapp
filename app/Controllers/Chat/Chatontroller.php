<?php

namespace App\Controllers\Chat;

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\WebSocket\Server\Bean\Annotation\WebSocket;
use Swoft\WebSocket\Server\HandlerInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Class EchoController
 * @package App\WebSocket
 * @WebSocket("/chat")
 */
class Chatontroller implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function checkHandshake(Request $request, Response $response): array
    {
        return [0, $response];
    }

    /**
     * @param Server $server
     * @param Request $request
     * @param int $fd
     */
    public function onOpen(Server $server, Request $request, int $fd)
    {
        $server->push($fd, '连接成功');
    }

    /**
     * @param Server $server
     * @param Frame $frame
     */
    public function onMessage(Server $server, Frame $frame)
    {
        $array=[
            'user_id'=> $frame->fd,
            'type'=> 'else',
            'msg'=> $frame->data,
            'send_time'=> date("Y年m月d日 H:i:s",time())
        ];
//        $server->push($frame->fd, json_encode($array));
        \Swoft::$server->broadcast(json_encode($array),[],[$frame->fd],$frame->fd);

    }

    /**
     * @param Server $server
     * @param int $fd
     */
    public function onClose(Server $server, int $fd)
    {
        // do something. eg. record log, unbind user ...
    }
}
