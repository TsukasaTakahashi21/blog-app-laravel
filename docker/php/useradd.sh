#!/bin/bash

USER_ID=${HOST_UID}
GROUP_ID=${HOST_GID}
WORKDIR=/var/www

echo "Starting with UID : $USER_ID, GID: $GROUP_ID"
useradd -u $USER_ID -o -m student
groupmod -g $GROUP_ID student
export HOME=/home/student

mkdir -p $WORKDIR && chown -R $USER_ID:$GROUP_ID $WORKDIR
