/// <reference path="jquery-1.5.1-vsdoc.js" />
/// <reference path="jquery.validate-vsdoc.js" />
/// <reference path="jquery-ui-1.8.11.js" />

var ButtonKeys = { "EnterKey": 13 };
var applicationPath = "";

$(document).ready(function () {

    $("#PageEditorForm").keypress(function (e) {
        if (e.which == ButtonKeys.EnterKey) {
            var defaultButtonId = $(this).attr("defaultbutton");
            $("#" + defaultButtonId).click();
            return false;
        }
    });
         })

$(document).ajaxStart(function () {
	try { window.parent.ajaxLoaderShow(); }
	catch (err) { }
});
$(document).ajaxStop(function () {
	try { window.parent.ajaxLoaderHide(); }
	catch (err) { }
});


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


function handleNewValue(selectElement) {
    var jElement = $(selectElement)
    var value = jElement.val();
    var segmentID = jElement.attr("segmentID");
    if (value == -1000) {
        //jElement.css("display", "none");
        jElement.fadeOut(200, function () {
            jElement.after("<span id='newValeOption_" + segmentID + "_div'><input onkeypress='return handleEnterButton(event);' type='text' id='newValeOption_" + segmentID + "'/><input type='button' value='Add' id='newValeOption_" + segmentID + "_button' /><input type='button' value='Cancel' id='newValeOption_" + segmentID + "_cancel'/></span>");
            $("#newValeOption_" + segmentID + "_button").click(function () { addNewValue(selectElement); });
            $("#newValeOption_" + segmentID + "_cancel").click(function () { cancelNewValue(selectElement); });
        });
    }
}

function addNewValue(selectElement) {
    var jElement = $(selectElement);
    var segmentID = jElement.attr("segmentID");
    var newValue = $("#newValeOption_" + segmentID).val();

    if (newValue.replace(/^\s+|\s+$/g, "") == "") {
        window.parent.handleError({ message: "The segment name is empty" });
        //alert("The segment name is empty");
        return;
    }
    var exist = false;
    jElement.children("option").each(function () { if (this.text.toLowerCase() == newValue.toLowerCase()) exist = true; });

    if (!exist) {
        if (applicationPath == "/")
            applicationPath = "";

        $.post(applicationPath + "Home/AddNewSegmentValue", { segmentID: segmentID, newValue: newValue }, function (data) {
        	
            $("#newValeOption_" + segmentID + "_div").remove();
            jElement.children("option[value='-1000']").remove();
            //alert(newValue + " " + data);
            //jElement.append(new Option(newValue, data, false, true));
            jElement.append("<option value='" + data + "' selected='selected'>" + newValue + "</option>");
            //jElement.append(new Option("Add New...", "-1000", false, false));
            jElement.append("<option value='" + -1000 + "'>" + "Add New..." + "</option>");
            jElement.fadeIn(200);
           }).fail(window.parent.handleError);
    }
    else {
        window.parent.handleError({ message: "The segment value '" + newValue + "' already exists." });
        //alert("The segment value '" + newValue + "' already exist");
    }
}

function cancelNewValue(selectElement) {
    var jElement = $(selectElement);
    var segmentID = jElement.attr("segmentID");
    $("#newValeOption_" + segmentID + "_div").remove();
    jElement.val(jElement.attr("originalValue"));
    jElement.fadeIn(200);
}

function handleEnterButton(event) {
    var keyCode = ('which' in event) ? event.which : event.keyCode;
    if (keyCode == "13") {
        return false;
    }
    else
        return true;
}