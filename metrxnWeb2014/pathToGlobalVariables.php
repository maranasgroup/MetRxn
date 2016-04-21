<?php
function relativePaths($from, $to, $ps = DIRECTORY_SEPARATOR)
{
  $arFrom = explode($ps, rtrim($from, $ps));
  $arTo = explode($ps, rtrim($to, $ps));
  while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0]))
  {
    array_shift($arFrom);
    array_shift($arTo);
  }
  return str_pad("", count($arFrom) * 3, '..'.$ps).implode($ps, $arTo);
}

if ('WINNT' == PHP_OS)
{
	$GlobalVariables = 'C:\inetpub\wwwroot\metRxn\globalVariables.php';
}
else 
{
	$GlobalVariables = '/home/www/MetRxn/globalVariables.php';
}

$pathToGlobalVariables = relativePaths(getcwd(),$GlobalVariables);

?>