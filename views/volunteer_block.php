<div class="2u">
    <div class="image fit">
        <img src="{{volunteer.profile_image}}" alt=""/>
        <h3>
            {{volunteer.fullname}}
            {% if volunteer.twitter_username %}
            <a href="http://twitter.com/{{ volunteer.twitter_username }}">
                <i class="fa fa-twitter"></i>
            </a>
            {% endif %}
            {% if volunteer.github_username %}
                <a href="http://github.com/{{ volunteer.github_username }}">
                    <i class="fa fa-github"></i>
                </a>
            {% endif %}
        </h3>
    </div>
</div>
