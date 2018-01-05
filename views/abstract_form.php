<div id="form"
     style="background:#ff4486; width: 97%; padding-bottom:100px;  margin-top:20px;margin-left: 40px;border-radius: 10px;">
    <div class="8u -2u important(collapse)" style="background:#ff4486">
        <!-- Content -->
        <div id="content">
            {% if error %}
            <h3><i class="fa fa-exclamation-triangle"></i>{{error}}</h3>
            {% endif %}
            <h2 style="color:white">Submit Abstract</h2>
            <blockquote style="color:white">
                Please submit your abstracts in <strong>Markdown</strong> format or ensure that lines are less than 80 chars long.
                If you wish to receive emails when your gists are commented on, consider signing up for
                <a href="https://giscus.co/" target="_blank" style="color: white">Giscus</a>.
            </blockquote>

            <form action="/submitAbstract" method="post">
                <label for="name">Name</label>
                <input type="text" name="name">
                <label for="link">Email</label>
                <input type="text" name="email">
                <label for="link">Gist Link</label>
                <input type="text" name="link">
                <label for="max_chars">Max characters / length allowed for your abstract by the event organisers</label>
                <input type="text" name="max_chars" maxlength="10" size="2">

                <br>
                <br>
                <div class="row">
                    <div class="4u -5u">
                        <input type="submit" value="Submit" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
