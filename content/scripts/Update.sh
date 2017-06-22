#!/bin/bash
# Version 0.2
apt-get update && apt-get -y -o Dpkg::Options::="--force-confold" upgrade
