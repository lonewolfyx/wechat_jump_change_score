<?php
error_reporting(0);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="王先生">
<title>微信跳一跳刷分</title>
<link href="https://cdn.bootcss.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<script src="aes.js"></script>
<script src="app.js"></script>
<style>
a{color:#0366d6;}
a:hover{color:#212529;text-decoration:none}
body{padding-top:20px;padding-bottom:50px;}
.footer{text-align:center;padding-top:20px;padding-bottom:40px;margin-top:20px;border-top:1px solid #eee;}
.container{background:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05);}
.jumbotron{text-align:center;background-color:transparent;padding:1rem 2rem}
.highlight{position:relative;padding:1rem;margin-top:1rem;margin-bottom:1rem;background-color:#f7f7f9;-ms-overflow-style:-ms-autohiding-scrollbar;margin-top:0;margin-right:0;margin-left:0;padding-top:2.5rem;padding-bottom:0.5rem;}
.tip{position:absolute;top:0;left:45%;background:#03A9F4;color:#fff;padding:5px;font-size:12px;}
.wxscore_success .tip{background:#03A9F4;}
.wxscore_error .tip{background:#f00;}
@media screen and (min-width:768px){
	.footer{padding-right:0;padding-left:0;}
}
</style>
</head>
<body background="bj.png">
<div class="container">
	<main>
		<div class="jumbotron">
			<h1>微信跳一跳刷分</h1>
		</div>
		<figure class="highlight">
			<div class="tip">友情提示</div>
			<details open>
				<summary class="text-dark mb-3">如何抓包 拿到 session_id</summary>
				<ul>
					<li>下载最新 <a href="https://www.charlesproxy.com/download/" rel="nofollow">charlesproxy</a></li>
					<li>启动 charlesproxy</li>
					<li>配置代理： 设置 &gt; 无线局域网 &gt; 配置代理 &gt; 手动 &gt; IP：电脑 ip，端口： 8888</li>
					<li>导入 https 证书： 浏览器访问 <a href="http://chls.pro/ssl" rel="nofollow">http://chls.pro/ssl</a>  下载安装证书</li>
					<li>启动跳一跳小程序</li>
					<li>去 charlesproxy 里查看抓到的请求,  <a href="https://mp.weixin.qq.com/wxagame/wxagame_init" rel="nofollow">https://mp.weixin.qq.com/wxagame/wxagame_init</a>  路径的请求，请求体里就包含 session_id</li>
				</ul>
				<p>或者手机下载 surge</p>
				<h3 style="padding-bottom:0.3em;font-size:1.5em;border-bottom: 1px solid #eaecef;">session_id 和微信账号相关联， session_id 公示或提供给他人 都是有账号安全风险的</h3>
				<p><a href="https://www.v2ex.com/t/419056" rel="nofollow">https://www.v2ex.com/t/419056</a></p>
				<h3 style="padding-bottom:0.3em;font-size:1.5em;border-bottom: 1px solid #eaecef;">次数不要过于频繁， 反正封号不要怪我哦。</h3>
				<p>Just for fun！</p>
			</details>
		</figure>
		<div class="wxagame_tyt"></div>
		<form>
			<div class="form-group row">
				<label class="col-sm-2 control-label">Session Id值</label>
				<div class="col-sm-9">
					<textarea class="form-control session_id" id="session_id" style="height:10em" placeholder="用户您自己的微信session id值"></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 control-label">挑战得分</label>
				<div class="col-sm-9">
					<input type="text" class="form-control score" id="score" onkeyup="value=value.replace(/[^\d]/g,'') " ng-pattern="/[^a-zA-Z]/" placeholder="上报最多请输入999" >
				</div>
			</div>
			<div class="form-group row">
				<div class="offset-sm-2 col-sm-10">
					<button type="button" class="btn btn-primary" onclick="go();">提交作弊吧</button>
				</div>
			</div>
		</form>
	</main>
	<footer class="footer">
		<p>&copy; 2017 <a href="https://www.sslcvm.com/" target="_blank" >王先生的网站</a></p>
	</footer>
</div>
</body>
</html>