plugin.tx_site_frontend {
    view {
        templateRootPaths.0 = EXT:site/Resources/Private/Templates/
        partialRootPaths.0 = EXT:site/Resources/Private/Partials/
        layoutRootPaths.0 = EXT:site/Resources/Private/Layouts/
    }

    settings {
        logoImagePath = typo3conf/ext/site/Resources/Public/Img/logo/eintracht_logo.png
        logoImageSignet = typo3conf/ext/site/Resources/Public/Img/logo/eintracht_signet.png
        placeholderVideo = typo3conf/ext/site/Resources/Public/img/video/video-placeholder.png
        Videosgeagles = typo3conf/ext/site/Resources/Public/img/video/thereturn.mp4
        Videointro = typo3conf/ext/site/Resources/Public/img/video/thereturn.mp4
        BuildingBridgesStandbild = typo3conf/ext/site/Resources/Public/img/video/video-placeholder.png
        quote = typo3conf/ext/site/Resources/Public/img/svg/quote.svg
        footerPageUid = 7
        footerNaviPageUid = 8
        placeholderVideocontent = fileadmin/user_upload/img/video/video-placeholder-content.png
        academyTvLogo = fileadmin/user_upload/img/svg/eintracht_tv_logo.svg
        slantvdesktop = typo3conf/ext/site/Resources/Public/img/svg/slant_v_desktop.svg
        slantvmobile = typo3conf/ext/site/Resources/Public/img/svg/slant_v_mobile.svg
        slantupdesktop = typo3conf/ext/site/Resources/Public/img/svg/slant_up_black_desktop.svg
        slantupmobile = typo3conf/ext/site/Resources/Public/img/svg/slant_up_black_mobile.svg
        textlink = typo3conf/ext/site/Resources/Public/img/svg/textlink.svg
        slantdowndesktop = typo3conf/ext/site/Resources/Public/img/svg/slant_down_white_desktop.svg
        slantdownmobile = typo3conf/ext/site/Resources/Public/img/svg/slant_down_white_mobile.svg
        sgeagles-bg = fileadmin/user_upload/img/background/bg_partnersprojects.jpg
        favicon = fileadmin/user_upload/img/logo/favicon.ico
        maxCharacters = 15
    }
}

# cat=template/seiten/; type=links; label= Sprachen IDs: EN:0,FR:1,JP:2,CN:3,AR:4,DE:5 (Setzen Sie ein Komma zwischen die IDs)
plugin.tx_site_frontend.settings.language = 0,1,2,3,4,5
