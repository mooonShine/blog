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
							<h1>PHP 常用函数集锦PHP 常用函数集锦</h1>
                        <div class="info">By <a href="#">夕夜</a> 8 22, 2017</div>
                            <pre style="background-color:#2b2b2b;color:#aeb5bd;font-family:'宋体';font-size:9.6pt;"><span style="color:#7a7a7a;background-color:#232525;font-style:italic;">/**<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * 方法描述：字符截取 支持UTF8/GBK<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * </span><span style="color:#7a7a7a;background-color:#232525;font-weight:bold;font-style:italic;">@param </span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;">$string<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * </span><span style="color:#7a7a7a;background-color:#232525;font-weight:bold;font-style:italic;">@param </span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;">int $length<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * </span><span style="color:#7a7a7a;background-color:#232525;font-weight:bold;font-style:italic;">@param </span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;">string $dot<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * </span><span style="color:#7a7a7a;background-color:#232525;font-weight:bold;font-style:italic;">@param </span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;">string $charset<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * </span><span style="color:#7a7a7a;background-color:#232525;font-weight:bold;font-style:italic;">@return </span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;">mixed|string<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> * 注意：<br></span><span style="color:#7a7a7a;background-color:#232525;font-style:italic;"> */<br></span><span style="color:#5c7ab8;background-color:#232525;font-weight:bold;">public static function </span><span style="color:#d9af6c;background-color:#232525;">str_cut</span><span style="background-color:#232525;">(</span><span style="color:#9876aa;background-color:#232525;">$string</span><span style="color:#5c7ab8;background-color:#232525;">, </span><span style="color:#9876aa;background-color:#232525;">$length</span><span style="background-color:#232525;">=</span><span style="color:#267dff;background-color:#232525;">90</span><span style="color:#5c7ab8;background-color:#232525;">, </span><span style="color:#9876aa;background-color:#232525;">$dot </span><span style="background-color:#232525;">= </span><span style="color:#807d6e;background-color:#232525;font-weight:bold;">'...'</span><span style="color:#5c7ab8;background-color:#232525;">, </span><span style="color:#9876aa;background-color:#232525;">$charset </span><span style="background-color:#232525;">= </span><span style="color:#807d6e;background-color:#232525;font-weight:bold;">'UTF-8'</span><span style="background-color:#232525;">)<br></span><span style="background-color:#232525;">{<br></span><span style="background-color:#232525;"> &nbsp; &nbsp;</span><span style="color:#5c7ab8;background-color:#232525;font-weight:bold;">if</span><span style="background-color:#232525;">(</span><span style="color:#5c7ab8;background-color:#232525;font-weight:bold;">empty</span><span style="background-color:#232525;">(</span><span style="color:#9876aa;background-color:#232525;">$length</span><span style="background-color:#232525;">)){<br></span><span style="background-color:#232525;"> &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="color:#9876aa;background-color:#232525;">$length </span><span style="background-color:#232525;">= </span><span style="color:#267dff;background-color:#232525;">120</span><span style="color:#5c7ab8;background-color:#232525;">;<br></span><span style="color:#5c7ab8;background-color:#232525;"> &nbsp; &nbsp;</span><span style="background-color:#232525;">}<br></span><span style="background-color:#232525;"> &nbsp; &nbsp;</span><span style="color:#9876aa;background-color:#232525;">$str </span><span style="background-color:#232525;">= </span><span style="color:#a9b7c6;background-color:#232525;">strip_tags</span><span style="background-color:#232525;">(</span><span style="color:#9876aa;background-color:#232525;">$string</span><span style="background-color:#232525;">)</span><span style="color:#5c7ab8;background-color:#232525;">;<br></span><span style="color:#5c7ab8;background-color:#232525;"> &nbsp; &nbsp;</span><span style="color:#5c7ab8;background-color:#232525;font-weight:bold;">return </span><span style="color:#a9b7c6;background-color:#232525;">mb_substr</span><span style="background-color:#232525;">(</span><span style="color:#9876aa;background-color:#232525;">$str</span><span style="color:#5c7ab8;background-color:#232525;">,</span><span style="color:#267dff;background-color:#232525;">0</span><span style="color:#5c7ab8;background-color:#232525;">,</span><span style="color:#9876aa;background-color:#232525;">$length</span><span style="color:#5c7ab8;background-color:#232525;">,</span><span style="color:#9876aa;background-color:#232525;">$charset</span><span style="background-color:#232525;">).</span><span style="color:#9876aa;background-color:#232525;">$dot</span><span style="color:#5c7ab8;background-color:#232525;">;<br></span><span style="background-color:#232525;">}</span></pre><p><br></p>
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