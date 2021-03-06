<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers\Wxapp;

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Db\Query;

/**
 * 小程序或小游戏初始化授权接口
 *
 * @Controller(prefix="/wxapp/init")
 */
class InitController
{


    /**
     * 登录初始化接口
     * 地址:/wxapp/init/login.
     *
     * @RequestMapping(route="login", method={RequestMethod::GET,RequestMethod::POST})
     *
     * @param int $uid
     *
     * @return array
     * 指定返回类型
     */
    public function login(Request $request) : array
    {

        $code=$request->input('code');
        if(empty($code)){
            return ['msg'=>'登录参数不能为空！！','code'=>'4004'];
        }
        $loginData=\App\Logic\MiniLogin::Login($code);
        if(!empty($loginData['code'])){
            return $loginData;
        }
        return ['errcode'=>0,'openid'=>$loginData['openid'],'session_key'=>$loginData['session3rd']];
    }

    /**
     * 授权登录接口
     * 地址:/wxapp/init/authLogin.
     *
     * @RequestMapping(route="authLogin", method={RequestMethod::POST})
     *
     * @param int $uid
     *
     * @return array
     */
    public function authLogin(Request $request){
        $data=$request->json();
        $session3rd=$request->json('session3rd');
        $openid=$request->json('openid');
        $postdata=[
            'session3rd'=>$session3rd,
            'openid'=>$openid,
            'rawData'=>$request->json('rawData'),
            'signature'=>$request->json('signature'),
            'iv'=> $request->json('iv'),
            'encryptedData'=> $request->json('encryptedData'),
        ];
//        dump($session3rd.$openid);
        $session_key= cache()->get($session3rd.$openid);
        if(empty($session_key)){
            return ['msg'=>'凭证过期，请关闭程序后重新登陆！','code'=>4005];
        }
        $res=\App\Logic\MiniLogin::authLogin($session_key,$postdata);

      return ['msg'=>'登录成功！！','data'=>$res];
    }




}
