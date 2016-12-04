# FirePatch

This is a simple Bootstrap Based Panel, to Update your Debian/Ubuntu Servers on the Go without SSH access

Webserver Requirements:

- PHP 7.0+
- MySQL or MariaDB

Todo:

- Give Feedback if Updates need to be installed

Quick Setup:

- Create a Database + User
- Import the SQL file from /Content/firepatch.sql into your Database
- Update Content/config.php with your Database details, also Update the Script Path
- Replace yourpage.com in Scripts/FirePatch.sh and Scripts/install.sh with your Domain
- Please make sure that you add a .htaccess to limit the Access, since this Software dosent offer a login yet but soonTM
- If you go to https://yourdomain.com you should be able to Update your Servers on the Go! (obviously yourdomain.com is an example)
