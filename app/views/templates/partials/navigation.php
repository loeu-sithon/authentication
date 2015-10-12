{% if auth %}
	Hello, {{auth.getFullNameOrUsername}} !
	<img src="{{ auth.getAvatarUrl({size:30})}}" alt="Your avatar">
{% endif %}

<ul>
	<li><a href="{{ urlFor('home') }}">Home</a></li>
	{% if auth %}
		<li><a href="{{ urlFor('logout') }}">Logout</a></li>
		<li><a href="{{ urlFor('user.profile',{username: auth.username }) }}">Your Profile</a></li>
		
	{% else %}
	<li><a href="{{ urlFor('register') }}">Register</a></li>
	<li><a href="{{ urlFor('login') }}">Login</a></li>
	{% endif %}
	<li><a href="{{ urlFor('user.all') }}">All users</a></li>
</ul>