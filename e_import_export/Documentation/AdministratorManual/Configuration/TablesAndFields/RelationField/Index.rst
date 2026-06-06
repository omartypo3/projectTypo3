.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../../Includes.txt

.. _tsconfig:

Relation Field Type
===================
For importation, it will insert a entry into the table into the Relation option and put the new uid into the field associated with the Field option.

For exportation it will pick entries into the Relation option by using the uid in the field option and push it into the Name option entry.

The "as table" option is working for exportation, is you set it to true the relation datas will be displayed as JSON array instead of objects.

somewhereinthejson : [
])

Into the multiple options, you can add field entries that are the same that into the fields options for the newly created object.