# FirePatch

This is a simple Bootstrap based panel, to update your Debian/Ubuntu servers on the go without SSH access.

![alt tag](http://i.imgur.com/ldYircJ.png)

![alt tag](http://i.imgur.com/m21pCeM.png)

FirePatch is licensed under a
Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
You should have received a copy of the license along with this
work. If not, see https://creativecommons.org/licenses/by-nc-sa/4.0/

FirePatch uses Lake, Lake is licensed under MIT License.
You should have received a copy of the license along with this
work. If not, see https://opensource.org/licenses/MIT

Webserver Requirements:

- PHP 7.0+
- MySQL or MariaDB

Todo:

- Give Feedback if Updates need to be installed

Quick Setup:

- Create a Database + User
- Import the SQL file from /content/sql/firepatch.sql into your Database
- Rename content/config.sample.php to config.php
- Update content/config.php with your Database details, also Update the Script Path
- Rename content/scripts/Install.sample.sh to Install.sh and FirePatch.sample.sh to FirePatch.sh
- Replace yourpage.com in content/scripts/FirePatch.sh and content/scripts/Install.sh with your Domain
- Please make sure that you add a .htaccess to limit the Access, since this Software dosent offer a login yet but soonTM
- Make also sure that you are using SSL, otherwise the Token would be not transmitted encrypted
- If you go to https://yourdomain.com you should be able to Update your Servers on the Go! (obviously yourdomain.com is an example)
