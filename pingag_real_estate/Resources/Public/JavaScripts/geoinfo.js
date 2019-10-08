'use strict';

var searchLocations = function searchLocations(obj) {
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open(obj.method || "GET", obj.url);
        if (obj.headers) {
            Object.keys(obj.headers).forEach(function (key) {
                xhr.setRequestHeader(key, obj.headers[key]);
            });
        }
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                resolve(xhr.response);
            } else {
                reject(xhr.statusText);
            }
        };
        xhr.onerror = function () {
            reject(xhr.statusText);
        };
        xhr.send(obj.body);
    });
};
$(document).ready(function () {
    autocompleteLocations();
});
$(".searchTerm").keyup(function () {
    autocompleteLocations();
});

function autocompleteLocations(tsearch) {

    var searchString = $(".searchTerm").val();
    if (tsearch != null && tsearch != "") {
        searchString = tsearch;
    }
    searchString = typeof searchString !== "undefined" && searchString != "" ? searchString : "0";

    var apiBaseUrl = 'https://api3.geo.admin.ch/rest/services/api/';
    var params = $.param({
        searchText: searchString,
        type: 'locations',
        origins: 'address'
    });
    var searchUrl = apiBaseUrl + 'SearchServer?' + params;
    searchLocations({ url: searchUrl }).then(function (data) {
        var searchedList = JSON.parse(data);
        var lists = [];
        console.log(searchedList);
        $.each(searchedList.results, function (index, value) {
            var cur_val = "<div>" + value.attrs.label + "</div>";
            var cur_val2 = $(cur_val).find('b').text();
            lists.push(cur_val2);
        });
        var selected = JSON.parse($("#recup_search").val());
        lists = unique(lists);
        if (typeof mb === "undefined" || tsearch != null) {

            var _mb = 1;
            var ms = $('#ms1').magicSuggest({
                data: lists,
                highlight: false,
                selectionContainer: $('#custom-ctn'),
                sortOrder: 'name',
                maxDropHeight: 200,
                name: 'ms1',
                allowFreeEntries: false
            });
            ms.setData(lists);
            if (selected.length != 0) {
                var lists_selected = [];
                var lists_empty = [];

                selected.forEach(function (index) {
                    lists_selected.push(index);
                });
                lists_selected.forEach(function (index) {
                    ms.setValue([index]);
                });
                $(".ms-close-btn").click(function(){
                     var txt = $(this).parent().text();
                    if(selected.length <= 1){
                        $("#recup_search").val('');
                       /* ms.clear();*/
                    }else{
                        selected.forEach(function (index) {
                            if(!(index == txt)){
                                lists_empty.push(index);
                            }
                        });
                        $("#recup_search").val(lists_empty);
                    }
                });

            }
            $(ms).off('keyup');
            //   ms.setValue($("#recup_search").val());
            $(ms).on('keyup', function (e, m, v) {
                if (v.keyCode != "38" && v.keyCode != "40") autocompleteLocations($("#ms1 input").val());
            });
        }
    }).catch(function (error) {
        console.log(error);
    });
}
function unique(list) {
    var result = [];
    $.each(list, function (i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}