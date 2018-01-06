<?php
/**
 *
 * WeChat small program jump brush points
 *
 * @author     MrWang <https://www.sslcvm.com/>
 * @date       2018-01-06 22:10:42
 * @version    1.0.0
 *
 * 严重警告：
 * 1、源码仅供学习交流使用。
 * 2、禁止用于危害官方利益的行为。
 * 3、禁止用于违反法律法规的行为。
 *
 *
 */
error_reporting(0);
header('Content-type: text/json;charset=utf-8');
define('AJAX_URL','https://mp.weixin.qq.com');

$ui = array();

foreach($_GET as $key => $value){
    $ui[$key] = trim($value);
}

$session_id = $ui['session_id'];
$score = $ui['score'];

if( empty($session_id) || empty($score) || !is_numeric($score)){
	die(json_encode(array('date' => 1,'resture' => '请输入正确的带入值')));
}

$path = array(
	"getUserInfo"         => "/wxagame/wxagame_getuserinfo",
	"requestServerInit"   => "/wxagame/wxagame_init",
	"requestFriendsScore" => "/wxagame/wxagame_getfriendsscore",
	"requestSettlement"   => "/wxagame/wxagame_settlement",
	"requestCreateGame"   => "/wxagame/wxagame_creategame",
	"getGroupScore"       => "/wxagame/wxagame_getgrouprank",
	"createPK"            => "/wxagame/wxagame_createpk",
	"getBattleData"       => "/wxagame/wxagame_getpkinfo",
	"updatepkinfo"        => "/wxagame/wxagame_updatepkinfo",
	"quitGame"            => "/wxagame/wxagame_quitgame",
	"syncop"              => "/wxagame/wxagame_syncop",
	"sendReport"          => "/wxagame/wxagame_bottlereport",
	"sendServerError"     => "/wxagame/wxagame_jsreport",
);

function https_curl($url, $post=0){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $header[] = 'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 11_2_1 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Mobile/15C153 MicroMessenger/6.6.1 NetType/WIFI Language/zh_CN';
    $header[] = 'Referer:https://servicewechat.com/wx7c8d593b2c3a7703/6/page-frame.html';
    $header[] = 'Content-Type:application/json';
    $header[] = 'Accept-Language:zh-cn';
    $header[] = 'Accept:*/*';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}

function getMillisecond(){
	list($t1, $t2) = explode(' ', microtime());
	return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}

function encrypt($data, $originKey){
	$data      = str_replace("\\\\", "\\", json_encode($data, JSON_UNESCAPED_SLASHES));
	$originKey = substr($originKey, 0, 16);
	$key       = $originKey;
	$iv        = $originKey;
	$blocksize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$len       = strlen($data); //取得字符串长度
	$pad       = $blocksize - ($len % $blocksize); //取得补码的长度
	$data      .= str_repeat(chr($pad), $pad); // 填充
	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
	$res       = base64_encode($crypttext);
	return $res;
}

$base_req = array(
	"base_req" => array(
		"session_id" => base64_decode($session_id),
		"fast"       =>1
	),
	"version" => 9
);

$base_req_01_ = '{"base_req":{"session_id":"'.base64_decode($session_id).'","fast":1}}';
$_loc1_ = json_decode(https_curl( AJAX_URL.$path['requestFriendsScore'], $base_req_01_ ),true);
$times  = $_loc1_['my_user_info']['times'] + 1;

$base_req_02_ = '{"base_req":{"session_id":"'.base64_decode($session_id).'","fast":1},"version":9}';
$_loc2_ = json_decode(https_curl( AJAX_URL.$path['requestServerInit'], $base_req_02_ ),true);

if( $_loc2_['base_resp']['errcode'] == -1 ){
	die(json_encode(array('date' => 1,'resture' => 'session_id错误')));
}

for ($i = round(10000 + lcg_value(0, 1) * 2000); $i > 0; $i--){
	array_push($action, array( number_format(lcg_value(0, 1), 3), number_format(lcg_value(0, 1) * 2, 2), $i / 5000 == 0 ? true : false ) );
	array_push($musicList, false);
	array_push($touchList, [number_format((250 - lcg_value(0, 1) * 10), 4), number_format((670 - lcg_value(0, 1) * 20), 4)]);
}

$data = array(
	"score"     => $score,
	"times"     => $times,
	"game_data" => json_encode(array(
		"seed"      => 2018,
		"action"    => $action,
		"musicList" => $musicList,
		"touchList" => $touchList,
		"version"   => 1,
	)),
);

$encrypt = encrypt($data,base64_decode($session_id));
$base_req_03_ = "{\"base_req\":{\"session_id\":\"".base64_decode($session_id)."\",\"fast\":1},\"action_data\":\"{$encrypt}\"}";
$_loc3_ = json_decode(https_curl( AJAX_URL.$path['requestSettlement'], $base_req_02_ ),true);

if ( $_loc3_['base_resp']['errcode'] == 0){
	$data = array(
		'error_code'  => '20002',
		'reason'      => 'success',
		'name'        => '跳一跳刷分',
		'result'      => array(
			'score'   => $score,
			'name'    => $_loc1_['my_user_info']['nickname'],
			'week_best_score' => $_loc1_['my_user_info']['week_best_score']
		)
	);
}else{
	$data = array(
		'error_code'  => '10001',
		'reason'      => '刷分失败~',
		'result'      => null
	);
}

print_r( json_encode($data) );
exit();