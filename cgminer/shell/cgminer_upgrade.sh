#!/bin/bash

PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin"

SERVICE_PATH="/var/www/zeusController"
RESTART_LOG="${SERVICE_PATH}/cgminer/log/restart.log"
CONFIG_DIR="${SERVICE_PATH}/cgminer/conf"
SERVICE_INIT="${SERVICE_PATH}/cgminer/shell/cgminer_init.sh"

cd ${SERVICE_PATH}

# upgrade controller
sudo git pull

sudo chmod -R www-data:www-data ${SERVICE_PATH}
sudo chmod a+x ${SERVICE_PATH}/cgminer/bin/cgminer

# restart all cgminer process
for DEV_PORT_PATH in `ls /dev/ttyUSB*`
do
    DEV_PORT=`basename ${DEV_PORT_PATH}`
    CONFIG_FILE="${SERVICE_PATH}/conf/cgminer_${DEV_PORT}.conf"
    if [ ! -f ${CONFIG_FILE} ]
    then
        continue
    fi

    echo "" >> ${RESTART_LOG}
    date >> ${RESTART_LOG}
    echo "restart cgminer on ${DEV_PORT}" >> ${RESTART_LOG}
    ${SERVICE_INIT} ${DEV_PORT} stop
    sleep 1
    sudo rm ${SERVICE_INIT}/cgminer/log/cgminer_${DEV_PORT}.log
    ${SERVICE_INIT} ${DEV_PORT} start
done

