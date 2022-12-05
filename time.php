<?php
#####################################################
$sign="+";
$h="0";
$dst="false";

if($dst)
{
 $daylight_saving=date('I');
 if ($daylight_saving)
 {
  if($sign=="-")
  {
   $h=$h-1;
  } else {
   $h=$h+1;
  }
 }
}

$hm=$h*60;
$ms=$hm*60;

if($sign=="-")
{
 $timestamp=time()-($ms);
} else {
 $timestamp=time()+($ms);
}


$gmdatex=gmdate("G:i:s A", $timestamp);

#####################################################

#echo $gmdatex;

?>
