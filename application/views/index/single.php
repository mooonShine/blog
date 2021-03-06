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
							<h1>swoole基础-TCP/IP和UDP</h1>
							<div class="info">By <a href="#">夕夜</a> 2 21, 2018</div>
                            <p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">平时我们打开一个浏览器，然后输入网址后回车，即展现了一个网页的内容。这是一个非常简单的操作。我们来简单的概括下背后的逻辑。</p><ol style="color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;"><li>浏览器通过TCP/IP协议建立到服务器的TCP连接</li><li>客户端向服务器发送HTTP协议请求包，请求服务器里的资源文档</li><li>服务器向客户端发送HTTP协议应答包，如果请求的资源包含有动态语言的内容，那么服务器会调用动态语言的解释引擎负责处理“动态内容”，并将处理得到的数据返回给客户端</li><li>客户端与服务器断开，由客户端解释HTML文档，在客户端屏幕上渲染图形结果</li></ol><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">表面上看这就是两台电脑之间进行的一种通信。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">更确切的说，是两台计算机上两个进程之间的通信。你打开浏览器相当于启动了一个浏览器进程，而服务端事先也启动了某个进程，在某个端口监听，时刻等待客户端的连接。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">那么问题来了，为什么客户端可以请求到服务器呢？服务器上跑那么多服务，又是怎么知道客户端想要什么呢？</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">其实答案很简单，因为有网络。计算机为了联网，就必须遵循通信协议。早期的互联网有很多协议，但是最重要的就非TCP协议和IP协议莫属了。所以，我们把互联网的协议简称为TCP/IP协议。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">想必大家都有过这样的经历，客户端通过telnet连接服务器的时候，往往都需要一个ip地址和一个端口。如果客户端跟服务器之间有数据的交互，其过程大致是这样的：</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">IP协议负责把你本机的数据发送到服务端，数据被分割成一块一块的。然后通过IP包发送出去。IP包的特点是按块发送，但不保证能到达，也不保证数据块依次到达。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">如果是这样进行数据传输，服务器根本不能保证接收到的数据的完整性和顺序性，这样是不是就会有很大的问题呢？</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">于是乎，TCP协议应运而生，它是建立在IP协议之上，专门负责建立可靠连接，并保证数据包顺序到达。TCP协议会通过握手建立连接，然后，对每个IP包编号，确保对方顺序收到，如果出现丢包，则重新发送。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">这个时候再说TCP协议是一种面向连接、可靠的、基于IP之上的传出层协议就不难理解了吧。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">TCP协议还有一个更重要的特点，它是基于数据流的。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">什么意思呢？这就好比客户端和服务端要进行数据交互，中间有一个管子连接着，这个时候交互数据就好比管子中的水，当数据在传输（水在流动）的过程中，服务端是无法知道哪段数据是我们想要的完整数据。怎么解决这一问题呢？这个时候就需要双方约定一个协议来解决了。再往后说就说到应用层协议了，比如http协议，我们姑且不谈。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">TCP懂了，UDP自然就不难理解了。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">相对于TCP,使用UDP协议进行通信的最大区别就是，UDP不需要建立连接，给他一个ip和端口，就可以直接发送数据包了。但是，能不能成功到达就不知道了。虽然UDP传输不可靠，但是速度快。对于一些对数据要求不高的场景，使用UDP通信无疑是不错的选择。</p><p><br></p>

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