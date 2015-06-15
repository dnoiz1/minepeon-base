#!/bin/bash
PREFIX="/opt/minepeon/http/rrd/mhsav"
FILES="$PREFIX-hour.png $PREFIX-day.png $PREFIX-week.png $PREFIX-month.png"
while true; do
	/usr/bin/fbi $FILES --dev /dev/fb0 --vt 1 --blend 500 --timeout 10 --noverbose --noreadahead &
    PID=$!
	sleep 42
    killall fbi
done;
exit 0
