<div id="form" style="background:#ff4486; width: 97%; padding-bottom:100px;  margin-top:20px;margin-left: 40px;border-radius: 10px;">
    <div class="8u -2u important(collapse)" style="background:#ff4486">
        <!-- Content -->
        <div id="content">
            {% if error %}
            <h3><i class="fa fa-exclamation-triangle"></i>{{error}}</h3>
            {% endif %}
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
                        <input type="submit" value="Submit" name="submit">
                    </div>
                </div>
            </form>
            <small>Please submit your abstracts in Markdown format or ensure that lines are less than 80 chars long</small>
        </div>
    </div>