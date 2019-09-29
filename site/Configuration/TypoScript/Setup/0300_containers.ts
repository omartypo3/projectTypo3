tt_content.gridelements_pi1.20 = COA
tt_content.gridelements_pi1.20.10.setup {
    1 < lib.gridelements.defaultGridSetup
    1 {
        prepend = COA
        prepend{
            10 = TEXT
            10{
                if.isTrue.field = flexform_accordion
                wrap = <div class="container-fluid"><div class="row">|
            }
            20 = TEXT
            20{
                if.isTrue.field = flexform_accordion
                if.negate = 1
                wrap = <div class="container"><div class="row">|
            }
        }
        columns {
            4 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }

                wrap = <div class="col-md-6">|</div>
            }

            5 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }

                wrap = <div class="col-md-6">|</div>
            }
        }
        wrap = |</div></div>

    }

    2 < lib.gridelements.defaultGridSetup
    2 {
        prepend = COA
        prepend{
            10 = TEXT
            10{
                if.isTrue.field = flexform_accordion
                wrap = <div class="container-fluid"><div class="row">|
            }
            20 = TEXT
            20{
                if.isTrue.field = flexform_accordion
                if.negate = 1
                wrap = <div class="container"><div class="row">|
            }
        }
        columns {
            1 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-12">|</div>
            }
        }
        wrap = |</div></div>
    }

    3 < lib.gridelements.defaultGridSetup
    3 {
        prepend = COA
        prepend{
            10 = TEXT
            10{
                if.isTrue.field = flexform_accordion
                wrap = <div class="container-fluid"><div class="row">|
            }
            20 = TEXT
            20{
                if.isTrue.field = flexform_accordion
                if.negate = 1
                wrap = <div class="container"><div class="row">|
            }
        }
        columns {

            6 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-3">|</div>
            }

            7 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-3">|</div>
            }

            8 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-3">|</div>
            }

            9 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-3">|</div>
            }
        }
        wrap = |</div></div>
    }
    4 < lib.gridelements.defaultGridSetup
    4 {
        prepend = COA
        prepend{
            10 = TEXT
            10{
                if.isTrue.field = flexform_accordion
                wrap = <div class="container-fluid"><div class="row">|
            }
            20 = TEXT
            20{
                if.isTrue.field = flexform_accordion
                if.negate = 1
                wrap = <div class="container"><div class="row">|
            }
        }
        columns {
            10 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-4">|</div>
            }

            11 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-4">|</div>
            }

            12 {
                renderObj = COA
                renderObj {
                    20 =< tt_content
                }
                wrap = <div class="col-md-4">|</div>
            }


        }
        wrap = |</div></div>

    }
}