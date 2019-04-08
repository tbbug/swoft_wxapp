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
use Swoft\HttpClient\Client;
use Swoft\Db\Query;
use Swoft\Task\Task;

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
    public function index()
    {

        $have = Query::table('user')->one()->getResult();
        return ['getUser' => '这是一个主页', 'data' => $have];
    }


    /**
     * 获得文章列表
     * @RequestMapping(route="lists", method={RequestMethod::GET,RequestMethod::POST})
     */
    public function lists()
    {

        return self::fdata();

    }

    /**
     * 获得文章列表
     * @RequestMapping(route="one", method={RequestMethod::GET,RequestMethod::POST})
     */
    public function one(Request $request)
    {
        $id = $request->json('id');
        $ar = self::fdata();
        foreach ($ar['data'] as $k => $v) {
            if ($v['id'] == $id) {
                $aas = $v;

            }

        }
        return $aas;

    }

    public static function fdata()
    {

        $have = Query::table('content_list')->get()->getResult();
        $harray = [
            "res" => 0,
            "data" => $have

        ];
        return $harray;


    }

    /**
     * 推送开关
     * @RequestMapping(route="push", method={RequestMethod::GET,RequestMethod::POST})
     */
    public function push(Request $request)
    {
        $openid = $request->input('openid');
        $rdata = [
            'errcode' => 0,
            'openId' => $openid,
            'openPush' => 1

        ];
        return $rdata;
    }

    /**
     * 推送开关
     * @RequestMapping(route="update", method={RequestMethod::GET,RequestMethod::POST})
     */
    public function update(Request $request)
    {
        $openid = $request->input('openid');
        $rdata = [
            'errcode' => 0,
            'message' => "更新用户信息成功"
        ];
        return $rdata;
    }
    /**
     * 推送开关
     * @RequestMapping(route="about", method={RequestMethod::GET,RequestMethod::POST})
     */
    public function about()
    {
        $data = [
            'errcode' => 0,
            'data' => [['data' => '每日鸡汤插画,
            每天为你分享鸡汤脑补生活细节,
            提高设计敏锐性，从品尝插画开始。',
                'title' => '简介'],
                ['data' => '喵子工作室',
                    'title' => '技术支持']]

        ];
        return $data;
    }

    /**
     * 推送开关
     * @RequestMapping(route="share_setting", method={RequestMethod::GET,RequestMethod::POST})
     */

    public function share_setting(){


        $data = [
            'errcode' => 0,
            'data' => [
                'show_erwer'=>false,
                'share_text'=>'每天打卡，      开启元气满满的新一天！',
                'erweim_url'=>'https://marioblog-1251682606.cos.ap-guangzhou.myqcloud.com/tg/xcxm.jpg',
                'tips_text'=>'长按保存分享打开，开始元气满满的一天！'

            ]

        ];
        return $data;

    }

    /**
     * 投票
     * @RequestMapping(route="crtts", method={RequestMethod::GET,RequestMethod::POST})
     *
     */

    public function crtts(){

        $array=self::fdata();
        dump($array);
//        $have = Query::table('content_list')->batchInsert($array)->getResult();
        $have = Query::table('content_list')->batchInsert($array['data'])->getResult();
//        $have = Query::table('user')->get()->getResult();

        return $have;
    }

}
