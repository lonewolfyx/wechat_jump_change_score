/*
 *! WeChat small program jump brush points - 2018-01-06 22:10:42
 * Copyright (c) 2017
 * Powered by MrWang
 */
var version = 6,
	score = 2018,
	AJAX_URL = "https://mp.weixin.qq.com/wxagame/";
	request_url = "https://www.sslcvm.com/wxagame_tyt/api.php";

var base_req = {
	'base_req': {
		'session_id': $("#session_id").val(),
		'fast': 1
	}
};

var headers = {
	'User-Agent': 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_2_1 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Mobile/15C153 MicroMessenger/6.6.1 NetType/WIFI Language/zh_CN',
    'Referer': 'https://servicewechat.com/wx7c8d593b2c3a7703/' + version + '/page-frame.html',
    'Content-Type': 'application/json',
    'Accept-Language': 'zh-cn',
    'Accept': '*/*'
}

var init = {
	base64_encode: function(e){
		if (!e) return "";
		e = e.toString();
		var t, n, i, o, r, a, s = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		for (i = e.length, n = 0, t = ""; i > n;) {
			if (o = 255 & e.charCodeAt(n++), n == i) {
				t += s.charAt(o >> 2),
				t += s.charAt((3 & o) << 4),
				t += "==";
				break
			}
			if (r = e.charCodeAt(n++), n == i) {
				t += s.charAt(o >> 2),
				t += s.charAt((3 & o) << 4 | (240 & r) >> 4),
				t += s.charAt((15 & r) << 2),
				t += "=";
				break
			}
			a = e.charCodeAt(n++),
			t += s.charAt(o >> 2),
			t += s.charAt((3 & o) << 4 | (240 & r) >> 4),
			t += s.charAt((15 & r) << 2 | (192 & a) >> 6),
			t += s.charAt(63 & a)
		}
		return t;
	},
	requestFriendsScore : function(){
		$.ajax({
			method        : "GET",
			type          : "GET",
			url           : request_url,
			timeout       : 15e3,
			dataType      : "json",
			contentType   : "application/javascript",
			data          : {
				session_id : this.base64_encode( $("#session_id").val() ),
				//session_id : $("#session_id").val(),
				score      : $("#score").val()
			}
		}).done(function(a){
			
			if( a.error_code !== 10001 ){
				var _loc1_ = a.result;
				$(".wxagame_tyt").html("<figure class=\"highlight wxscore_success\">\
				<div class=\"tip\">刷分成功</div>\
				<details open >\
					<summary class=\"text-dark mb-3\">success</summary>\
					<ul>\
						<li>上报用户: " + _loc1_.name + "</li>\
						<li>上报得分: " + _loc1_.score + "</li>\
						<li>周最好成绩: " + _loc1_.week_best_score + "</li>\
					</ul>\
				</details>\
			</figure>");
			} else {
				$(".wxagame_tyt").html("<figure class=\"highlight wxscore_error\">\
				<div class=\"tip\">上报失效</div>\
				<details open >\
					<summary class=\"text-dark mb-3\">Error</summary>\
				<h3 style=\"padding-bottom:0.3em;font-size:1.5em;border-bottom: 1px solid #eaecef;\">次数可能过多或过于频繁， 也有可能已被封号。</h3>\
				<p>Sorry, the number of times may be too much or too frequent, and it may have been sealed!</p>\
				</details>\
			</figure>");
			}
			
			
		}).fail(function(a, b){
			console.log(a);
		});
	},
	encrypt : function(text, originKey){
		var originKey = originKey.slice(0, 16),
			key = CryptoJS.enc.Utf8.parse(originKey),
			iv = CryptoJS.enc.Utf8.parse(originKey),
			msg = JSON.stringify(text);
		
		var ciphertext = CryptoJS.AES.encrypt(msg, key, {
				iv: iv,
				mode: CryptoJS.mode.CBC,
				padding: CryptoJS.pad.Pkcs7
			});
		return ciphertext.toString()
	}
}

function go(){
	init.requestFriendsScore()
}