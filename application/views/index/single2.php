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
                        <h1>用户管理命令详解</h1>
							<div class="info">By <a href="#">夕夜</a>12 7, 2017</div>
                            <p>useradd -u 1000 user1</p><p>userdd -g hellosa user2</p><p>-u UID</p><p>-g GID 基本组</p><p>-G GID 附加组</p><p>-c 住宿</p><p>-d /path/to/directory &nbsp;指定家目录</p><p>-s 指定shell的路径</p><p>-M 不指定家目录 （没有环境变量）</p><p>/etc/shells 指定当期系统可用的安全shell</p><p>环境变了</p><p>PATH HISTSIZE SHELL(当前用户的默认shell）</p><p>/etc/login.defs 配置文件</p><p><br></p><p>删除用户 没有默认选项家目录不会被删除</p><p>userdel [opetion] USERNAME</p><p>userdel -r 同时删除用户家目录</p><p>id 产科当前用户的 id 组 id 注释</p><p>id -u user</p><p>id &nbsp;-g user</p><p><br></p><p>finger 查看用户账号相关属性信息</p><p><br></p><p>修改用户账号属性信息</p><p>usermod &nbsp;-u -g &nbsp;-G &nbsp;(-a -G)追加附加组而不是覆盖</p><p>-d -m</p><p>-l (修改登陆名）</p><p>-L（锁定账号）</p><p>-U（解锁账号）</p><p><br></p><p>密码管理</p><p>passwd [username]</p><p>-d 删除用户密码</p><p>echo "redhat" | passwd --stdin user3</p><p>pwck :检查用户账号完整性</p><p><br></p><p>创建组 groupadd -</p><p>-g 指定gid</p><p>-r 添加一个系统账号</p><p>groupmod&nbsp;</p><p>-g</p><p>-n</p><p>groupdel</p><p><br></p><p><br></p><p><br></p>
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