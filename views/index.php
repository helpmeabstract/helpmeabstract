{%include "/includes/header.php"%}

<body class="homepage">
        {%include "/includes/nav.php"%}

		<!-- Banner -->
			<div id="banner-wrapper">
				<div id="banner" class="box container">
					<div class="row">
						<div class="7u">
							<h2>So you want to be a speaker?</h2>
							<p>Get feedback from veteran speakers before you submit</p>
						</div>
						<div class="5u">
							<ul>
								<li><a href="#" class="button big icon fa-arrow-circle-right">Submit</a></li>
								<li><a href="#" class="button alt big icon fa-question-circle">Volunteer</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>


		<!-- Main -->
			<div id="main-wrapper">
				<div class="container">

					<div class="row">
						<div class="4u">

							<!-- Sidebar -->
								<div id="sidebar">
									<section class="widget thumbnails">
										<h3>Volunteers</h3>
										<div class="grid">
											<div class="row no-collapse 50%">
												<div class="6u"><a href="#" class="image fit"><img src="images/pic04.jpg" alt="" /></a></div>
												<div class="6u"><a href="#" class="image fit"><img src="images/pic05.jpg" alt="" /></a></div>
											</div>
											<div class="row no-collapse 50%">
												<div class="6u"><a href="#" class="image fit"><img src="images/pic06.jpg" alt="" /></a></div>
												<div class="6u"><a href="#" class="image fit"><img src="images/pic07.jpg" alt="" /></a></div>
											</div>
										</div>
										<a href="/volunteers" class="button icon fa-plus-circle">More</a>
									</section>
								</div>

						</div>
						<div class="8u important(collapse)">

							<!-- Content -->
								<div id="content">
									<section class="last">
										<h2>So what's this all about?</h2>
										<p>This is <strong>Verti</strong>, a free and fully responsive HTML5 site template by <a href="http://html5up.net">HTML5 UP</a>.
										Verti is released under the <a href="http://html5up.net/license">Creative Commons Attribution license</a>, so feel free to use it for any personal or commercial project you might have going on (just don't forget to credit us for the design!)</p>
										<p>Phasellus quam turpis, feugiat sit amet ornare in, hendrerit in lectus. Praesent semper bibendum ipsum, et tristique augue fringilla eu. Vivamus id risus vel dolor auctor euismod quis eget mi. Etiam eu ante risus. Aliquam erat volutpat. Aliquam luctus mattis lectus sit amet phasellus quam turpis.</p>
									</section>
								</div>

						</div>
                        <div id="form" style="background:#ff4486; width:100%; padding-bottom:100px;  margin-top:20px">
                            <div class="8u -2u important(collapse)" style="background:#ff4486">
                                <!-- Content -->
                                <div id="content">
                                        <h2 style="color:white">Submit Abstract</h2>
                                        <form action="/submitAbstract" method="post">
                                            <label for="name">Name</label>
                                            <input type="text" name="name">
                                            <label for="link">Email</label>
                                            <input type="text" name="email">
                                            <label for="link">Gist Link</label>
                                            <input type="text" name="link">
                                            <br>
                                           <div class="row">
                                               <div class="4u -5u">
                                               <input type="button" value="Submit" name="submit">
                                                   </div>
                                           </div>
                                        </form>
                                    </section>
                            </div>
                        </div>
					</div>
				</div>
			</div>

		<!-- Footer -->
        {%include "/includes/footer.php"%}

	</body>
</html>