.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../../Includes.txt

.. _tsconfig:

Common Field Configuration
==========================
All field configuration share the same options.


Configuration
-------------

The Name param is the column were database datas will be exported or where the datas will be picked for importation.

The field is the field where the datas will be stored for importation or picked for exportation.

You can use stdwrap routines for complex after process behaviours.

If we have an empty value, you can set the default behaviour, default use default mysql value, null set to null value, array give an empty array and ampty give a empty string.

IMPORTANT FOR IMPORTATION : You need a field to set the pid value, otherwise the importation will not work


Specific Tips
-------------

For JSON, if you want to import/export objects like this :
.. code-block:: json
	
	{
		"A": {
			"B" : "value"
			
		},
		
	}
	
	
You can access to it by tiping into the Name param : "A.B"

For CSV, the column name is setted on the first line.

For XML, is is like JSON, you will have to type A.B to access the B content in this example :
.. code-block:: xml
	
	<A>
	
		<B attr="an attribute" >The content</B>
	</A>
	
	
You can also access the attribute attr by typing :
"A.B@attr"

These tips are usable for every field type