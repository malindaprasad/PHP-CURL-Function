<?php
/**
 * User: malindar
 * Date: 3/8/14
 * Time: 12:43 AM
 * malindaprasad.com
 */
include_once 'curl.php';


echo json_encode(getHTTP('http://localhosst/dd/', '', 'GET', null, null,null,false));