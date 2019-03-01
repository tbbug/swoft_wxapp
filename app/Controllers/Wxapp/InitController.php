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

/**
 * RESTful和参数验证测试demo.
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
     */
    public function login(Request $request)
    {

        $code=$request->json('code');
        $loginData=\App\Logic\MiniLogin::Login($code);
        return ['getUser'=>$loginData, $code,'data'=>$loginData['data']];
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

      return ['msg'=>'登录成功！！','data'=>$data];
    }





}
