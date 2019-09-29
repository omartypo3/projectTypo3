$(document).ready(function() {
  $(".catfilter").click(function(e) {
    var catid = $(this).data("catid");
    ajaxcall(catid, e);
  });
});

$(window).load(function(e) {
  id = getQueryVariable("catid");
  if (id != false) {
    ajaxcall(id, e);
  }
});

function toggledmenu(toggled) {
  if ($(toggled).hasClass("active")) {
    $(toggled).removeClass("active");
    $(toggled)
      .siblings()
      .removeClass("active");
  } else {
    $(toggled)
      .siblings()
      .removeClass("active");
    $(toggled).addClass("active");
  }
  var target = $(toggled).attr("data-target");
  console.log(target);
  if ($("#" + target).hasClass("opened")) {
    setTimeout(function() {
      $("#" + target).removeClass("opened");
    }, 500);
  } else {
    $(".toggle-menu-item").removeClass("opened");
    setTimeout(function() {
      $("#" + target).addClass("opened");
    }, 400);
  }
}

function ajaxcall(catid, e) {
  e.preventDefault();
  var url1 = $("#url1").data("url");
  var allData = {
    "tx_silcoplastproduct_silcoplastproduct[catid]": catid
  };
  $.ajax({
    type: "POST",
    url: url1,
    data: allData,
    success: function(data) {
      $(".produktion-content").empty();
      $(".produktion-content").html(data);
      $(".toggle-menu-item ul").each(function() {
        $(this)
          .find("a")
          .on("click", function(e) {
            var catid = $(this).data("catid");
            if (catid) {
              ajaxcall(catid, e);
            }
          });
      });
    },
    error: function(jqXHR, textStatus, errorThrow) {
      console.log(errorThrow);
    }
  });
}

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  }
  return false;
}
