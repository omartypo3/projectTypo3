
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
plugin.tx_dslnotification {
	settings {
	   # cat=dsl-notification//1; type=string; label=Use custom script
	   customScript = EXT:dsl_notification/Resources/Public/JavaScript/notifications.js
	}
}