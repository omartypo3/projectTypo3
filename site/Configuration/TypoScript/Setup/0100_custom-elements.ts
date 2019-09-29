lib.contentElement {
    templateRootPaths {
        10 = EXT:site/Resources/Private/FluidStyledContent/Templates/
    }

    partialRootPaths {
        10 = EXT:site/Resources/Private/FluidStyledContent/Partials/
    }

    layoutRootPaths {
        10 = EXT:site/Resources/Private/FluidStyledContent/Layouts/
    }

    settings < plugin.tx_site.settings
    # for <f:translate>

    extbase.controllerExtensionName = site
}

lib.dataProcessor.slide = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.slide {
    table = tx_site_slide
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = slides

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.partner = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.partner {
    table = tx_site_partner
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = partners

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
        15 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        15 {
            references.fieldName = icon
            as = icon
        }
    }
}

lib.dataProcessor.partnerfooter = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.partnerfooter {
    table = tx_site_footer
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = partnerfooters

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.row = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.row {
    table = tx_site_row
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = partnerfootersrow1

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}
lib.dataProcessor.social = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.social {
    table = tx_site_social
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = socials

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}
lib.dataProcessor.quoteslide = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.quoteslide {
    table = tx_site_quotes
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = quotes

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}
lib.dataProcessor.country = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.country {
    table = tx_site_country
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = countrys

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}
lib.dataProcessor.bigSliderOrTours = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.bigSliderOrTours {
    table = tx_site_toursorbigslider
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = toursorbigsliders

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.players = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.players {
    table = tx_site_players
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = players

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.spansors = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.spansors {
    table = tx_site_spansors
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = spansors

    #     add data processing of needed... (for images)
        dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.business = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.business {
    table = tx_site_businesslist
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = businesslists

}


tt_content {
#--------------------------------------------------
    # add custom elements
    #--------------------------------------------------


        site_intro_element < lib.contentElement
    site_intro_element {
        templateName = site_IntroElement.html
    }
    site_newsroom_element < lib.contentElement
    site_newsroom_element {
        templateName = Site_newsroomElement.html
    }
    site_whyinter_element < lib.contentElement
    site_whyinter_element {
        templateName =  Site_whyinterElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
            15 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
            15 {
                table = tx_site_link
                pidInList.field = pid

                where {
                    data = field:uid
                    wrap = parent_uid = |
                }

                orderBy = sorting
                as = links
            }
        }
    }
    site_threepillars_element < lib.contentElement
    site_threepillars_element {
        templateName =  Site_pillarsElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
            15 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
            15 {
                table = tx_site_link
                pidInList.field = pid

                where {
                    data = field:uid
                    wrap = parent_uid = |
                }

                orderBy = sorting
                as = links
            }
            20 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
            20{
                table = tx_site_radical
                pidInList.field = pid

                where {
                    data = field:uid
                    wrap = parent_uid = |
                }

                orderBy = sorting
                as = radicals
            }
            30 < lib.dataProcessor.slide
        }
    }

    site_sgeagles_element < lib.contentElement
    site_sgeagles_element {
        templateName =  Site_segeaglesElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
            #15 < lib.dataProcessor.partner
        }
    }

    site_quotes_element < lib.contentElement
    site_quotes_element {
        templateName = Site_quotesElement.html
        dataProcessing {
            10 < lib.dataProcessor.quoteslide
        }
    }
    site_footer_element < lib.contentElement
    site_footer_element {
        templateName = Site_FooterElement.html
        dataProcessing {
            10 < lib.dataProcessor.partnerfooter
            15 < lib.dataProcessor.row
            20 < lib.dataProcessor.social
        }
    }

    site_Headvisual_element < lib.contentElement
    site_Headvisual_element {
        templateName = Site_HeadvisualElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }

    site_Headvisual_element < lib.contentElement
    site_Headvisual_element {
        templateName = Site_HeadvisualElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }
    site_introContent_element < lib.contentElement
    site_introContent_element {
        templateName = Site_IntroContentElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }
    site_academy_element < lib.contentElement
    site_academy_element {
        templateName = Site_academyElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10{
                references.fieldName = media
                as = video
            }
            15 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            15 {
                references.fieldName = image
            }
        }
    }
    site_international_element < lib.contentElement
    site_international_element {
        templateName = Site_InternationalElement.html
        dataProcessing {
            10 < lib.dataProcessor.country
        }
    }
    site_toursorbigslider_element < lib.contentElement
    site_toursorbigslider_element {
        templateName = Site_bigSliderOrToursElement.html
        dataProcessing {
            10 < lib.dataProcessor.bigSliderOrTours
        }
    }
    site_players_element < lib.contentElement
    site_players_element {
        templateName = Site_PlayersElement.html
        dataProcessing {
            10 < lib.dataProcessor.players
            15 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            15 {
                references.fieldName = image
            }
        }
    }
    site_spansors_element < lib.contentElement
    site_spansors_element {
        templateName = Site_spansorsElement.html
        dataProcessing {
            10 < lib.dataProcessor.spansors
        }
    }

    site_business_element < lib.contentElement
    site_business_element {
        templateName = Site_businessElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
            10{
                table = tx_site_link
                pidInList.field = pid

                where{
                    data = field:uid
                    wrap = parent_uid =|
                }

                orderBy = sorting
                as = links
            }
            15 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            15{
                references.fieldName = image
            }
            20 < lib.dataProcessor.business

        }
    }
    site_pars_element < lib.contentElement
    site_pars_element {
        templateName = Site_PartnerElement.html
        dataProcessing {
            20 < lib.dataProcessor.partner

        }
    }
    site_youthtextbottom_element < lib.contentElement
    site_youthtextbottom_element {
        templateName = site_youthtextbottomElement.html
    }
    site_youthtext_element < lib.contentElement
    site_youthtext_element {
        templateName = site_youthtextElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10{
                references.fieldName = image
            }
        }
    }
    site_slant_element < lib.contentElement
    site_slant_element {
        templateName = site_SlantElement.html
    }
    site_video_element < lib.contentElement
    site_video_element {
        templateName = site_VideoElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10{
                references.fieldName = image
            }
            15 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            15{
                references.fieldName = media
                as = media
            }
        }
    }
    site_imagecaption_element < lib.contentElement
    site_imagecaption_element {
        templateName = site_imagecaption.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10{
                references.fieldName = image
            }
        }
    }


}





