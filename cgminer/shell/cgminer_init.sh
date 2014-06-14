#!/bin/bash

PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/sbin:/usr/sbin:/sbin"

if [ $# -ne 2 ]
then
    echo "Usage: $0 port { stop | start | restart }"
    exit 1
fi

DEV_PORT=$1
OPERATION=$2

cd `dirname $0`
cd ..

service_stop()
{
    CGMINER_PID=`ps -ef | grep -v grep | grep bin/cgminer | grep ${DEV_PORT} | awk '{ print $2 }'`
    if [ ! -z "${CGMINER_PID}" ]
    then
        sudo kill ${CGMINER_PID} -s SIGINT
    fi
}

service_start()
{
    CGMINER_PID=`ps -ef | grep -v grep | grep bin/cgminer | grep ${DEV_PORT} | awk '{ print $2 }'`
    if [ ! -z "${CGMINER_PID}" ]
    then
        echo "cgminer on port ${DEV_PORT} is running, pid: ${CGMINER_PID}"
        exit 1
    fi

    # start cgminer
    sudo nohup ./bin/cgminer --config conf/cgminer_${DEV_PORT}.conf >> log/cgminer_${DEV_PORT}.log &

    sleep 1
    sudo chmod 666 log/cgminer_${DEV_PORT}.log
}

case $OPERATION in
    stop)
    echo "Service STOPING..."
    service_stop
    ;;
    start)
    echo "Service STARTING..."
    service_start
    ;;
    restart)
    echo "Service RESTARTING..."
    service_stop
    sleep 1
    service_start
    ;;
    *)
    echo "Usage: $0 { stop | start | restart }"
esac

exit 0

