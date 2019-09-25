# CMS tkMap GUI
###### tags:`CMS` `DQM`

Open the trackerMapGUI on ``vocms061`` http://vocms061.cern.ch/event_display/trackerMap/index.php


# Usage

[**Open the GUI**](http://vocms061.cern.ch/event_display/trackerMap/index.php)

:::info
For people outside CERN, direct access is **NOT allowed**.

Following command build an ssh tunnel via lxplus on your machine
**`ssh -D 11080 username@lxplus.cern.ch`**
Then you could access the GUI via port 11080.
:::

As you enter the GUI. From top to bottom, you'll see few blocks as following

### Map selector
:::success
![](https://raw.githubusercontent.com/pohsun/trackerMapGUI/master/img/README_MapSelector.png =800x500)
:::

This section decides which map/list to be shown.
Check the checkboxes for your favored maps and click the **Update list of wanted maps** to confirm.

### Record selector
:::success
![](https://raw.githubusercontent.com/pohsun/trackerMapGUI/master/img/README_SaveLoad.png =400x100)
:::

This function is designed to save/load the setting and generated page.

**Save**:
Type a tag in the input box and **hit enter**. Your record will be kept  with a name of `YYMMDD_hhmmss_tag`

**Load**:
Pick the record from the dropdown list and **hit enter**. The setting and the generated page will be loaded.

> The records on the machine will NOT be deleted automatically.
> If you want to delete a record, log into `vocms061` and delete the corresponding files in the `cache/` directory. 

### RunData selector
:::success
![](https://raw.githubusercontent.com/pohsun/trackerMapGUI/master/img/README_EventDataSelector.png =800x130)
:::

Just pick a run/dataset to be checked.
Link to the corresponding TkMap page on **Link Me!**.
If a reference run is given, a link to tkMap page is provided here.

### Maps
:::success
![](https://raw.githubusercontent.com/pohsun/trackerMapGUI/master/img/README_ExampleMaps.png =800x400)
:::

We should a have all favored maps here.
The tool line is helpful when we're jumping between runs.

**Remark**:
Keep an eye on the **dataset**.
By design, dataset will be automatically changed if the same dataset is not available for next/previous "run" in the database.

----
# Wishlist
- [ ] < Your mail > Your comment
- [ ] < po-hsun.chen@cern.ch > Could you put a banana in your ear?
    - No, definitely no.
    - Maybe we could try with an apple for instead.

----

# For Developers
Check the [**git repository**](https://github.com/pohsun/trackerMapGUI)

By default, this GUI follow the file hierachy
:::info
HEAD: /data/user/event_display/trackerDQM
:::

## To-do list
- [x] Could you add 2 separate sets of fields? 1 for the run you want to look at, and 1 for the reference run. Maybe add a checkbox, like the already existing one, to compare to a reference run and make the second set of fields active only if the box is checked.
- [x] I think it is easier to use if the list of plots stays at the top and the tracker maps are added at the bottom 
- [x] Could you try to add a "link me" button that gives a link showing the tracker map of the run and reference run you're looking at?
- [x] Either remove the "list of...", or make sure they work (maybe start by removing them, we can add them later if needed)
- [x] For the "automatic scale" tracker map, please repeat "Number of off-track clusters", otherwise it is not clear
- [x] The interactive QTest map doesn't work. Either fix it, or remove it.
- [ ] Maybe you can also add a field below each reference run map to switch between StreamExpress and ZeroBias, as is the case for the run you're looking at.
- [x] "Anchor here" should be on the next line, now it's next to the buttons for the previous tracker map.
- [x] "Type of bad components per module found by the prompt calibration loop" is not showing a tracker map...
- [x] What is the "log"? It's not showing anything.
- [ ] In page list checking(sub-window)
- [ ] Page size detection/map size setting
- [ ] Documentation
    - [ ] github
    - [ ] [twiki]()