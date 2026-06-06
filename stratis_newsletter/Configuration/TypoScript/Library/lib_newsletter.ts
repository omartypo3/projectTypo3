[page | tx_fed_page_controller_action = Stratis.StratisNewsletter->newsletter]
	stratis.var.isNewsletterArchives = 1
	config.spamProtectEmailAddresses = 0
	config.tx_cooluri_enable = 0
	config.removeDefaultCss = 1
	config.removeDefaultJS = 1
	page.includeCSS >
	page.includeJSFooter >
	page.includeJSFooterlibs >
	page.jsFooterInline >
	page.javascriptLibs >
	page.3132 >
	page.headerData >
	page.meta >
	plugin.tx_cssstyledcontent._CSS_DEFAULT_STYLE >
	plugin.tx_irretutorial._CSS_DEFAULT_STYLE >
	plugin.tx_news.settings.ignoreStartEndtime = 1

[page | tx_fed_page_controller_action = Stratis.StratisNewsletter->newsletter] && [globalVar = TSFE : beUserLogin =]
	tt_content.stdWrap.dataWrap >
	tt_content.stdWrap.editPanel = 0
	tt_content.stdWrap.editPanel >
	tt_content.stdWrap.editPanel.allow =
[global]
