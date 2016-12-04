#!/bin/bash
# Version 0.1

#Do not touch this
KEY='INSERT_KEY_HERE';

#Replace yourpage.com with your Domain
RESP=$(curl -s -d "TOKEN=${KEY}" https://yourpage.com/API.php);

if [ "$RESP" == "Update" ]; then
  sudo ./Update.sh
  #Replace yourpage.com with your Domain
  curl -d "TOKEN=${KEY}&JOB_DONE=1" https://yourpage.com/API.php
fi
