<!-- Navigation -->
	
	<!-- Background Gradients-->
	<div  class="site-gradients">
		<div class="site-gradients-media">
			<figure>
				<img src="Another%20Yosemite%20short%20movie%20project%20%E2%80%93%20Modern_files/PcLGXNjMTdiFVKTrElCl__DSC2245.jpg" alt="PcLGXNjMTdiFVKTrElCl__DSC2245" srcset="https://themedemos.webmandesign.eu/modern/wp-content/uploads/sites/8/2014/11/PcLGXNjMTdiFVKTrElCl__DSC2245.jpg 1920w, https://themedemos.webmandesign.eu/modern/wp-content/uploads/sites/8/2014/11/PcLGXNjMTdiFVKTrElCl__DSC2245-420x280.jpg 420w, https://themedemos.webmandesign.eu/modern/wp-content/uploads/sites/8/2014/11/PcLGXNjMTdiFVKTrElCl__DSC2245-744x497.jpg 744w, https://themedemos.webmandesign.eu/modern/wp-content/uploads/sites/8/2014/11/PcLGXNjMTdiFVKTrElCl__DSC2245-1200x801.jpg 1200w" sizes="(max-width: 1617px) 100vw, 1617px" height="1080" width="1617">
			</figure>
		</div>
	</div>

	<header class="container">
		<div class="site-branding">
			<h1 class="site-title">
				<a href="/index/index">
					<span>Justice</span>
				</a>
			</h1>
			<h2 class="site-description">Welcome to Us !</h2>
		</div>
	</header>
	
	<!-- /////////////////////////////////////////Content -->
	<div id="page-content" class="single-page">
		<div class="container">
			<div class="row">
				<div id="main-content">
					<article>
						<img src="/images/banner1.jpg" />
						<div class="art-content">
							<h1>如何判断扫码的是微信还是支付宝？</h1>
							<div class="info">By <a href="#">夕夜</a> 7 25, 2017</div>
                            <p>主要通过 HTTP_USER_AGENT 来判断</p><p>以PHP代码举例</p><pre style="background-color:#2b2b2b;color:#aeb5bd;font-family:'宋体';font-size:9.6pt;"><span style="color:#5c7ab8;background-color:#232525;font-weight:bold;">public function </span><span style="color:#d9af6c;background-color:#232525;">actionTest</span><span style="background-color:#232525;">(){<br></span><span style="background-color:#232525;"> &nbsp; &nbsp;</span><span style="color:#9876aa;background-color:#232525;">$user_agent </span><span style="background-color:#232525;">= </span><span style="color:#9876aa;background-color:#232525;">$_SERVER</span><span style="background-color:#232525;">[</span><span style="color:#807d6e;background-color:#232525;font-weight:bold;">'HTTP_USER_AGENT'</span><span style="background-color:#232525;">]</span><span style="color:#5c7ab8;background-color:#232525;">;<br></span><span style="color:#5c7ab8;background-color:#232525;"> &nbsp; &nbsp;</span><span style="color:#5c7ab8;background-color:#232525;font-weight:bold;">echo </span><span style="color:#9876aa;background-color:#232525;">$user_agent</span><span style="color:#5c7ab8;background-color:#232525;">;<br></span><span style="background-color:#232525;">}</span></pre><p>获得结果:</p><p>微信：</p><p>Mozilla/5.0 (Linux; Android 6.0; HUAWEI MT7-TL10 Build/HuaweiMT7-TL10; wv)&nbsp;</p><p>AppleWebKit/537.36 (KHTML, like Gecko)&nbsp;</p><p>Version/4.0&nbsp;</p><p>Chrome/53.0.2785.49&nbsp;</p><p>Mobile MQQBrowser/6.2&nbsp;</p><p>TBS/043220&nbsp;</p><p>Safari/537.36&nbsp;</p><p>MicroMessenger/6.5.8.1060 &nbsp; --------------------------------&gt; 微信特征</p><p>NetType/WIFI&nbsp;</p><p>Language/zh_CN</p><p>支付宝：</p><p>Mozilla/5.0 (Linux; U; Android 6.0; zh-CN; HUAWEI MT7-TL10 Build/HuaweiMT7-TL10)&nbsp;</p><p>AppleWebKit/537.36 (KHTML, like Gecko)&nbsp;</p><p>Version/4.0&nbsp;</p><p>Chrome/40.0.2214.89&nbsp;</p><p>UCBrowser/11.5.0.939&nbsp;</p><p>UCBS/2.10.1.6 Mobile&nbsp;</p><p>Safari/537.36&nbsp;</p><p>Nebula AlipayDefined(nt:WIFI,ws:360|0|3.0)&nbsp;</p><p>AliApp(AP/10.0.15.051805)&nbsp;</p><p>AlipayClient/10.0.15.051805 &nbsp; &nbsp;----------------------------------&gt; 支付宝特征</p><p>Language/zh-Hans&nbsp;</p><p>useStatusBar/true</p><p style="margin-top: 0px; margin-bottom: 0px; color: rgb(17, 17, 17); font-family: &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, &quot;Noto Sans CJK SC&quot;, Sathu, EucrosiaUPC, sans-serif; font-size: 14px; white-space: normal;"><span style="font-family: &quot;font-size:14px;background-color:#FFFFFF;&quot;;">如果 UserAgent &nbsp;中有 MicroMessenger &nbsp;为微信</span></p><p style="margin-top: 0px; margin-bottom: 0px; color: rgb(17, 17, 17); font-family: &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, &quot;Noto Sans CJK SC&quot;, Sathu, EucrosiaUPC, sans-serif; font-size: 14px; white-space: normal;"><span style="font-family: &quot;font-size:14px;background-color:#FFFFFF;&quot;;">如果有 &nbsp;ApliPayClient &nbsp;则为支付宝</span></p><p style="margin-top: 0px; margin-bottom: 0px; color: rgb(17, 17, 17); font-family: &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, &quot;Microsoft YaHei UI&quot;, &quot;Microsoft YaHei&quot;, &quot;Noto Sans CJK SC&quot;, Sathu, EucrosiaUPC, sans-serif; font-size: 14px; white-space: normal;"><span style="font-family: &quot;font-size:14px;background-color:#FFFFFF;&quot;;">否则，不是这两家</span></p><p>不过QQ注意扫码也会有 MicroMessenger/6.5.8.1060&nbsp;</p><p><br></p>
						</div>
					</article>
					<div class="widget wid-related">
						<div class="heading"><h4>Related Post</h4></div>
						<div class="content">
							<div class="row">
								<div class="col-md-4">
									<div class="wrap-col">
										<a href="#"><img src="/images/7.jpg" /></a>
										<h4><a href="#">Vero eros et accumsan et iusto odio </a></h4>
									</div>
								</div>
								<div class="col-md-4">
									<div class="wrap-col">
										<a href="#"><img src="/images/8.jpg" /></a>
										<h4><a href="#">Vero eros et accumsan et iusto odio </a></h4>
									</div>
								</div>
								<div class="col-md-4">
									<div class="wrap-col">
										<a href="#"><img src="/images/6.jpg" /></a>
										<h4><a href="#">Vero eros et accumsan et iusto odio </a></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>