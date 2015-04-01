{%include "/includes/header.php"%}

<body class="homepage">

{%include "/includes/nav.php"%}

<!-- Banner -->
<div id="banner-wrapper">
    <div id="banner" class="box container">
        <div class="row">
            <div class="12u">
                <div id="form" style="background:#ff4486; width:100%; padding-bottom:100px; padding-top:50px;  margin-top:20px">
                    <div class="8u -2u important(collapse)" style="background:#ff4486">
                        <!-- Content -->
                        <h2 style="color:white">Volunteering</h2>

                        {% if error %}
                            <h3><i class="fa fa-exclamation-triangle"></i>{{error}}</h3>
                        {% else %}
                        <div id="content" >
                            <p style="color:white; font-size: 20px">
                                Want to help review abstracts and empower the next generation of speakers? Fantastic!
                            </p>
                            <br>
                            <p style="color:white; font-size: 20px">
                                Enter your information in the form below. We'll email you a link to new abstracts as
                                they are submitted. Reply directly in the gist whenever it suits you. Simple!
                            </p>
                            <br>
                            <p style="color:white; font-size: 20px">
                                Thank you for volunteering, and for helping.
                            </p>

                            <br>
                            <hr>
                            <form action="/submitVolunteer" method="post">
                                <label for="name">Name</label>
                                <input type="text" name="name">
                                <label for="link">Email</label>
                                <input type="text" name="email">
                                <label for="link">Twitter username</label>
                                <input type="text" name="twitter">
                                <label for="link">Github username</label>
                                <input type="text" name="github">
                                <br>
                                <div class="row">
                                    <div class="4u -5u">
                                        <input type="submit" value="Submit" name="submit">
                                    </div>
                                </div>
                            </form>
                            </section>
                        </div>
                        {% endif %}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Footer -->
    {%include "/includes/footer.php"%}

</body>
</html>