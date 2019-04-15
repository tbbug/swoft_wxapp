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
            'data' => [['data' => '每日吃鸡攻略,
            每天为你分享鸡汤脑补吃鸡细节,
            提高吃鸡爆头率，从品尝鸡汤开始。',
                'title' => '鸡汤简介'],
                ['data' => '喵子工作室',
                    'title' => '技术支持']]

        ];
        return $data;
    }

    /**
     * 推送开关
     * @RequestMapping(route="share_setting", method={RequestMethod::GET,RequestMethod::POST})
     */

    public function share_setting()
    {


        $data = [
            'errcode' => 0,
            'data' => [
                'show_erwer' => true,
                'share_text' => '每天打卡，      开启元气满满的新一天！',
                'erweim_url' => 'https://marioblog-1251682606.cos.ap-guangzhou.myqcloud.com/tg/gh_cad94d8d8d69_258.jpg',
                'tips_text' => '长按保存分享打开，开始元气满满的一天！'

            ],
            'share_info' => [
                'title' => '带上98k跟着哥的步伐，烤鸡就在前面啦',
                'desc' => '带上98k跟着哥的步伐，烤鸡就在前面啦',
                'path' => '/pages/home/index',
                'imageUrl' => 'https://marioblog-1251682606.cos.ap-guangzhou.myqcloud.com/tg/32fa828ba61ea8d31c9608ef71cd924a271f58f5.jpeg?q-sign-algorithm=sha1&q-ak=AKIDylenivu0e1RSN0VDcBnl2jEoxr1iS13p&q-sign-time=1555295929;1555297729&q-key-time=1555295929;1555297729&q-header-list=&q-url-param-list=&q-signature=85a4c1e4b5ccc3a55dc6879a84dd3938dcec4a70&x-cos-security-token=23b6079f42fc02f597bd825a60f3be9bca1697ae10001'
            ]

        ];
        return $data;

    }

    /**
     * 投票
     * @RequestMapping(route="crtts", method={RequestMethod::GET,RequestMethod::POST})
     *
     */

    public function crtts()
    {

        $array = self::fdata();
        dump($array);
//        $have = Query::table('content_list')->batchInsert($array)->getResult();
//        $have = Query::table('content_list')->batchInsert($array['data'])->getResult();
//        $have = Query::table('user')->get()->getResult();
        $have = Query::table('user')->where('openid', 'o28sK0X9D2SyHG8lAq0ayaQdI0BM')->one()->getResult();

        return $have;
    }

}
