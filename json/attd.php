<?php

$str = "{'result':[{'coursecode':'3OE325','coursetitle':'Fabrication Technology','percentage':'59.38'}]}";

$str =  str_replace("'",'"',$str);

/*
,        {'coursecode':'2IT327','coursetitle':'Advanced Data Structure','percentage':'96.30'},        {'coursecode':'2IT323','coursetitle':'Information Theory','percentage':'64.47'},        {'coursecode':'2IT322','coursetitle':'Unix Operating System','percentage':'76.45'},        {'coursecode':'2IT321','coursetitle':'Advanced Database Systems','percentage':'57.89'},        {'coursecode':'2IT377','coursetitle':'Parallel Programming Lab','percentage':'89.09'}
*/

echo $str;

?>