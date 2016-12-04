#!/bin/bash
# Version 0.1

mkdir /home/firepatch
cd /home/firepatch
useradd firepatch -r -d /home/firepatch -s /bin/bash
#Replace yourpage.com with your Domain
wget https://yourpage.com/Script/FirePatch.sh
wget https://yourpage.com/Script/Update.sh
sed -i "s/KEY='INSERT_KEY_HERE'/KEY='${1}'/g" FirePatch.sh
chown -R firepatch:firepatch /home/firepatch/
chmod -R 700 /home/firepatch/
crontab -u firepatch -l 2>/dev/null | { cat; echo "*/1 * * * *  /home/firepatch/FirePatch.sh > /dev/null 2>&1"; } | crontab -u firepatch -
cd

#Install dependencies
apt-get -y install curl
apt-get -y install sudo
#Configure sudo for Update.sh
echo "firepatch ALL=(root) NOPASSWD: /home/firepatch/Update.sh" >> /etc/sudoers
#Finished
rm install.sh
