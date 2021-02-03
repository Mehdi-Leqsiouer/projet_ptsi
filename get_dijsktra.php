<?php
    $item=$_POST["depart"];
	$item2=$_POST["arriver"];
    $tmp = passthru("python calc_dijsktra.py $item $item2");
    echo $tmp;

?>