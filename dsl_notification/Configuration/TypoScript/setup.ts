

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

page.includeJS.dslnotifications = EXT:dsl_notification/Resources/Public/JavaScript/jquery.colorbox-min.js

#page.includeJS.dslnotifications = EXT:dsl_notification/Resources/Public/js/notifications.js
page {
	#inlineLanguageLabelFiles {
	#	# Include inline-languages
	#	tx_libjquerycolorbox = EXT:lib_jquery_colorbox/Resources/Private/Language/locallang.xlf
	#}
	#includeCSS {
	#	# Add CSS for colorbox-theme
	#	lib_jquery_colorbox = EXT:lib_jquery_colorbox/Resources/Public/Css/colorbox.css
	#	lib_jquery_colorbox_theme = EXT:lib_jquery_colorbox/Resources/Public/Css/colorbox-theme.css
	#}
	includeJSFooterlibs {
		#lib_jquery_colorbox = EXT:lib_jquery_colorbox/Resources/Public/JavaScript/jquery.colorbox.min.js
		#lib_jquery_colorbox {
		#	disableCompression = 1
		#	forceOnTop = 1
		#}
		# Map inline languages to colorbox
		#lib_jquery_colorbox_i18n = EXT:lib_jquery_colorbox/Resources/Public/JavaScript/jquery.colorbox-i18n.min.js
		#lib_jquery_colorbox_i18n {
		#	disableCompression = 1
		#}
		# Add custom colorbox-script
		lib_jquery_dsl_notification = {$plugin.tx_dslnotification.settings.customScript}
		lib_jquery_dsl_notification {
			disableCompression = 1
		}
	}
}
