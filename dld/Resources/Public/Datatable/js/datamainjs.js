function LoadDatatable() {
    require(["/typo3conf/ext/dld/Resources/Public/Datatable/js/jquery.dataTables.js"], function () {
        /******************** home *********************/
        var table1 =TYPO3.jQuery('#hometable').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": false,
            "lengthChange": false,
            "ordering": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_home.php',
            initComplete: function () {
                 moduleToken();
            }
        } );
        table1.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** event *********************/
        TYPO3.jQuery('table#events thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        var table = TYPO3.jQuery('#events').dataTable( {
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "ordering": false,
            "searching":true,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_events.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        table.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** new event and partner *********************/
        TYPO3.jQuery(' table#partnerevent thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });
        var eventp = TYPO3.jQuery('#partnerevent').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_events_partner.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        eventp.on( 'page.dt', function () {
            moduleToken();
        } );

        /******************** edit event and partner *********************/
        TYPO3.jQuery(' table#partnereventedit thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });
        var partnereventedit = TYPO3.jQuery('#partnereventedit').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_events_partner_update.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        partnereventedit.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** sessions *********************/
        TYPO3.jQuery('table#sessions thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        var tablesessions = TYPO3.jQuery('#sessions').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_sessions.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        tablesessions.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** venues *********************/
        TYPO3.jQuery(' table#venues thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        var tablevenues = TYPO3.jQuery('#venues').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_venues.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        tablevenues.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** people *********************/
        TYPO3.jQuery(' table#people thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        var tablepeople = TYPO3.jQuery('#people').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_people.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        tablepeople.on( 'page.dt', function () {
            moduleToken();
        } );

        /******************** peoplesession *********************/
        TYPO3.jQuery(' table#peoplesession thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


       var peoplesession = TYPO3.jQuery('#peoplesession').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_sessionspeople.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        peoplesession.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** peoplesession *********************/
        TYPO3.jQuery(' table#peoplesessionupdate thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        var peoplesessionupdate = TYPO3.jQuery('#peoplesessionupdate').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_sessionspeopleupdate.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );
            }
        } );
        peoplesessionupdate.on( 'page.dt', function () {
            moduleToken();
        } );
        /******************** partners *********************/
        TYPO3.jQuery(' table#partners thead .inputs td').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });


        var tablepartners = TYPO3.jQuery('#partners').dataTable( {
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_partners.php',
            initComplete: function () {
                this.api().columns().every( function () {
                    var that = this;

                    $('input', this.header()).on('keyup change', function () {
                        moduleToken();
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                } );

            }
        } );
        tablepartners.on( 'page.dt', function () {
            moduleToken();
        } );

        /******************** settings *********************/
        var settings= TYPO3.jQuery('#settings').dataTable( {
            "processing": true,
            "serverSide": true,
             "searching": true,
             "ordering": false,
            "lengthChange": false,
            "ajax": '../typo3conf/ext/dld/Classes/Ajax/example/scripts/server_processing_settings.php',
        } );
        settings.on( 'page.dt', function () {
            moduleToken();
        } );

        /******************** Datatable 2 *********************/

        TYPO3.jQuery(' table.datatable2').DataTable(
            {
                "order": [[0, "desc"]],
                "searching": false,
                "lengthChange": false,
                "ordering": false,
                "paging": false
            }
        );



    });

    require(["/typo3/sysext/core/Resources/Public/JavaScript/Contrib/bootstrap-datetimepicker.js"], function () {
        TYPO3.jQuery("#datetimepicker1").datetimepicker({
            locale: 'de',
            sideBySide: true


        });
        TYPO3.jQuery("#datetimepicker2").datetimepicker({
            locale: 'de',
            sideBySide: true
        });
    });
}

function LoadRte() {

    require(["/typo3conf/ext/dld/Resources/Public/scripts/ckeditor/ckeditor.js"], function () {
        if ($('form[name="event"]').length) {
            CKEDITOR.replace('tx_dld_web_dlddldback[event][description]');
        }
        if ($('form[name="newEvent"]').length) {
            CKEDITOR.replace('tx_dld_web_dlddldback[newEvent][description]');
        }
        if ($('form[name="partner"]').length) {
            CKEDITOR.replace('tx_dld_web_dlddldback[partner][description]');
        }
        if ($('form[name="newPartner"]').length) {
            CKEDITOR.replace('tx_dld_web_dlddldback[newPartner][description]');
        }

    });
}

TYPO3.jQuery(document).ready(function () {
    LoadDatatable();
    LoadRte();
    moduleToken();
});


function moduleToken() {
    setTimeout(function(){
        var test = TYPO3.jQuery('.menu-dld ul li.home a').attr("href").split("=");
        var test1 = test[2].split("&");
        var code = test1[0];
        TYPO3.jQuery(".urichange").each(function(i) {
            var url = TYPO3.jQuery(this).attr("href");
            TYPO3.jQuery(this).attr("href",url.replace("xxxxxxxxxx",code));
        });

    },1000);
}
