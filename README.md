<p>
I have placed <code>schedules.json</code> file inside storage folder with json data from example 
Then I have created a command which is getting file name as an argument and then parses it and stores inside database
Also I have created a controller action which is displaying result as described in the task description
</p>

<h3>Steps to test the implementation</h3>

<ul>
<li>Run artisan command to insert slots: <code>php artisan time_slots:create --fileName=schedules.json</code></li>
<li>make a GET request to the route <code>/api/time_slots</code> to see generated slots</li>
</ul>
