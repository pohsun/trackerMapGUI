<?php
    $nMaps = 25;
    $mapNames=array(
        'cmpMode',//0
        'QTestAlarm',
        'QTestAlarmFED',
        'QTestAlarmInteractive',
        'QTestAlarmPSU',
        'QualityTest',//5
        'QualityTestObsolete',
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
        // 1+24
    );
    $mapDescs=array(
        "Compare with the reference",
        "Modules which are BAD from quality tests",
        " - FED view",
        " - Interactive",
        " - PSU view",
        "List of Modules which are BAD from quality tests",
        " - obsolete version",
        "FED errors per modules",
        "Number of digis per module",
        "Number of clusters per module",
        "Number of APV shots per module",
        "Number of clusters on-track per module",
        "Number of clusters off-track per module",
        " - Automatic scale",
        "Number of Inactive hits per module",
        "Number of Missing hits per module",
        "Number of Valid hits per module",
        "Mean value for S/N for on-track cluster corrected for the angle",
        "Mean value for Cluster Charge per cm from Track",
        "Merged Bad components (PCL + FED Err + Cabling)",
        " - Log",
        "List of the modules with the highest values",
        "Fraction of bad components per module found by the prompt calibration loop",
        "Type of bad components per module found by the prompt calibration loop",
        "List of bad components found by the prompt calibration loop"
    );

    function updateSession($varName,$postName){
        if (isset($_POST[$postName])){
            $_SESSION[$varName]   = $_POST[$postName];
        }
    }
    updateSession('dataType','dataTypeSel');
    updateSession('runType','runTypeSel');
    updateSession('runNumber','runNumberSel');
    updateSession('dataSet','dataSetSel');
    updateSession('refPath','refPath');
    for($iMap=0; $iMap<$nMaps; $iMap++){
        updateSession($mapNames[$iMap],$mapNames[$iMap]);
    }

    function test() {
        echo '
</p>
    <figure>
        <img src="../Data2016/Beam/269/269189/StreamExpress/QTestAlarm.png" alt="The Example plot" width="304" height="228">
    </figure>
<p>';
    }

    function ls($directory, $grepFilter){
        exec ("ls -F ${directory} | grep ${grepFilter}", $list);
        return $list;
    }

    function lsdir($directory){
        return ls($directory, ".*/$");
    }

    function parsePath($dataType="", $runType="", $runNumber="", $dataSet="", $plotFname=""){
        $opath = "../";
        if ($dataType != ""){
            $opath = $opath.$dataType.'/';
            if ($runType != ""){
                $opath = $opath.$runType.'/';
                if ($runNumber != ""){
                    $opath = $opath.substr($runNumber,0,3).'/'.$runNumber.'/';
                    if ($dataSet != ""){
                        $opath = $opath.$dataSet.'/';
                        if ($plotFname != ""){
                            $opath = $opath.$plotFname;
                        }
                    }
                }
            }
        }
        return $opath;
    }

    function isCurrentInList($current,$list){
    	foreach( $list as $element ){
     	    if($current == $element){
	    	return true;
	    }
	}
	return false;
    }

    function setDataType(){
        $list = ls('../','-G \'^Data..../$\'');
	if (!isCurrentInList($_SESSION['dataType'],$list)){
	    $_SESSION['dataType'] = $list[0];
	}
        $dataType = $_SESSION['dataType'];
        echo "<form id='dataType' name='dataType' method=\"post\">";
        echo "<select name='dataTypeSel' onchange=\"updateVar('dataType','".$dataType."')\">";
        foreach( $list as $element ){
            if($element == $dataType) {
                echo "<option value=$element SELECTED>$element</option>";
            } else {
                echo "<option value=$element>$element</option>";
            }
        }
        echo "</select>";
        echo "</form>";
    }

    function setRunType(){
        $dataType = $_SESSION['dataType'];
        $list = ls("../".$dataType,'-G \'.*/$\'');
	if (!isCurrentInList($_SESSION['runType'],$list)){
	    $_SESSION['runType'] = $list[0];
	}
        $runType = $_SESSION['runType'];
        echo "<form id='runType' name='runType' method=\"post\">";
        echo "<select name='runTypeSel' onchange=\"updateVar('runType','".$runType."')\">";
        foreach( $list as $element ){
            if($element == $runType) {
                echo "<option value=$element SELECTED>$element</option>";
            } else {
                echo "<option value=$element>$element</option>";
            }
        }
        echo "</select>";
        echo "</form>";
    }

    function setRunNumber(){
        $dataType = $_SESSION['dataType'];
        $runType  = $_SESSION['runType'];
        $list = ls("../".$dataType.$runType."*",'-G \'^....../$\'');
	//$dataSet  = $_SESSION['dataSet'];
	//exec("ls ../".$dataType.$runType."*/*/".$dataSet" | grep -G '../".$dataType."/' | cut -d '/' -f 5",$listAuto);
	if (!isCurrentInList($_SESSION['runNumber'],$list)){
	    $_SESSION['runNumber'] = $list[0];
	}
        $runNumber = $_SESSION['runNumber'];
        echo "<form id='runNumber' name='runNumber' method=\"post\">";
        echo "<select name='runNumberSel' onchange=\"updateVar('runNumber','".$runNumber."')\">";
        foreach( $list as $element ){
            if($element == $runNumber) {
                echo "<option value=$element SELECTED>$element</option>";
            } else {
                echo "<option value=$element>$element</option>";
            }
        }
        echo "</select>";
        echo "</form>";
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
        //echo "<form id='dataSet' method=\"post\">";
        echo "<form id='dataSet' name='dataSet' method=\"post\">";
        echo "<select name='dataSetSel' onchange=\"updateVar('dataSet','".$dataSet."')\">";
        foreach( $list as $element ){
            if($element == $dataSet) {
                echo "<option value=$element SELECTED>$element</option>";
            } else {
                echo "<option value=$element>$element</option>";
            }
        }
        echo "</select>";
        echo "</form>";
    }

    function setWantedMaps(){
        $refPath = $_SESSION['refPath'];
        if ( $refPath != "" ){
            $GLOBALS['mapDescs'][0] = "Compare with the <a href=".$refPath." target='_blank' title=".$refPath.">"."reference"."</a>";
        }
        echo "<ul>";
        echo '<form method="post">';
        for( $iMap = 0; $iMap < $GLOBALS['nMaps']; $iMap++){
	    if ($iMap == 6) continue;
            // This value='0' with the same name is a commonly-seen trick for unchecking boxes.
            echo "<input type='hidden' value='0' name='" . $GLOBALS['mapNames'][$iMap] . "'>";
            if ($_SESSION[$GLOBALS['mapNames'][$iMap]]){
                echo "<li><label for='" . $GLOBALS['mapNames'][$iMap] . "'><input type='checkbox' name='" . $GLOBALS['mapNames'][$iMap] . "' id='" . $GLOBALS['mapNames'][$iMap] . "' CHECKED>" . $GLOBALS['mapDescs'][$iMap] . "</label></li>";
                //plotWantedMap($iMap);
            }else{
                echo "<li><label for='" . $GLOBALS['mapNames'][$iMap] . "'><input type='checkbox' name='" . $GLOBALS['mapNames'][$iMap] . "' id='" . $GLOBALS['mapNames'][$iMap] . "'>" . $GLOBALS['mapDescs'][$iMap] . "</label></li>";
            }
        }
        echo "</ul>";
        echo "<input type='submit' name='updateWantedMaps' value='Update list of wanted maps'>";
        echo '</form>';
    }

    function setRefPath(){
        echo '<form method="post" onsubmit="return setRefPath()">';
        echo '<input type="hidden" id="refPath" name="refPath">';
        echo "<input type='submit' value='Set as reference'>";
        echo '</form>';
    }
    
    function goNeighborRun(){
	echo '<button onclick="goPrevRun()">&lt;&lt; Prev</button>';
	// Hint runNumber and Quick Jump.
	setRunNumber();
	echo '<button onclick="goNextRun()">Next &gt;&gt;</button>';
	// Hint dataSet and Quick jump
	setDataSet();
    }

    function plotWantedMap($runNo,$mapIdx){
        $imgPath=$_SESSION['refPath'];
        if ($runNo == $_SESSION['runNumber']){
            $imgPath = parsePath($_SESSION['dataType'],$_SESSION['runType'],$_SESSION['runNumber'],$_SESSION['dataSet']);
        }
        $imgFiles = array(
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
        switch($mapIdx){
            case 5:
            case 6:
            case 21:
            case 24:
                $imgFiles[$mapIdx] = substr_replace($imgFiles[$mapIdx], $runNo, -5, 0);
                break;
            default:
        }
        switch($mapIdx){
            case 3:
                break;
            case 5:
            case 6:
            case 21:
            case 24:
                break;
            default:
		echo "  <a href=\"#map".$mapIdx."\">Anchor at here!</a>";
                echo "<figure id=\"map".$mapIdx."\">";
                //echo "<img src=\"".$imgPath.$imgFiles[$mapIdx]."\" width='600' height='480'>";
                echo "<a href=\"".$imgPath.$imgFiles[$mapIdx]."\"><img src=\"".$imgPath.$imgFiles[$mapIdx]."\" width='600' height='480'></a>";
                if ($_SESSION['cmpMode']){
                    //echo "<a href=\"".$imgPath.$imgFiles[$mapIdx]."\"><img src=\"".$imgPath.$imgFiles[$mapIdx]."\" width='600' height='480'></a>";
                    echo "<img src=\"".$_SESSION['refPath'].$imgFiles[$mapIdx]."\" width='600' height='480'>";
                }
                echo '</figure>';
        }
    }

    function plotWantedMaps(){
        $runNumber = $_SESSION['runNumber'];
        for( $iMap = 1; $iMap < $GLOBALS['nMaps']; $iMap++){
            // iMap=1 is the switch of cmpMode
            if ($_SESSION[$GLOBALS['mapNames'][$iMap]]){
		// Put a page ancher for quick jump
                plotWantedMap($runNumber,$iMap);
	    	goNeighborRun();
            }
        }
    }
    
    // Additional functions
    function echoPlotHref($plotpath, $width, $height){
    }

?>
