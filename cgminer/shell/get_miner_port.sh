#!/bin/bash

for DEV_PORT_PATH in `ls /dev/ttyUSB* 2>/dev/null`
do
    DEV_PORT=`basename $DEV_PORT_PATH`
    echo -n $DEV_PORT,
done

