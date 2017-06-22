#!/bin/bash
# Version 0.3
apt-get update && apt-get -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" upgrade
