var animate = true;

function OpenTabsJS() {
    $('#container .content').css({ opacity: 0.0 });
    $('#container .content').css("display", "none");
    $('#container .content:first').css({ opacity: 1.0 });
    $('#container .content:first').css("display", "block").fadeIn();
        

    $("#container .menu > li").click(function (e) {
        if (animate) {

            animate = false;

            $("#container ul.menu li").removeClass('active');
            $('#container .content').css({ opacity: 0.0 });
            $('#container .content').css("display", "none");
            $(this).addClass('active');
            $('div.' + String(e.target.id)).css("display", "block");
            $('div.' + String(e.target.id)).animate({ opacity: 1.0 }, 400, function () { animate = true; });
            $('div.' + String(e.target.id));

        }
    });
};