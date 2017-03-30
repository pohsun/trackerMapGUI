trackerMapGUI
=============

Open the trackerMapGUI on ``vocms061`` `<http://vocms061.cern.ch/event_display/trackerMap/index.php>`_

.. code:: bash

  # For people outside CERN, direct access is NOT allowed.
  # Following command build an ssh tunnel via lxplus on your machine
   
  ssh -D 11080 username@lxplus.cern.ch
  
  # Then you could access the GUI via port 11080.


Usage
=====

As you enter the GUI, you'll see few blocks as following.

Save/Load
---------

.. image:: https://github.com/pohsun/trackerMapGUI/blob/master/img/README_SaveLoad.png
  :width: 40px

This function is designed to save/load the setting and generated page.

**Save**:
Type a tag in the input box and **hit enter**. Your record will be kept  with a name of ``YYMMDD_hhmmss_tag``

**Load**:
Pick the record from the dropdown list and **hit enter**. The setting and the generated page will be loaded.

..

  The records on the machine will NOT be deleted automatically.
  
  If you want to delete a record, log into ``vocms061`` and delete the corresponding files in the ``cache/`` directory.


Map Selector
------------

.. image:: https://github.com/pohsun/trackerMapGUI/blob/master/img/README_MapSelector.png
  :width: 40px

Check the checkboxes for your favored map and hit **Update list of wanted maps**.

The first checkbox allows you to show a reference plot side-by-side as you'll see below.

RunData Selector
----------------

.. image:: https://github.com/pohsun/trackerMapGUI/blob/master/img/README_EventDataSelector.png
  :width: 40px

Select an event/dataset to be checked.

``Link Me!`` links to the ``event_display`` page of this run/dataset.

If there's a reference page, the path and the link is shown.

**Remark**:
The dropdown lists refreshes automatically.
They select the first candidate if current value is not available.

Now you get the maps
--------------------

.. image:: https://github.com/pohsun/trackerMapGUI/blob/master/img/README_ExampleMaps.png
  :width: 40px

A tool line is provided to jump between runs and datasets.

With the page anchor, you could fix at certain map while browsing between runs.

When the map is a figure, it shows up on the page.

When the map is a document, a hyperlink is provides.

**Remark**:
Sometimes the same dataset is not available in next run, the selector pick to the first candidate
