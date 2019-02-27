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
     * @RequestMapping(route="login/{code}", method={RequestMethod::GET,RequestMethod::POST})
     *
     * @param int $uid
     *
     * @return array
     */
    public function login(string $code)
    {
        return ['getUser', $code];
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
        $data=$request->input();


      return ['msg'=>'登录成功！！','data'=>$data];
    }





}
