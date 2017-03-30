<!DOCTYPE html>
<?php session_start();?>

<html>
    <head>
        <link type='text/css' rel='stylesheet' href='style.css'/>
        <title> TkMapGUI</title>
        <script>
            function updateVar(varName,currentVal){
		// Update all instance of the form before submit
                var varArray = document.getElementsByName(varName+"Sel");
		var newVarIdx = '';
		for(i=0; i < varArray.length; i++){
		    if (currentVal != varArray[i].options[varArray[i].selectedIndex].text){
			newVarIdx = varArray[i].selectedIndex;
			break;
		    }
		}
		for(i=0; i < varArray.length; i++){
		    varArray[i].selectedIndex = newVarIdx;
		}
                document.getElementById(varName).submit();
            }

            function setRefPath(){
                var dataTypeE  = document.getElementById('dataType').dataTypeSel;
                var runTypeE   = document.getElementById('runType').runTypeSel;
                var runNumberE = document.getElementById('runNumber').runNumberSel;
                var dataSetE   = document.getElementById('dataSet').dataSetSel;
                var dataTypeS  = dataTypeE.options[dataTypeE.selectedIndex].text;
                var runTypeS   = runTypeE.options[runTypeE.selectedIndex].text;
                var runNumberS = runNumberE.options[runNumberE.selectedIndex].text;
                var dataSetS   = dataSetE.options[dataSetE.selectedIndex].text;

                document.getElementById('refPath').value = '../'+dataTypeS+runTypeS+runNumberS.substr(0,3)+'/'+runNumberS+dataSetS;
                return true;
            }

	    function goNextRun(){
		var runNumberE = document.getElementById('runNumber').runNumberSel;
		if (runNumberE.selectedIndex+1 < runNumberE.length){
		    runNumberE.selectedIndex = runNumberE.selectedIndex+1;
		    updateVar('runNumber',runNumberE.options[runNumberE.selectedIndex-1].text);
		}else{
		    alert("It's the last run!");
		}
	    }

	    function goPrevRun(){
		var runNumberE = document.getElementById('runNumber').runNumberSel;
		if (runNumberE.selectedIndex-1 >= 0){
		    runNumberE.selectedIndex = runNumberE.selectedIndex-1;
		    updateVar('runNumber',runNumberE.options[runNumberE.selectedIndex+1].text);
		}else{
		    alert("It's the first run!");
		}
	    }
	    
	    function setWindowSize(){
		// http://stackoverflow.com/questions/1297449/change-image-size-with-javascript
	    }

	    function saveCache(tag){
	    }
	
	    function ringAlert(){
	        alert("Alert!");
	    }

	    function ready(){
	    }

        </script>
    </head>
    <?php
        include("trackerMap.php");
    ?>
    <body>
	<?php
	    main();
    	?>
    </body>
</html>

