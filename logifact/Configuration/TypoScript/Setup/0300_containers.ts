tt_content.gridelements_pi1.20 = COA
tt_content.gridelements_pi1.20.10.setup {
    1 < lib.gridelements.defaultGridSetup
    1 {
        columns {
            4 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }

                wrap = <div class="col0">|</div>
            }

            5 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }

                wrap = <div class="col1">|</div>
            }
        }

        dataWrap >
        dataWrap (
            <div  class="element_kontakt_kontaktformular" id="c{field:uid}"><h1 class="csc-firstHeader">{field:header}</h1>|</div>
    )

        dataWrap.override.if.isTrue.field = show_header
        dataWrap.override (
            <div  class="element_kontakt_kontaktformular" id="c{field:uid}">|</div>
    )
    }

    2 < lib.gridelements.defaultGridSetup
    2 {
        dataWrap >
        dataWrap (
            <div id="c{field:uid}"><h1 class="csc-firstHeader">{field:header}</h1>|</div>
    )

        dataWrap.override.if.isTrue.field = show_header
        dataWrap.override (
            <div id="c{field:uid}">|</div>
        )
        columns {
            1 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
            }
        }
    }

    3 < lib.gridelements.defaultGridSetup
    3 {
        dataWrap >
        dataWrap (
            <h1 class="csc-firstHeader">{field:header}</h1><div id="c{field:uid}" class="element2cols">|</div>
    )

        dataWrap.override.if.isTrue.field = show_header
        dataWrap.override (
            <div id="c{field:uid}" class="element2cols">|</div>
    )
        columns {
            6 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col00">|</div>
                }
                wrap = <div class="col0">|</div>
            }

            7 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col4">|</div>
                }
                wrap = <div class="col4">|</div>
            }

            8 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col8">|</div>
                }
                wrap = <div class="col8">|</div>
            }

            9 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col12">|</div>
                }
                wrap = <div class="col12">|</div>
            }
        }
    }
    4 < lib.gridelements.defaultGridSetup
    4 {
        dataWrap >
        dataWrap (
            <h1 class="csc-firstHeader">{field:header}</h1><div id="c{field:uid}" class="element_3spaltig">|</div>
    )

        dataWrap.override.if.isTrue.field = show_header
        dataWrap.override (
            <div id="c{field:uid}" class="element_3spaltig">|</div>
    )
        columns {
            10 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col0">|</div>
                }
                wrap = <div class="col0">|</div>
            }

            11 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col1">|</div>
                }
                wrap = <div class="col1">|</div>
            }

            12 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                    #20.stdWrap.innerWrap = <div class="col2">|</div>
                }
                wrap = <div class="col2">|</div>
            }


        }
    }
}