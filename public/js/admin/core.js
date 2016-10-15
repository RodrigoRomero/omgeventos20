$(function() {
   init();
});


function init() {
	$('.toggle-nav').click(function(e) {
        e.preventDefault();
        hideNav();
    });

	if ($("#content").hasClass("nav-hidden")) {
	    hideNav();
	}

    $(".gototop").click(function(e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
    });
}

function hideNav() {
    $("#left").toggle().toggleClass("forced-hide");
    if ($("#left").is(":visible")) {
        $("#main").css("margin-left", $("#left").width());
    } else {
        $("#main").css("margin-left", 0);
    }
  /*
    if ($('.dataTable').length > 0) {
        var table = $.fn.dataTable.fnTables(true);
        if (table.length > 0) {
            $(table).each(function() {
                if ($(this).hasClass("dataTable-scroller")) {
                    $(this).dataTable().fnDraw();
                }
                $(this).css("width", '100%');
            });
            $(table).dataTable().fnAdjustColumnSizing();
        }
    }
  
    if ($(".calendar").length > 0) {
        $(".calendar").fullCalendar("render");
    }
    */
}    