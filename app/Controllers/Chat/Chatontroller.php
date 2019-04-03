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
        return [0, $response];//meishijin
    }

    /**
     * @param Server $server
     * @param Request $request
     * @param int $fd
     */
    public function onOpen(Server $server, Request $request, int $fd)
    {
//        $server->push($fd, '连接成功');
    }

    /**
     * @param Server $server
     * @param Frame $frame
     */
    public function onMessage(Server $server, Frame $frame)
    {
        $msg=$frame->data;
        $msg=json_decode($msg,true);
        $array=[
            'user_id'=> $msg['user_id'],
            'type'=> 'else',
            'avatar'=> $msg['avatar'],
            'msg'=> $msg['msg'],
            'send_time'=> date("Y年m月d日 H:i:s",time())
        ];
//        $ss=json_decode($frame->data,true);
//        dump($ss['msg']);
        //获取用户信息
        //生成聊天记录文件在本地
        //地图
        //通过uid


        //用户绑定fd
        $server->bind($frame->fd, $frame->data['user_id']);
        $conn_list = $server->getClientList(0, 10);
        $connection = $server->connection_info(9);
//        $server->push($frame->fd, $array);
//        $server->push($frame->fd, json_encode($conn_list));

//        $server->push($frame->fd, $frame->data);
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
