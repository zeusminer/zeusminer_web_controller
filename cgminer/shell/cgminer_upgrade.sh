#!/bin/bash

PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin"

SERVICE_PATH="/var/www/zeusController"
RESTART_LOG="${SERVICE_PATH}/cgminer/log/restart.log"
CONFIG_DIR="${SERVICE_PATH}/cgminer/conf"
SERVICE_INIT="${SERVICE_PATH}/cgminer/shell/cgminer_init.sh"

# sleep a random time, prevent all miner restart at the same time.
RANDOM_SEC=`head -n 100 /dev/urandom | cksum | awk '{ print $1 % 3600 }'`
sleep $RANDOM_SEC

# upgrade controller
cd ${SERVICE_PATH}
sudo git pull

sudo chown -R www-data:www-data ${SERVICE_PATH}
sudo chmod 666 ${SERVICE_PATH}/cgminer/log/*
sudo chmod a+x ${SERVICE_PATH}/cgminer/bin/cgminer
sudo chmod a+x ${SERVICE_PATH}/cgminer/shell/*

# restart all cgminer process
for DEV_PORT_PATH in `ls /dev/ttyUSB*`
do
    DEV_PORT=`basename ${DEV_PORT_PATH}`
    CONFIG_FILE="${SERVICE_PATH}/cgminer/conf/cgminer_${DEV_PORT}.conf"
    if [ ! -f ${CONFIG_FILE} ]
    then
        continue
    fi

    sudo echo "" >> ${RESTART_LOG}
    sudo date >> ${RESTART_LOG}
    sudo echo "restart cgminer on ${DEV_PORT}" >> ${RESTART_LOG}
    ${SERVICE_INIT} ${DEV_PORT} stop
    sleep 1
    sudo rm ${SERVICE_PATH}/cgminer/log/cgminer_${DEV_PORT}.log
    ${SERVICE_INIT} ${DEV_PORT} start
done

sudo chown -R www-data:www-data ${SERVICE_PATH}/cgminer/log
sudo chmod 666 ${SERVICE_PATH}/cgminer/log/*

