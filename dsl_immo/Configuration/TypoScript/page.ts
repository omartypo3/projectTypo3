mod.wizards.newContentElement.wizardItems {
    common {
       elements {    
        immosearch {
            title = DSL factory Immobiliensuche
            description = Suchformular für die Suche in den Immobilien
	    iconIdentifier = content-special-html
            
            tt_content_defValues {
                CType = list
                list_type = dslimmo_immosearch
                }
            }
        }
    show := addToList(immosearch)
    }
}