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
        $id = $request->input('id');
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
        $harray = [
            "res" => 0,
            "data" => [
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2375",
                    "date" => "2019 / 03 / 09",
                    "title" => "VOL.2345",
                    "url" => "http://m.wufazhuce.com/one/2375",
                    "img_url" => "http://image.wufazhuce.com/FkNFCXwMly1KFegumB6Wkx_642wH",
                    "picture_author" => "摄影 | Niket Nigde",
                    "content" => "不管你做什么，都要做到极致，上班就认真工作，笑就尽情大笑，吃东西时，就像吃最后一餐那样去享受。",
                    "text_authors" => "《绿皮书》"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2374",
                    "date" => "2019 / 03 / 08",
                    "title" => "VOL.2344",
                    "url" => "http://m.wufazhuce.com/one/2374",
                    "img_url" => "http://image.wufazhuce.com/FsT8f0U1LqlUtdljfKRR8SOMzGH3",
                    "picture_author" => "摄影 | Darya Skuratovich",
                    "content" => "没有人会像你想的那样爱你，明白了这一点你就不会再瞎想了。",
                    "text_authors" => "傅首尔"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2373",
                    "date" => "2019 / 03 / 07",
                    "title" => "VOL.2343",
                    "url" => "http://m.wufazhuce.com/one/2373",
                    "img_url" => "http://image.wufazhuce.com/FrLh24BDmgD87iW8rQq02dOYEJVb",
                    "picture_author" => "摄影 | 桂林大河",
                    "content" => "我们活在世上，必须要爱一些人，伤害一些人，再忘记一些人。",
                    "text_authors" => "苏更生"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2372",
                    "date" => "2019 / 03 / 06",
                    "title" => "VOL.2342",
                    "url" => "http://m.wufazhuce.com/one/2372",
                    "img_url" => "http://image.wufazhuce.com/Fj7zpzj6kuRpJtElqwUkExkDqKUq",
                    "picture_author" => "摄影 | 徐盛哲",
                    "content" => "曾经爱你的每一条街，是我新鲜生活的起点 。",
                    "text_authors" => "李志"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2371",
                    "date" => "2019 / 03 / 05",
                    "title" => "VOL.2341",
                    "url" => "http://m.wufazhuce.com/one/2371",
                    "img_url" => "http://image.wufazhuce.com/FvUWnb7Rq8Lk45XcEnffiK4_6NRb",
                    "picture_author" => "插画 | 狐狸狐狸鱼",
                    "content" => "一个人思考不好，爱不好，睡不好，归根结底，都是因为吃得不好。",
                    "text_authors" => "伍尔夫"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2370",
                    "date" => "2019 / 03 / 04",
                    "title" => "VOL.2340",
                    "url" => "http://m.wufazhuce.com/one/2370",
                    "img_url" => "http://image.wufazhuce.com/Fg_0wVcmZKlR7lF6qickNf0Sp8ju",
                    "picture_author" => "摄影 | Vitor Pinto",
                    "content" => "“为了家人/爱人努力活下去”都不如一句“某某剧要回归了”更能让我燃起对生活的欲望。",
                    "text_authors" => "李濛"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2369",
                    "date" => "2019 / 03 / 03",
                    "title" => "VOL.2339",
                    "url" => "http://m.wufazhuce.com/one/2369",
                    "img_url" => "http://image.wufazhuce.com/Fg5TR-x6bZSSG2QL4lEUuzfT0-V8",
                    "picture_author" => "摄影 | Yoav Aziz",
                    "content" => "堵车是最让人难受的事情：你爱开车，你也的确在开车，但你就是没有真正在开车。其实我们做很多事情都是这样：你爱这件事，你也的确在做这件事，但你就是没有真正在做这件事。",
                    "text_authors" => "韩寒"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2368",
                    "date" => "2019 / 03 / 02",
                    "title" => "VOL.2338",
                    "url" => "http://m.wufazhuce.com/one/2368",
                    "img_url" => "http://image.wufazhuce.com/FrBuuL1ACR8Lq64VzXyY96BdqIB2",
                    "picture_author" => "插画 | 林庭",
                    "content" => "真心是最容易被辜负的东西，辜负一份工作，你得损失钱，辜负一次合作，你得损失机会，辜负真心能损失什么呢？这么看来，真心一文不值，在不需要真心的人眼里。 ",
                    "text_authors" => "苏更生"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2367",
                    "date" => "2019 / 03 / 01",
                    "title" => "VOL.2337",
                    "url" => "http://m.wufazhuce.com/one/2367",
                    "img_url" => "http://image.wufazhuce.com/Fh0XS7aucYI1BxpNDyJ6QBV9BQS-",
                    "picture_author" => "摄影 | Taneli Lahtinen",
                    "content" => "我们总是忘了事情是怎么开始的，却执着于控制它结束的方式。“事情不应该这么结束”，于是千千万万段感情继续着，以奇形怪状的式样。",
                    "text_authors" => "颜卤煮"
                ],
                [
                    "content_type" => 0,
                    "category" => 0,
                    "id" => "2366",
                    "date" => "2019 / 02 / 28",
                    "title" => "VOL.2336",
                    "url" => "http://m.wufazhuce.com/one/2366",
                    "img_url" => "http://image.wufazhuce.com/FsurJHjIg2h50n89b6zFoQHZnnif",
                    "picture_author" => "摄影 | Aliaksei Lepik",
                    "content" => "自己做出的选择，才能建立更牢靠的羁绊。",
                    "text_authors" => "《小偷家族》"
                ]
            ]
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
            'message'=>"更新用户信息成功"
        ];
        return $rdata;
    }

}
