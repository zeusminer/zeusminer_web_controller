#!/bin/bash

PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin"

SERVICE_PATH="/var/www/zeusController/cgminer"
RESTART_LOG="${SERVICE_PATH}/log/restart.log"
CONFIG_DIR="${SERVICE_PATH}/conf"
SERVICE_INIT="${SERVICE_PATH}/shell/cgminer_init.sh"
cd ${SERVICE_PATH}

for DEV_PORT_PATH in `ls /dev/ttyUSB*`
do
    DEV_PORT=`basename ${DEV_PORT_PATH}`
    CONFIG_FILE="${SERVICE_PATH}/conf/cgminer_${DEV_PORT}.conf"
    if [ ! -f ${CONFIG_FILE} ]
    then
        continue
    fi
    PROC_NUM=`ps -ef | grep -v grep | grep bin/cgminer | grep ${DEV_PORT} | wc -l`
    if [ ${PROC_NUM} -eq 0 ]
    then
        echo "" >> ${RESTART_LOG}
        date >> ${RESTART_LOG}
        echo "cgminer on ${DEV_PORT} not running, trying to restart" >> ${RESTART_LOG}
        ${SERVICE_INIT} ${DEV_PORT} restart
    fi
done

