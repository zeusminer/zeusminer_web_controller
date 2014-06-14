#!/bin/bash

if [ $# -eq 0 ]
then
    echo "Usage $0 port [last-line]"
    exit 1
fi

DEV_PORT=$1
LAST_LINE=$2

cd `dirname $0`
cd ..

LOG_FILE="log/cgminer_${DEV_PORT}.log"

if [ ! -f ${LOG_FILE} ]
then
    echo 0
    exit 1
fi

CURRENT_LINE_NUM=`wc -l ${LOG_FILE} | head -n 1 | awk '{ print $1 }'`
echo ${CURRENT_LINE_NUM}

if [ -z "${LAST_LINE}" ] || [ ${LAST_LINE} -eq 0 ]
then
	tail -n 10 ${LOG_FILE}
else
	if [ ${LAST_LINE} -gt ${CURRENT_LINE_NUM} ]
	then
        tail -n 10 ${LOG_FILE}
	elif [ ${CURRENT_LINE_NUM} -gt ${LAST_LINE} ]
	then
		NEW_LINE_NUM=$(( ${CURRENT_LINE_NUM} - ${LAST_LINE} ))
		tail -n ${NEW_LINE_NUM} ${LOG_FILE}
	fi
fi

