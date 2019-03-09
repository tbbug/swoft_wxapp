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
 * @Controller(prefix="/wxapp/index")
 */
class IndexController
{
    /**
     * 登录初始化接口
     * 地址:/wxapp/index/index.
     *
     * @RequestMapping(route="index", method={RequestMethod::GET,RequestMethod::POST})
     *
     * @param int $uid
     *
     * @return array
     * 指定返回类型
     */
    public function  index(){

        $have=Query::table('user')->one()->getResult();
        return ['getUser'=>'这是一个主页','data'=>$have];
    }


    /**
     * 获得文章列表
     * @RequestMapping(route="lists", method={RequestMethod::GET,RequestMethod::POST})
     */
    public function lists(){
        $have=Query::table('user')->one()->getResult();
        return ['getUser'=>'这是一个主页','data'=>$have];

    }


}
