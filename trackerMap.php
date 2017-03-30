<?php
    $nMaps = 25;
    $mapNames=array(
        'cmpMode',//0
        'QTestAlarm',
        'QTestAlarmFED',
        'QTestAlarmInteractive',//3, skip
        'QTestAlarmPSU',
        'QualityTest',//5
        'QualityTestObsolete',//6, skip
        'FractionOfBadChannels',
        'NumberOfDigi',
        'NumberOfCluster',
        'NApvShots',//10
        'NumberOfOnTrackCluster',
        'NumberOfOfffTrackCluster',
        'NumberOfOfffTrackClusterAutoScale',
        'NumberInactiveHits',
        'NumberMissingHits',//15
        'NumberValidHits',
        'StoNCorrOnTrack',
        'ChargePerCMfromTrack',
        'MergedBadComponents',
        'MergedBadComponentsList',//20
        'TopModulesList',
        'PCLBadComponentsFrac',
        'PCLBadComponentsType',
        'PCLBadComponentsList'
    );
    $mapDescs=array(
        "Compare with the reference",//0
        "Modules which are BAD from quality tests",
        "Modules which are BAD from quality tests - FED view",
        "Modules which are BAD from quality tests - Interactive",
        "Modules which are BAD from quality tests - PSU view",
        "List of Modules which are BAD from quality tests",//5
        "List of Modules which are BAD from quality tests - obsolete version",
        "FED errors per modules",
        "Number of digis per module",
        "Number of clusters per module",
        "Number of APV shots per module",//10
        "Number of clusters on-track per module",
        "Number of clusters off-track per module",
        "Number of clusters off-track per module - Automatic scale",
        "Number of Inactive hits per module",
        "Number of Missing hits per module",//15
        "Number of Valid hits per module",
        "Mean value for S/N for on-track cluster corrected for the angle",
        "Mean value for Cluster Charge per cm from Track",
        "Merged Bad components (PCL + FED Err + Cabling)",
        "Merged Bad components (PCL + FED Err + Cabling) - Log",//20
        "List of the modules with the highest values",
        "Fraction of bad components per module found by the prompt calibration loop",
        "Type of bad components per module found by the prompt calibration loop",
        "List of bad components found by the prompt calibration loop"
    );
    $mapFiles=array(
    	'cmpMode',//0
    	'QTestAlarm.png',
    	'QTestAlarm_fed.png',
    	'fedmap.html',
    	'QTestAlarm_psu.png',
    	'QualityTest_run.txt',//5
    	'QualityTestOBSOLETE_run.txt',
    	'FractionOfBadChannels.png',
    	'NumberOfDigi.png',
    	'NumberOfCluster.png',
    	'NApvShots.png',//10
    	'NumberOfOnTrackCluster.png',
    	'NumberOfOfffTrackCluster.png',
    	'NumberOfOfffTrackCluster_autoscale.png',
    	'NumberInactiveHits.png',
    	'NumberMissingHits.png',//15
    	'NumberValidHits.png',
    	'StoNCorrOnTrack.png',
    	'ChargePerCMfromTrack.png',
    	'MergedBadComponentsTkMap.png',
    	'MergedBadComponents_run.txt',//20
    	'TopModulesList.log',
    	'PCLBadComponents.png',
    	'PCLBadComponents_Run_.png',
    	'PCLBadComponents.log'
    );
    $mapSkip=array(
	3,6
    );

    function updateSession($varName,$postName){
        if (isset($_POST[$postName])){
            $_SESSION[$varName]   = $_POST[$postName];
        }
    }
    
    updateSession('cacheTime','cacheTimeSel');
    updateSession('dataType','dataTypeSel');
    updateSession('runType','runTypeSel');
    updateSession('runNumber','runNumberSel');
    updateSession('dataSet','dataSetSel');
    updateSession('refPath','refPath');
    for($iMap=0; $iMap<$nMaps; $iMap++){
        updateSession($mapNames[$iMap],$mapNames[$iMap]);
    }

    // html decorators
    function setAnchor($anchorName, $desc, $hLevel = 1){
	$hLevel = 'h'.$hLevel;
        echo "<". $hLevel . " id=\"".$anchorName."\">".$desc."</".$hLevel.">\n";
    }

    function goToAnchor($anchorName, $desc){
	echo "<br><a href=\"#".$anchorName."\">".$desc."</a><br>\n";
    }

    // data-handling functions, NO echo/print is allowed
    function ls($directory, $grepFilter){
        exec ("ls -F ${directory} | grep ${grepFilter}", $list);
        return $list;
    }

    function lsdir($directory){
        return ls($directory, ".*/$");
    }

    function parsePath($dataType="", $runType="", $runNumber="", $dataSet="", $plotFname=""){
        $opath = "/data/users/event_display/";
        if ($dataType != ""){
            $opath = $opath.$dataType.'/';
            if ($runType != ""){
                $opath = $opath.$runType.'/';
                if ($runNumber != ""){
                    $opath = $opath.substr($runNumber,0,3).'/'.$runNumber.'/';
                    if ($dataSet != ""){
                        $opath = $opath.$dataSet.'/';
                        if ($plotFname != ""){
                            $opath = $opath.$plotFname.'/';
                        }
                    }
                }
            }
        }
        return '..'.substr($opath,25,-1);
    }

    function isCurrentInList($current,$list){
    	foreach( $list as $element ){
     	    if($current == $element){
	    	return true;
	    }
	}
	return false;
    }

    // HTML printers
    function setCacheTime(){
	exec("ls -t cache/????????_??????_*.html",$list);
        $cacheTime = $_SESSION['cacheTime'];
        echo "<form id='cacheTime' name='cacheTime' method=\"post\">\n";
	echo "To save the settings, insert a tag; To load a record, select a record.<br>\n";
	echo "Insert/Select and then hit enter:\n";
        echo "<input list='savedTimeStamps' name='cacheTimeSel' onblur='updateVar('cacheTime','".$cacheTime."')>\n";
        echo "<datalist id='savedTimeStamps'>\n";
        foreach( $list as $element ){
            echo "<option value='".substr($element,6,-5)."'>".substr($element,6,-5)."</option>\n";
        }
        echo "</datalist>\n";
        echo "</form>\n";
    }

    function setDataType(){
        $list = ls('/data/users/event_display/','-G \'^Data..../$\'');
	if (!isCurrentInList($_SESSION['dataType'],$list)){
	    $_SESSION['dataType'] = $list[0];
	}
        $dataType = $_SESSION['dataType'];
        echo "<form id='dataType' name='dataType' method=\"post\">\n";
        echo "<select name='dataTypeSel' onchange=\"updateVar('dataType','".$dataType."')\">\n";
        foreach( $list as $element ){
            if($element == $dataType) {
                echo "<option value=$element SELECTED>$element</option>\n";
            } else {
                echo "<option value=$element>$element</option>\n";
            }
        }
        echo "</select>\n";
        echo "</form>\n";
    }

    function setRunType(){
        $dataType = $_SESSION['dataType'];
        $list = ls("/data/users/event_display/".$dataType,'-G \'.*/$\'');
	if (!isCurrentInList($_SESSION['runType'],$list)){
	    $_SESSION['runType'] = $list[0];
	}
        $runType = $_SESSION['runType'];
        echo "<form id='runType' name='runType' method=\"post\">\n";
        echo "<select name='runTypeSel' onchange=\"updateVar('runType','".$runType."')\">\n";
        foreach( $list as $element ){
            if($element == $runType) {
                echo "<option value=$element SELECTED>$element</option>\n";
            } else {
                echo "<option value=$element>$element</option>\n";
            }
        }
        echo "</select>\n";
        echo "</form>\n";
    }

    function setRunNumber(){
        $dataType = $_SESSION['dataType'];
        $runType  = $_SESSION['runType'];
        $list = ls("/data/users/event_display/".$dataType.$runType."*",'-G \'^....../$\'');
	//$dataSet  = $_SESSION['dataSet'];
	//exec("ls /data/users/event_display/".$dataType.$runType."*/*/".$dataSet" | grep -G '/data/users/event_display/".$dataType."/' | cut -d '/' -f 5",$listAuto);
	if (!isCurrentInList($_SESSION['runNumber'],$list)){
	    $_SESSION['runNumber'] = $list[0];
	}
        $runNumber = $_SESSION['runNumber'];
        echo "<form id='runNumber' name='runNumber' method=\"post\">\n";
        echo "<select name='runNumberSel' onchange=\"updateVar('runNumber','".$runNumber."')\">\n";
        foreach( $list as $element ){
            if($element == $runNumber) {
                echo "<option value=$element SELECTED>$element</option>\n";
            } else {
                echo "<option value=$element>$element</option>\n";
            }
        }
        echo "</select>\n";
        echo "</form>\n";
    }

    function setDataSet(){
	// To Be Fixed: Shouldn't select dataSet automatically as go to neighbor runs.
        $dataType = $_SESSION['dataType'];
        $runType  = $_SESSION['runType'];
        $runNumber = $_SESSION['runNumber'];
        $list = ls(parsePath($dataType,$runType,$runNumber),'-G \'.*/\'');
	if (!isCurrentInList($_SESSION['dataSet'],$list)){
	    $_SESSION['dataSet'] = $list[0];
	}
        $dataSet = $_SESSION['dataSet'];
        echo "<form id='dataSet' name='dataSet' method=\"post\">\n";
        echo "<select name='dataSetSel' onchange=\"updateVar('dataSet','".$dataSet."')\">\n";
        foreach( $list as $element ){
            if($element == $dataSet) {
                echo "<option value=$element SELECTED>$element</option>\n";
            } else {
                echo "<option value=$element>$element</option>\n";
            }
        }
        echo "</select>\n";
        echo "</form>\n";
    }

    //function setRefDataSet(){
    //    echo "<form id='refDataSet' name='refDataSet' method=\"post\">\n";
    //    echo "<select name='refDataSetSel' onchange=\"updateVar('refDataSet','".$refDataSet."')\">\n";
    //    foreach( $list as $element ){
    //        if($element == $refDataSet) {
    //            echo "<option value=$element SELECTED>$element</option>\n";
    //        } else {
    //            echo "<option value=$element>$element</option>\n";
    //        }
    //    }
    //    echo "</select>\n";
    //    echo "</form>\n";
    //}

    function setWantedMaps(){
	echo "<h2>Check your needed maps</h2>";
        $refPath = $_SESSION['refPath'];
        if ( $refPath != "" ){
            $GLOBALS['mapDescs'][0] = "Compare with the <a href=".$refPath." target='_blank' title=".$refPath.">"."reference"."</a>";
        }
        echo "<ul>\n";
        echo "<form method=\"post\">\n";
        for( $iMap = 0; $iMap < $GLOBALS['nMaps']; $iMap++){
	    if ( isCurrentInList($iMap,$GLOBALS['mapSkip']) ) continue;
            // This value='0' with the same name is a commonly-seen trick for unchecking boxes.
            echo "<input type='hidden' value='0' name='" . $GLOBALS['mapNames'][$iMap] . "'>\n";
            if ($_SESSION[$GLOBALS['mapNames'][$iMap]] && strcmp($_SESSION[$GLOBALS['mapNames'][$iMap]],'0') != 0 ){
                echo "<li><label for='" . $GLOBALS['mapNames'][$iMap] . "'><input type='checkbox' name='" . $GLOBALS['mapNames'][$iMap] . "' id='" . $GLOBALS['mapNames'][$iMap] . "' CHECKED>" . $GLOBALS['mapDescs'][$iMap] . "</label></li>\n";
            }else{
                echo "<li><label for='" . $GLOBALS['mapNames'][$iMap] . "'><input type='checkbox' name='" . $GLOBALS['mapNames'][$iMap] . "' id='" . $GLOBALS['mapNames'][$iMap] . "'>" . $GLOBALS['mapDescs'][$iMap] . "</label></li>\n";
            }
        }
        echo "</ul>\n";
        echo "<input type='submit' name='updateWantedMaps' value='Update list of wanted maps'>\n";
        echo "</form>\n";
    }

    function setCurrentPath(){
        $imgPath = parsePath($_SESSION['dataType'],$_SESSION['runType'],$_SESSION['runNumber'],$_SESSION['dataSet']);
	echo "<a href=".$imgPath." target='_blank' >Link Me!</a>\n";
    }

    function setRefPath(){
        echo "<form method='post' onsubmit='return setRefPath()'>\n";
        echo "<input type='hidden' id='refPath' name='refPath'>\n";
        echo "<input type='submit' value='Set as reference'>\n";
        echo "</form>\n";
    }
    
    function goNeighborRun(){
	echo "<button onclick='goPrevRun()'>&lt;&lt; Prev</button>\n";
	// Hint runNumber and Quick Jump.
	setRunNumber();
	echo "<button onclick='goNextRun()'>Next &gt;&gt;</button>";
	// Hint dataSet and Quick jump
	setDataSet();
	//setRefDataSet();
    }

    function plotWantedMap($runNo,$mapIdx){
        $imgPath=$_SESSION['refPath'];
        if ($runNo == $_SESSION['runNumber']){
            $imgPath = parsePath($_SESSION['dataType'],$_SESSION['runType'],$_SESSION['runNumber'],$_SESSION['dataSet']);
        }
	$mapFiles = $GLOBALS['mapFiles'];
        switch($mapIdx){
            case 5:
            case 6:
            case 20:
            case 23:
                $mapFiles[$mapIdx] = substr_replace($mapFiles[$mapIdx], substr($runNo,0,6), -4, 0);
                break;
            default:
        }
        switch($mapIdx){
            case 3:
                break;
            case 5:
            case 6:
	    case 20:
            case 21:
            case 24:
		echo "  <br><br><a href=\"#map".$mapIdx."\">Anchor at here!</a>\n";
		echo "  <br>".$GLOBALS['mapDescs'][$mapIdx]."\n";
		echo '<p>';
                echo "  <a href=\"".$imgPath.$mapFiles[$mapIdx]."\" target='_blank' id=\"map".$mapIdx."\">"."Open in new page"."</a>\n";
                if ($_SESSION['cmpMode']){
                    echo "  <a href=\"".$_SESSION['refPath'].$mapFiles[$mapIdx]."\" target='_blank' id=\"map".$mapIdx."\">"."Open reference in new page"."</a>\n";
                }
		echo '</p>';
                break;
            default:
		echo "  <br><br><a href=\"#map".$mapIdx."\">Anchor at here!</a>\n";
		echo "  <br>".$GLOBALS['mapDescs'][$mapIdx]."\n";
                echo "<figure id=\"map".$mapIdx."\">\n";
                //echo "<img src=\"".$imgPath.$mapFiles[$mapIdx]."\" width='600' height='480'>";
                echo "<a href=\"".$imgPath.$mapFiles[$mapIdx]."\"><img src=\"".$imgPath.$mapFiles[$mapIdx]."\" width='600' height='480'></a>\n";
                if ($_SESSION['cmpMode']){
                    //echo "<a href=\"".$imgPath.$mapFiles[$mapIdx]."\"><img src=\"".$imgPath.$mapFiles[$mapIdx]."\" width='600' height='480'></a>";
                    echo "<img src=\"".$_SESSION['refPath'].$mapFiles[$mapIdx]."\" width='600' height='480'>\n";
                }
                echo "</figure>\n";
        }
    }

    function plotWantedMaps(){
        $runNumber = $_SESSION['runNumber'];
	echo "<h2>Now you get the plots below...</h2>";
	echo "<p>\n";
        for( $iMap = 1; $iMap < $GLOBALS['nMaps']; $iMap++){
            // iMap=1 is the switch of cmpMode
            if ($_SESSION[$GLOBALS['mapNames'][$iMap]]){
		// Put a page ancher for quick jump
                plotWantedMap($runNumber,$iMap);
		goNeighborRun();
            }
        }
	echo "</p>\n";
    }

    function writeDevTool(){
	// Reset session
	echo "<form action=\"process.php\" method=\"post\">\n";
	echo "<button type=\"submit\">Reset sesstion</button>\n";
        echo "</form>\n";

	// Ring the Alert!
	echo "<button onclick=\"ringAlert()\">Alert!</button>\n";
	
	// Echo all 
	echo "<br><p>\n";
	echo "SESSION ID = ".$_SESSION['cacheTime']."<br>\n";
	echo "dataType   = ".$_SESSION['dataType']."<br>\n";
	echo "runType    = ".$_SESSION['runType']."<br>\n";
	echo "runNumber  = ".$_SESSION['runNumber']."<br>\n";
	echo "dataSet    = ".$_SESSION['dataSet']."<br>\n";
	echo "refPath    = ".$_SESSION['refPath']."<br>\n";
        for($iMap=0; $iMap<$GLOBALS['nMaps']; $iMap++){
            echo $GLOBALS['mapNames'][$iMap].' = '.$_SESSION[$GLOBALS['mapNames'][$iMap]]."<br>\n";
        }
	echo "</p>\n";

	// Test
    }

    function echoPlotHref($plotpath, $width, $height){
    }

    // Now construct paragraphs of main page with HTML printers
    function writeSaveLoad(){
	echo '<h2>Save/Load</h2>';
       	echo "<p>\n";
	setCacheTime();
        echo "</p>\n";
    }
    function writeSelector(){
        echo "<h2>Pick event and dataset</h2>\n";
        echo "<p>\n";
        setDataType();
        setRunType();
        setRunNumber();
        setDataSet();
	setCurrentPath();
        setRefPath();
        echo "</p>\n";
        $refPath = $_SESSION['refPath'];
        if ( $refPath != "" ){
            echo "Current refenence path is <a href=".$refPath." target='_blank' title=".$refPath.">".substr($refPath,3,-1)."</a>";
        }
    }

    function writeCache($fname){
	ob_start();
        plotWantedMaps();
	$content = ob_get_contents();
	ob_end_clean();
	$cache = fopen("cache/cache_".$fname.".html", "w") or die("Unable to open file!");
	fwrite($cache, $content);
	fclose($cache);
    }

    function saveCache($fname){
	exec("date +%Y%m%d_%H%M%S",$timestamp);
    	exec("cp cache/cache_".session_id().".html cache/".$timestamp[0]."_".$fname.".html");
	$config = fopen("cache/".$timestamp[0]."_".$fname.".php", "w") or die("Unable to open file!");
	fwrite($config,'dataType=' .$_SESSION['dataType' ]."\n");
	fwrite($config,'runType='  .$_SESSION['runType'  ]."\n");
	fwrite($config,'runNumber='.$_SESSION['runNumber']."\n");
	fwrite($config,'dataSet='  .$_SESSION['dataSet'  ]."\n");
	fwrite($config,'refPath='  .$_SESSION['refPath'  ]."\n");
	fwrite($config,'cacheTime='.$_SESSION['cacheTime']."\n");
        for($iMap=0; $iMap<$GLOBALS['nMaps']; $iMap++){
	    if ( isCurrentInList($iMap,$GLOBALS['mapSkip']) ) continue;
            fwrite($config,$GLOBALS['mapNames'][$iMap].'='.$_SESSION[$GLOBALS['mapNames'][$iMap]]."\n");
        }
	fclose($config);
	return $timestamp[0]."_".$fname.".html";
    }
    
    function loadCache($fname){
	readfile("cache/".$fname);
    }
   
    function loadConfig($fname){
	// http://stackoverflow.com/questions/17391958/php-retrieve-data-from-text-file
	$lines_array = file("cache/".$fname);
	foreach($lines_array as $line) {
            $var = explode('=', str_replace("\n",'',$line), 2);
	    if ( count($var) == 2 && strcmp($var[1],"0") != 0 ){
	        $_SESSION[$var[0]] = $var[1];
	    }else{
		unset($_SESSION[$var[0]]);
	    }
        }
    }

    function ifCacheExist($fname){
	if ( preg_match("/^[0-9]{8}_[0-9]{6}_.+/",$fname) ) {
	    exec("ls cache/????????_??????_*.html | grep -E \"".$fname."\.html\"", $occurance);
            return substr($occurance[0],6);
	}elseif ( strlen($fname) > 0 && strcmp($fname,'NOW') != 0 ) {
	    return $fname;
	}else{
	    return 'NOW';
	}
    }

    // Construct main page
    function main(){
	// Put all html stuff here.
        setAnchor('top','CMS TrackerMap GUI',1);
	
    	// Main show region
    	$cacheFile = ifCacheExist($_SESSION['cacheTime']);
	if ( strcmp($cacheFile,'NOW') == 0 ){
	    writeCache(session_id());
	    // NOW
	    writeSaveLoad();
	    setWantedMaps();
	    writeSelector();
	    loadCache("cache_".session_id().".html");
	    $_SESSION['cacheTime']='NOW';
        }elseif ( preg_match("/^[0-9]{8}_[0-9]{6}_.*.html$/",$cacheFile) ) {
	    loadConfig(substr($cacheFile,0,strlen($cacheFile)-5).'.php');
	    // Load exist record.
	    writeSaveLoad();
	    setWantedMaps();
	    writeSelector();
	    loadCache($cacheFile);
	    $_SESSION['cacheTime']='NOW';
	}else{
            writeCache(session_id());
            // Create new record.
	    writeSaveLoad();
	    setWantedMaps();
	    writeSelector();
            loadCache(saveCache($cacheFile));
	    $_SESSION['cacheTime']='NOW';
	}

	goToAnchor('top','Go To Top');
        setAnchor('bottom','');
	
	// Dev
	//writeDevTool();
    }

?>
