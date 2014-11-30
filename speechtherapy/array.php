<?php
$soundArray=array();
$type='ch';
$level='1';
$info = "select distinct tblImage.fldName, fldImageFile, fldSoundFile ";
$info .= "from tblImage inner join tblSound ";
$info .= "where tblSound.fldLevel=".$level." and tblImage.fldLevel=".$level." and ";
$info .= "tblSound.fldType='".$type."' and tblImage.fldType='".$type."' ";
$info .= "order by rand() limit 8";
$result = $thisDatabase->select($info);
$result = array_merge($result, $result);
foreach ($result as $i){
        $a="data:image/jpg;base64,".base64_encode($i[1]);
        $array= array($i[0],$a);
        $soundArray[]=$array;
        /*echo '<img id="'.$i[0].'" src="data:image/jpg;base64,'.base64_encode($i[1]).'" /> ';*/
}
?>