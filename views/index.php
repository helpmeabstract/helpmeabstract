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
								<li><a href="#form" class="button big icon fa-arrow-circle-right">Submit</a></li>
								<li><a href="/volunteer" class="button alt big icon fa-question-circle">Volunteer</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		<!-- Main -->
			<div id="banner-wrapper">
				<div  class="container box">

					<div class="row" id="about">
						<div class="4u">

							<!-- Sidebar -->
								<div id="sidebar">
									<section class="widget thumbnails">
										<h3>Volunteers</h3>
										<div class="grid">
											<div class="row no-collapse 50%">
                                                {% for volunteer in volunteers %}
                                                    {%include "/volunteer_block.php" %}
                                                {% endfor %}
											</div>
										</div>
									</section>
								</div>

						</div>
						<div class="8u important(collapse)" style="padding-bottom: 80px">

							<!-- Content -->
								<div id="content">
									<section class="last">
										<h2>So what's this all about?</h2>
										<p>
                                            There is no shortage of brilliant, talented developers in our industry,
                                            but making the jump from passionate developer to show stopping speaker
                                            is a big hurdle. We want to see new speakers at our conferences,
                                            and so this is our effort to make that a reality.
                                        </p>
                                        <p>
                                            We can't cure stage fright, or write your slides, but we can give you helpful,
                                            constructive feedback on your abstracts, before you submit.
                                        </p>
                                        <p>
                                            Submit a <a href="http://gist.github.com">gist</a> link in the form below, and
                                            we'll get it in front of some of the best speakers in the community.
                                        </p>
									</section>
								</div>
						</div>

<!--                        {%include "/tips.php"%}-->


                            {%include "/abstract_form.php"%}

                    </div>
				</div>
			</div>

		<!-- Footer -->
        {%include "/includes/footer.php"%}

	</body>
</html>