.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt

.. _tsconfig:

General configuration
=====================
For every import/export routines, you will have to configure your general settings

First create a routine, go on list view and choose the page where you intend to record your configuration.

Create a new record and choose Conf into the E-import-Export section.

You are now able to configure your routine.

You will have various options


Simple options
--------------

* Title : is simply a title to help you identify the export/import, just try to give a comprehensive name/
* Tags : **need to be done**
* Hide : If you want to hide the conf entry among your others list entries
* Type : The file type of the file you will handle, you have the choice between :
* * Csv
* * Xml
* * Json
    The format differents filr types file is detailled in the format section
* Intended for : Choose between import and export
* Reachable from : The way the informations are transmited
  Every accessing procedure will be more explained in user administration section
* * Module : For importation. In the backend module "Import-Export", you will have a "import/export" button
* * Scheduler : For importation. You will be able to register a scheduler task from the typo 3 scheduler module
* * Ajax : You will allow an ajax flow for exportation/importation
* Stream URl : For importation, this is where the file to import is located, you can choose a stream or a hosted static file


Tables
------

Here you can choose wich table you want to import/export. For now, you can only choose one table but we will add the possibility yo process multiple tables in the future.

You can add your table by clicking on create new into the Tables section.

A select box allow you to choose your table.

You can add a where condition. For exemple if you want only the rows where color is set to red, just type :
"color = 'red'"