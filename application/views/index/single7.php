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
							<h1>swoole基础-IO模型</h1>
							<div class="info">By <a href="#">夕夜</a> 10 28, 2017 </div>
                            <p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">IO即Input/Output,输入和输出的意思。在计算机的世界里，涉及到数据交换的地方，比如磁盘、网络等，就需要IO接口。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">通常，IO是相对的。比如说你打开浏览器，通过网络IO获取我们网站的网页，浏览器首先会往服务器发送请求，这是一个Output操作，随后服务器给浏览器返回信息，这就是一个Input操作。以上都是基于浏览器而言。但是，有些操作就比较特殊。比如程序在运行时，数据被加载在内存中，通过程序往磁盘写数据，对内存而言，这就是单方面的的Output。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">IO模型通常有很多种，我们简单介绍下同步IO和异步IO。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">实际上我们刚刚介绍的浏览器请求服务器的过程正是同步IO的例子。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">那我们再比如，假设我们要通过程序往磁盘写大量的数据，如果没有磁盘IO操作，php程序在内存中执行的速度是非常快的，但是磁盘写数据的过程相对而言就是漫长的，CPU就需要等待磁盘IO操作之后才能继续执行其他代码，像上面这两种情况，我们都称之为同步IO。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">php本身是单线程的，当php进程被挂起的时候，像上面的读取磁盘数据，往磁盘写数据，在IO操作之前php代码就没办法继续执行了。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">因为IO操作阻塞了当前线程，如果某用户也想从磁盘上读取或者写数据，就需要等待。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">有些人要反驳了，这不对呀，我经历不是这样的，很多人可以同时访问我的网站，这没问题的。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">这个没必要纠结，php本身是单进程单线程的，用户可以同时访问你的网站实际上是web服务器的功劳。这就是我们之前讨论过的，如何解决多任务的问题。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">web服务器的进程模型暂时不多讨论，免得懵。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">如果不考虑web服务器，是不是当前进程一旦阻塞，其他人访问php都会被阻塞啦？答案是肯定的。要解决这个问题，有回到我们一直强调的多进程或者多线程。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">但是，如果为了解决并发问题，系统开启了大量的进程，就像我们之前说的，操作系统在进程或者线程间切换同样会造成CPU大量的开销。有没有更好的解决方案呢？</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">答案就就是异步IO。我们再来强调一遍异步IO是要解决什么问题的：同一线程内，执行一些耗时的任务时，其他代码是不能继续执行的，要等待该任务操作完之后才可以。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">异步IO是什么样的呢？当程序需要执行一个非常耗时的IO操作的时候，它只发出IO指令，不需要等待IO的结果，然后可以继续执行其他的代码了。当IO返回结果时，再通知CPU去处理，这就是异步IO。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">总结：同步IO模型下，主线程只能被挂起等待，但是在异步IO模型中，主线程发起IO指令后，可以继续执行其他指令，没有被挂起，也没有切换线程的操作。由此看来，使用异步IO明显可以提高了系统性能。</p><p style="margin-top: 0.8em; margin-bottom: 0.8em; line-height: 1.8; color: rgb(51, 51, 51); font-family: Arial, &quot;Hiragino Sans GB&quot;, 冬青黑, &quot;Microsoft YaHei&quot;, 微软雅黑, SimSun, 宋体, Helvetica, Tahoma, &quot;Arial sans-serif&quot;; font-size: 14px; white-space: normal;">为了基础起见，本文也借鉴了一些网络资源。其实IO模型远不止我们介绍的这两种，有兴趣的可以借助google更深层次的了解一下，有问题下方留言，我们共同交流。</p><p><br></p>
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