<?php
    $item=$_POST["depart"];
	$item2=$_POST["arriver"];
    $tmp = passthru("python3 calc_dijsktra.py $item $item2");
    echo $tmp;

?>