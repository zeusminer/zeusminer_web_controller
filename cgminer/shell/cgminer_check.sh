#!/bin/bash

PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin"

if [ $# -ne 1 ]
then
    echo "Usage $0 port"
    exit 1
fi

DEV_PORT=$1
PROC_NUM=`ps -ef | grep -v grep | grep bin/cgminer | grep ${DEV_PORT} | wc -l`

if [ ${PROC_NUM} -eq 0 ]
then
	echo "not running"
	exit 1
fi

echo "running"
exit 0

