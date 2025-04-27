<h5>Steps to run the project</h5>
<ol>
	<li>Create a copy of <blockquote>.env.example</blockquote> file and rename it to <blockquote>.env</blockquote> file. This file is kept at the project root</li>
	<li>Create a local empty database and configure connection settings in <code>.env</code> File</li>
	<li>Install dependencies using Composer <code>composer install</code></li>
	<li>Run Migrations <code>php artisan migrate</code></li>
	<li>Run Seeders <code>php artisan db:seed</code></li>
	<li>Add Cron Entry for Scheduler <code>* * * * * cd /var/www/html/iot_modules && php artisan schedule:run >> /dev/null 2>&1</code> <br>Adjust path for actual project path. For linux, the command to edit cron will be <code>crontab -e</code>
	<br>Or simply run <code>php artisan schedule:work</code> for local envionments.</li>
	<li>To Run the project use <code>php artisan serve</code> <br>Or if you're using vhosts, configure it's document root to <code>public</code> folder of project</li>
</ol>