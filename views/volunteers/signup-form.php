{%include "/volunteers/includes/header.php"%}
<body class="left-sidebar">

<!-- Header -->
{%include "/volunteers/includes/nav.php"%}


<!-- Main -->
<article id="main">
    <header class="special container">
        <span class="icon fa-laptop"></span>
        <h2>Complete Sign Up</h2>
        <br>
        {%if error == true%}
            <span>Email is required</span>
        {%endif%}
        <form action="/completeSignup" method="post">
            <div class="row 50%">
                <div class="-3u 6u 12u(3)">
                    <input type="text" name="name" placeholder="Name" value="{{name}}" />
                </div>
            </div>
            <div class="row 50%">
                <div class="-3u 6u 12u(3)">
                    <input type="text" name="email" placeholder="Email" value="{{email}}"/>
                    <input type="hidden" name="avatar" value="{{avatar}}"/>
                    <input type="hidden" name="gh_id" value="{{gh_id}}"/>
                    <input type="hidden" name="gh_url" value="{{gh_url}}"/>
                    <input type="hidden" name="gh_un" value="{{gh_un}}"/>
                </div>
            </div>
            <div class="row">
                <div class="12u">
                    <ul class="buttons">
                        <li><input type="submit" class="special" value="Let's Go!" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </header>
</article>

<!-- Footer -->
{%include "//volunteers/includes/footer.php"%}
</body>
</html>