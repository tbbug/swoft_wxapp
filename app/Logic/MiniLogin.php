<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/23
 * Time: 17:17
 */

namespace app\Logic;


use EasyWeChat\Factory;
use Swoft\Cache\Cache;
use Swoft\Db\Query;
class MiniLogin
{
    /**
     * @Inject("cache")
     * @var Cache
     */
    private $cache;
    //换取微信openid和session
    //公用小程序对象
    public static function miniObj(){

        $appId=env('APPID', '');
        $appseciret = env('APPSECIRET', '');
        $config = [
            'app_id' => $appId,
            'secret' => $appseciret,

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' =>'/runtime/logs/easywechat/miniwechat.log',
            ],
        ];
        $wxObj =Factory::miniProgram($config);
        return $wxObj;
    }

    public static function miniGetOpenid($code)
    {
        $wxObj=self::miniObj();
        $Lobj= $wxObj->auth->session($code);
        return $Lobj;
    }

    //登录 ---- 依据openid与unionid进行判断  ---  openid  unionid 设置成了唯一索引，避免并发执行时，向库里面插入多条记录
    public static function Login( $code )
    {
        $LoginObj=self::miniGetOpenid($code);
        //初始化cache  确保两分钟内，用户只请求一次登陆接口

        //没有unionid，只获取到openid的情况  ------  unionid没有值，赋值为空
        if( empty($LoginObj['unionid']) && !empty($LoginObj['openid']) ){
            $LoginObj['unionid']='';
            $have=Query::table('user')->where('openid',$LoginObj['openid'])->limit(1)->get()->getResult();
            //unionid与openid同时存在
        }elseif( !empty($LoginObj['unionid']) && !empty($LoginObj['openid']) ){
            $have=Query::table('user')->where('unionid',$LoginObj['unionid'])->limit(1)->get()->getResult();
        }else{
            return ['code'=>404,'msg'=>'登录失败请重新登录，','data'=>$LoginObj];
        }

        $openid=$LoginObj['openid'];
        $session_key=$LoginObj['session_key'];
        //生成第三方3rd_session
        $session3rd  = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
        for($i=0;$i<16;$i++){
            $session3rd .=$strPol[rand(0,$max)];
        }
        cache()->set($session3rd.$openid, $session_key,604800);
        //用户数据入库
        if(empty($have)){
            $userData=array(
                'unionid'=>$LoginObj['unionid'],
                'openid'=>$LoginObj['openid'],
                'create_time'=>time(),
                'nickname'=>'游客'
            );
            $user_id = Query::table('user')->insert($userData)->getResult();
            return ['session3rd'=>$session3rd,'isfirst'=>1,'userdata'=>$userData,'user_id'=>$user_id];
        }else{
            $have['openid']=$openid;
            return ['userData'=>$have,'session3rd'=>$session3rd,'isfirst'=>0, 'user_id'=>$have['id']];
        }

    }



    //解密获取用户详细信息
    public static function miniGetUserInfo($sessionKey, $iv, $encryptData)
    {

        $wxObj=self::miniObj();
        $decryptedData = $wxObj->encryptor->decryptData($sessionKey, $iv, $encryptData);
        return $decryptedData;
    }

    //微信授权登录注册用户信息  ---  user_id   openid   unionid 均设置成了唯一索引，避免并发执行时，向库里面插入多条记录
    public static  function  authLogin($session_key,$rdata)
    {
        // 数据签名校验
        $signature = $rdata["signature"];
        $signature2 = sha1($rdata['rawData'].$session_key);
        if ($signature != $signature2) {
            $msg = "check fail";
            return ['code'=>'2','message'=>'获取失败',"result"=>$msg];
        }
        //保存（更新）用户信息
        try{
            $Udata=self::miniGetUserInfo($session_key,$rdata['iv'],$rdata['encryptedData']);
            if(isset($Udata['unionId'])){
                $unionid = $Udata['unionId'];
            }else{
                $unionid = 'unc';
            }
            $openid = $Udata['openId'];

            //获取用户信息 ----  绑定了公众平台，则会有unionid  ----  登陆时，若是unionid没有值，赋值为空了
            if($unionid){
                $userd = Query::table('user')->where('unionid',$unionid)->limit(1)->get()->getResult();
                if(empty($userd)){
                    $userd = Query::table('user')->where('openid',$openid)->limit(1)->get()->getResult();
                }
                // ---- 没有绑定公众平台的情况
            }else{
                $userd = Query::table('user')->where('openid',$openid)->limit(1)->get()->getResult();
            }
            if(empty($userd)){
                $userd = Query::table('user')->insert(array('openid'=>$openid, 'unionid'=>$unionid, 'nickname'=>$Udata['nickName'],'create_time'=>time()))->getResult();
            }else{
                //新用户授权后，更新用户表
                if(empty($userd)){
                    Query::table('user')->where('id',$userd['id'])->update(array('nickname'=>$Udata['nickName'],'unionid'=>$unionid))->getResult();
                }else{
                    //这一步是为了避免，用户已经授权后，重新更新数据。（只有在用户信息更变时，才会更新用户信息）
                    if( ($Udata['nickName'] != $userd['nickname']) || ($unionid != $userd['unionid'])){
                        Query::table('user')->where('id',$userd['id'])->update(array('nickname'=>$Udata['nickName'],'unionid'=>$unionid))->getResult();
                    }
                }
            }
            $user=self::setFan($userd[0]['id'],$Udata);
            return $user;

        }catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public static  function setFan( $userId, $userInfo)
    {
        try {
            //判断是否已有粉丝信息
            $haveFanInfo=Query::table('wx_fan_info')->where('uid',$userId)->one()->getResult();
            if (empty($haveFanInfo)){
              Query::table('wx_fan_info')->insert([
                    "nickname" => $userInfo['nickName'],
                    "sex" => $userInfo['gender'],
                    'account_id' => 1,
                    'uid' => $userId,
                    "language" => $userInfo['language'],
                    "head_img_url" => $userInfo['avatarUrl'],
                    "country" => $userInfo['country'],
                    "province" => $userInfo['province'],
                    "city" => $userInfo['city'],
                    'unionid' => $userInfo['unionId'],
                    'create_time'=>time(),
                     'update_time'=>time()
                ])->getResult();
            }else{
                $fanInfo=$haveFanInfo;
            }
            return ['fan'=>array(),'fanInfo'=>$fanInfo];

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
