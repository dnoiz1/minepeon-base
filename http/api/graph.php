<?php

require('miner.inc.php');
require('rrd.inc.php');
include('settings.inc.php');

function create_graph($output, $start, $title){
  $rrd = '/opt/minepeon/var/rrd/';
  $png = '/opt/minepeon/http/rrd/';

  $options = array(
    '--full-size-mode',
    '--width=480',
//    '--only-graph',
    '--height=320',
    '--slope-mode',
    '--start', $start,
    '--title='.$title,
    '--border=0',
    '--vertical-label=Hash per second',
    '--lower=0',
    '--color=BACK#000',      
    '--color=CANVAS#000',    
    '--color=FONT#0ff',
    '--color=GRID#00000000',
    '--color=MGRID#2180ACCC',
    '--no-gridfit',
    'DEF:hashrate='.$rrd.'hashrate.rrd:hashrate:AVERAGE',
    'CDEF:realspeed=hashrate,1000,*',
//    'AREA:realspeed#0c0',
    'LINE:realspeed#fff'
    );

    $gradient = explode(" ", rrd::gradient('realspeed', "#000033ff", "#00ccccff", false, 30));
    $options = array_filter(array_merge($options, $gradient));
    return rrd_graph($png.$output, $options);
}


echo create_graph('mhsav-hour.png', '-1h', 'Last Hour')
    && create_graph('mhsav-day.png', '-1d', 'Last Day')
    && create_graph('mhsav-week.png', '-1w', 'Last Week')
    && create_graph('mhsav-month.png', '-1m', 'Last Month')
    && create_graph('mhsav-year.png', '-1y', 'Last Year');

print_r(rrd_error());

?>
