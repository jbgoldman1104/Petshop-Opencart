<?php 

$query['pavmegamenu'][]  = "DELETE FROM `".DB_PREFIX ."setting` WHERE `code`='pavmegamenu' and `key` = 'pavmegamenu_module'";
$query['pavmegamenu'][]  = "DELETE FROM `".DB_PREFIX ."setting` WHERE `code`='pavmegamenu_params' and `key` = 'params'";
$query['pavmegamenu'][] =  " 
INSERT INTO `".DB_PREFIX ."setting` (`setting_id`, `store_id`, `code`, `key`, `value`, `serialized`) VALUES
(0, 0, 'pavmegamenu_params', 'pavmegamenu_params', '[{\"submenu\":1,\"subwidth\":600,\"id\":63,\"align\":\"aligned-left\",\"cols\":1,\"group\":0,\"rows\":[{\"cols\":[{\"widgets\":\"wid-63\",\"colwidth\":6},{\"widgets\":\"wid-66\",\"colwidth\":6}]}]},{\"submenu\":1,\"id\":65,\"align\":\"aligned-left\",\"cols\":1,\"group\":0,\"rows\":[{\"cols\":[{\"type\":\"menu\",\"colwidth\":12}]}]},{\"align\":\"aligned-left\",\"submenu\":1,\"cols\":1,\"group\":0,\"id\":69,\"rows\":[{\"cols\":[{\"type\":\"menu\",\"colwidth\":12}]}]}]', 0);
";


$query['pavblog'][] ="
INSERT INTO `".DB_PREFIX ."layout_route` (`layout_route_id`, `layout_id`, `store_id`, `route`) VALUES
(0, 14, 0, 'pavblog/%');
";
$query['pavblog'][] ="
INSERT INTO `".DB_PREFIX ."layout` (`layout_id`, `name`) VALUES
(0, 'Pav Blog');
";
?>