lib.absoluteUri = TEXT
lib.absoluteUri {
	typolink {
		parameter.cObject = TEXT
		parameter.cObject {
			field = parameter
			# Check ext_linkhandler.ts TypoScript configuration, and ext_linkhandler.ts TSConfig
			replacement {
				10 {
					search = #(identifier=)(actualites|agenda)#i
					replace = ${1}${2}UriOnly || ${1}${3}UriOnly
					useRegExp = 1
					useOptionSplitReplace = 1
				}
			}
		}
		forceAbsoluteUrl = 1
		returnLast = url
	}
}