/// <reference path="jquery-1.5.1-vsdoc.js" />
/// <reference path="jquery.validate-vsdoc.js" />
/// <reference path="jquery-ui-1.8.11.js" />

var ButtonKeys = { "EnterKey": 13 };

$(document).ready(function () {

    $("#PageEditorForm").keypress(function (e) {
        if (e.which == ButtonKeys.EnterKey) {
            var defaultButtonId = $(this).attr("defaultbutton");
            $("#" + defaultButtonId).click();
            return false;
        }
    });

})

function selectRow(gk, multiple) {
    if (!multiple)
        $(".IndexTableRow.selected").removeClass("selected");
    $("#IndexTableRow_" + gk).addClass("selected");
}

function getBrowserHeight() {
    var intH = 0;
    var intW = 0;

    if (typeof window.innerWidth == 'number') {
        intH = window.innerHeight;
        intW = window.innerWidth;
    }
    else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        intH = document.documentElement.clientHeight;
        intW = document.documentElement.clientWidth;
    }
    else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        intH = document.body.clientHeight;
        intW = document.body.clientWidth;
    }

    return { width: parseInt(intW), height: parseInt(intH) };
}
function isNumber(num) {
    return (typeof num == 'string' || typeof num == 'number') && !isNaN(num - 0) && num !== '';
};


function openController(width, height) {

    var h;

    if (height == 0)
        h = getBrowserHeight().height-100;
    else
        h = height;

    var w = getBrowserHeight().width;


    $('#ControllerDialogDiv').css("height", h);
    $('#ControllerDialogDiv').css("display", "block");
    $('#ControllerDialogDiv').css("width", width);

    $('#ScreenOverlay').css("width", w);
    $('#ScreenOverlay').css("height", getBrowserHeight().height);
    $('#ScreenOverlay').css("display", "block");
    $('#ScreenOverlay').css("z-index", 1000);
}

function closeControllerDialog() {
    $('#ControllerDialogDiv').css("display", "none");
    $('#ScreenOverlay').css("display", "none");
    $('#ScreenOverlay').css("z-index", -1000);
}


function ShowLoadingMessage() {
    $('#ScreenOverlay').css("width", getBrowserHeight().width);
    $('#ScreenOverlay').css("height", getBrowserHeight().height);
    $('#ScreenOverlay').css("display", "block");
    $('#ScreenOverlay').css("z-index", 1000);

    $('#LoadingMessage').css("display", "block");
}

function HideLoadingMessage() {
    $('#ScreenOverlay').css("display", "none");
    $('#ScreenOverlay').css("z-index", -1000);

    $('#LoadingMessage').css("display", "none");
}