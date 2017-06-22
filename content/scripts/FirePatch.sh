#!/bin/bash
# Version 0.2

#Do not touch this, it will be replaced automatically
KEY='INSERT_KEY_HERE';

#Replace yourpage.com with your Domain
RESP=$(curl -s -d "TOKEN=${KEY}" https://yourpage.com/API.php);

#If the API responds with Update
if [ "$RESP" == "Update" ]; then
  sudo ./Update.sh
  if [ $? -eq 0 ]; then #Check if its already running, to prevent that we post back that its successfull but its not
  #Replace yourpage.com with your Domain
  curl -d "TOKEN=${KEY}&JOB_DONE=1" https://yourpage.com/API.php
  #Posting back that it was successfull
  else
  #Replace yourpage.com with your Domain
  curl -d "TOKEN=${KEY}&JOB_DONE=4" https://yourpage.com/API.php
  #Posting back that we had issues, the Job could be still Running and Take longer as expected or could stuck
  fi
fi
