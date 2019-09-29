lib.contentElement {
    templateRootPaths {
        10 = EXT:logifact/Resources/Private/FluidStyledContent/Templates/
    }

    partialRootPaths {
        10 = EXT:logifact/Resources/Private/FluidStyledContent/Partials/
    }

    layoutRootPaths {
        10 = EXT:logifact/Resources/Private/FluidStyledContent/Layouts/
    }

    settings < plugin.tx_logifact.settings
    # for <f:translate>

    extbase.controllerExtensionName = logifact
}

lib.dataProcessor.slide = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.slide {
    table = tx_logifact_slide
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

        15 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        15 {
            references.fieldName = buttonimage
            as = button
        }
    }
}

lib.dataProcessor.camaliga = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.camaliga {
    table = tx_logifact_camaliga
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

lib.dataProcessor.opinion = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.opinion {
    table = tx_logifact_opinion
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = opinion
}

lib.dataProcessor.tab = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.tab {
    table = tx_logifact_tab
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = tabs
}

lib.dataProcessor.bigTeaser = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.bigTeaser {
    table = tx_logifact_teaser_big
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = teasers

    dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }

        15 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
        15 {
            table = tx_logifact_link
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

lib.dataProcessor.services = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.services {
    table = tx_logifact_service
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = services

    dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.products = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.products {
    table = tx_logifact_product
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = products

    dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.cobraProduct = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.cobraProduct {
    table = tx_logifact_cobra_product
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = products

    dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.team = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.team {
    table = tx_logifact_team
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = team_members

    dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = image
        }
    }
}

lib.dataProcessor.file_tab = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.file_tab {
    table = tx_logifact_file_tab
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = tab

    dataProcessing {
        15 < lib.dataProcessor.camaliga
    }
}

lib.dataProcessor.footer_button = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
lib.dataProcessor.footer_button {
    table = tx_logifact_footer_button
    pidInList.field = pid

    where {
        data = field:uid
        wrap = parent_uid = |
    }

    orderBy = sorting
    as = buttons
}

tt_content {
    #--------------------------------------------------
    # add custom elements
    #--------------------------------------------------

    logifact_hero_element < lib.contentElement
    logifact_hero_element {
        templateName = Logifact_HeroElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = media
            }
        }
    }

    logifact_camaliga_slider_element < lib.contentElement
    logifact_camaliga_slider_element {
        templateName = Logifact_CamaligaElement.html
        dataProcessing {
            30 < lib.dataProcessor.camaliga
        }
    }

    logifact_slider_element < lib.contentElement
    logifact_slider_element {
        templateName = Logifact_SliderElement.html
        dataProcessing {
            10 < lib.dataProcessor.slide
        }
    }

    logifact_opinion_element < lib.contentElement
    logifact_opinion_element {
        templateName = Logifact_CustomerOpinionSliderElement.html
        dataProcessing {
            30 < lib.dataProcessor.opinion
        }
    }

    logifact_tabs_element < lib.contentElement
    logifact_tabs_element {
        templateName = Logifact_TabsElement.html
        dataProcessing {
            30 < lib.dataProcessor.tab
        }
    }

    logifact_teaser_big_element < lib.contentElement
    logifact_teaser_big_element {
        templateName = Logifact_BigTeaserElement.html
        dataProcessing {
            30 < lib.dataProcessor.bigTeaser
        }
    }

    logifact_network_service_element < lib.contentElement
    logifact_network_service_element {
        templateName = Logifact_NetworkServiceElement.html
    }

    logifact_software_solutions_element < lib.contentElement
    logifact_software_solutions_element {
        templateName = Logifact_SoftwareSolutionsElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }

            15 = TYPO3\CMS\Frontend\DataProcessing\DatabaseQueryProcessor
            15 {
                table = tx_logifact_link
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

    logifact_services_element < lib.contentElement
    logifact_services_element {
        templateName = Logifact_ServicesElement.html
        dataProcessing {
            30 < lib.dataProcessor.services
        }
    }

    logifact_product_element < lib.contentElement
    logifact_product_element {
        templateName = Logifact_ProductsElement.html
        dataProcessing {
            30 < lib.dataProcessor.products
        }
    }

    logifact_training_element < lib.contentElement
    logifact_training_element {
        templateName = Logifact_TrainingElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }

    logifact_support_element < lib.contentElement
    logifact_support_element {
        templateName = Logifact_SupportElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }

    logifact_cobra_element < lib.contentElement
    logifact_cobra_element {
        templateName = Logifact_CobraElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }

    logifact_cobra_products_element < lib.contentElement
    logifact_cobra_products_element {
        templateName = Logifact_CobraProductsElement.html
        dataProcessing {
            30 < lib.dataProcessor.cobraProduct
        }
    }

    logifact_team_element < lib.contentElement
    logifact_team_element {
        templateName = Logifact_TeamElement.html
        dataProcessing {
            30 < lib.dataProcessor.team
        }
    }

    logifact_file_tabs_element < lib.contentElement
    logifact_file_tabs_element {
        templateName = Logifact_FileTabsElement.html
        dataProcessing {
            30 < lib.dataProcessor.file_tab
        }
    }

    logifact_header_text_element < lib.contentElement
    logifact_header_text_element {
        templateName = Logifact_HeaderTextElement.html
    }

    logifact_teaser_element < lib.contentElement
    logifact_teaser_element {
        templateName = Logifact_TeaserElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = image
            }
        }
    }
    logifact_download_element < lib.contentElement
    logifact_download_element {
        templateName = Logifact_DownloadElement.html
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
            10 {
                references.fieldName = media
            }
        }
    }
    logifact_footer_buttons_element < lib.contentElement
    logifact_footer_buttons_element {
        templateName = Logifact_FooterButtonsElement.html
        dataProcessing {
            30 < lib.dataProcessor.footer_button
        }
    }
}


