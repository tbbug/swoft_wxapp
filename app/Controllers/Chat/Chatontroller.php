<?php

namespace App\Controllers\Chat;

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\WebSocket\Server\Bean\Annotation\WebSocket;
use Swoft\WebSocket\Server\HandlerInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Swoft\Db\Query;
use Swoft\Cache\Cache;

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
//        $msg=json_encode(self::getChatJson($openid));
//        dump($request->post());
//         $server->push($fd, $msg);
    }

    /**
     * @param Server $server
     * @param Frame $frame
     */
    public function onMessage(Server $server, Frame $frame)
    {
        $msg=$frame->data;
        $msg=json_decode($msg,true);
        $have = Query::table('user')->where('openid',$msg['openid'])->one()->getResult();
        $user_id=$have['id'];
        if($msg['type']=='getchatjson'){
            $msgs=json_encode(self::getChatJson($msg['openid']));
            $server->push($frame->fd, $msgs);
        }else{
            $array=[
                'user_id'=> $user_id,
                'openid'=> $msg['openid'],
                'type'=> 'else',
                'avatar'=> $msg['avatar'],
                'msg'=> $msg['msg'],
                'send_time'=> date("Y年m月d日 H:i:s",time())
            ];
            self::setChatJson($array);
            //用户绑定fd
            $server->bind($frame->fd, $user_id);
            $re_array=array();
            array_push($re_array,$array);
            \Swoft::$server->broadcast(json_encode($re_array),[],[$frame->fd],$frame->fd);
        }


    }

    /**
     * @param Server $server
     * @param int $fd
     */
    public function onClose(Server $server, int $fd)
    {
//        dump($server);
        // do something. eg. record log, unbind user ...
    }

    /**
     * @return array
     * 聊天消息池保存近20条消息
     */
    public function setChatJson(array $chat):array {
        $json_chat=self::getChatJson();
//        $json_chat=array();
        if(count($json_chat)>=20){
            array_shift($json_chat);//去除第一个元素
        }
        array_push($json_chat,$chat);//入栈最新元素
            cache()->set('chatJson', $json_chat);
        return $json_chat;
    }

    /**
     * @return array
     * 获取聊天记录
     */
    public function getChatJson(string $openid=''):array {
      $json_chat= cache()->get('chatJson');
      if(!$json_chat){
          $json_chat=array();
      }
      if(!empty($openid)){
       foreach ($json_chat as $k=>$v){
       if($openid==$v['openid']){
           $json_chat[$k]['type']='self';
       }
       }
      }
      return $json_chat;
    }
}
