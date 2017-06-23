#!/bin/bash
# Version 0.3

mkdir /home/firepatch
cd /home/firepatch
useradd firepatch -r -d /home/firepatch -s /bin/bash
#Replace yourpage.com with your Domain
wget https://yourpage.com/content/scripts/FirePatch.sh
wget https://yourpage.com/content/scripts/Update.sh
sed -i "s/KEY='INSERT_KEY_HERE'/KEY='${1}'/g" FirePatch.sh
chown -R firepatch:firepatch /home/firepatch/
chmod -R 700 /home/firepatch/
#Make sure that only Root can change the file and not the User itself
chown root:root /home/firepatch/Update.sh
chmod 755 /home/firepatch/Update.sh
crontab -u firepatch -l 2>/dev/null | { cat; echo "*/5 * * * *  /home/firepatch/FirePatch.sh > /dev/null 2>&1"; } | crontab -u firepatch -
cd

#Install dependencies
apt-get -y install curl sudo
#Configure sudo for Update.sh
echo "firepatch ALL=(root) NOPASSWD: /home/firepatch/Update.sh" >> /etc/sudoers
#Finished
rm Install.sh
