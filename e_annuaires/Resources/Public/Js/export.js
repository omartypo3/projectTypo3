$(document).ready(function() {

    $('#export_zip').click(function(e) {
        e.preventDefault();

        var searchArgumentsAll = getSearchArguments();
        var sorting = getSorting();
        if ($('.dataTables_empty').length != 1) {
            $.ajax({
                url: 'TYPO3.settings.ajaxUrls["eannuaires_conf"]Offres',
                type: 'POST',
                dataType: "json",
                data: {
                    request: searchArgumentsAll,
                    action: 'export',
                    settings: settingsForCandidatures,
                    sorting: sorting
                },
                success: function (data) {
                    var a =  $("<a />");
                    a.attr({
                        "href": data,
                        "download": "export_candidatures.zip"
                    });
                    $("body").append(a);
                    a[0].click();
                    $.ajax({
                        url: 'TYPO3.settings.ajaxUrls["eannuaires_conf"]Offres',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            request: data,
                            action: 'delete',
                            settings: settingsForCandidatures,
                        },
                        success: function (data) {
                            console.log('files deleted');
                        }
                    });
                },
                error: function (error) {
                    console.log(error);
                }
            });
            console.log('searchArgumentsAll : ' + searchArgumentsAll);
        } else {
            alert('Votre recherche ne contient pas de résultats, vous ne pouvez pas faire d\'import !');
        }
     });

    function getSearchArguments(){

        var searchArgumentsAll = [];
        var searchArguments = '';
        var valueLabel = '';
        var value = '';
        var key = '';

        $('.filter_column').each(function (i) {
            if ($(this).find('select')) {
                value = '';
                searchArguments = '';
                value = $(this).find(":selected").text();
                key = $(this).find("option.search_init").text();
                if (key != '' && key != value) {
                    $('td').each(function (j) {
                        if (i == j) {
                            searchArguments = $(this).data('field') + '=' + $(this).data('uid') + ';' + $(this).data('type');
                        }
                    });
                }
            }
            if ($(this).find('input[type=text]').val() !== undefined) {
                valueLabel = $(this).find('input[type=text].search_init').val();
                value = '';
                searchArguments = '';
                value = $(this).find('input[type=text]').val();
                $('td').each(function (j) {
                    if (i == j && value !== 'Date' && value !== 'Nom' && value !== 'Code postal' && value !== 'Chargé de recrutement') {
                        searchArguments = $(this).data('field') + '=' + value + ';' + $(this).data('type');
                    }
                });
            }
            searchArgumentsAll.push(searchArguments);
        });
        return searchArgumentsAll;
    }

    function getSorting() {

        var sorting = '';

        $('thead th').each(function (i) {
            if($(this).hasClass('sorting_desc')) {
                $('td').each(function (j) {
                    if (i == j) {
                        sorting = $(this).data('field')+' = DESC';
                    }
                });
            }
            if($(this).hasClass('sorting_asc')) {
                $('td').each(function (j) {
                    if (i == j) {
                        sorting = $(this).data('field')+' = ASC';
                    }
                });
            }
        });

        return sorting;
    }
});