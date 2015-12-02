$(document).ready(function () {
    $(".formEdit").hide();
    $(".errorDisplay").hide();
    $("#parentModeActive").hide();
    $(".btnEdit").hide();

    $(".btnEdit").click(function () {
        child = $(this).closest(".child");
        $(this).hide();
        $(child).find(".inputTxtPoints").val("");
        $(child).find(".formEdit").show();
    });

    $(".btnSave").click(function () {
        child = $(this).closest(".child");
        
        ajaxResult = ajaxAddPoints("services/child_addPoints.php", $(child).find(".inputTxtPoints").val(), 
            $(child).find(".firstName").text(), 
            $(child).find(".points"),
            $(child).find(".errorDisplay"));
        if (ajaxResult) {
            $(child).find(".formEdit").hide();
            $(child).find(".btnEdit").show();
        }
    });
    
    function ajaxAddPoints(url, points, firstName, pointsDisplay, errorDisplay) {
        // Ajax
        var succesAjax = false;
        $(errorDisplay).hide();
        url = url + "?points=" + points + "&firstName=" + firstName;
        var jqxhr = $.ajax({
            url: url,
            dataType: "json",
            async: false,
            context: this
        })
                .done(function (msg) {
                    console.log("done");
                    $(pointsDisplay).text(msg.points);
                    succesAjax = true;
                })
                .fail(function (msg) {
                    console.log("fail");
                    $(errorDisplay).show();
                    //console.log(msg);
                    //console.log("error " + msg.responseJSON.messageErreur);
                    //alert(msg.responseJSON.messageErreur);
                    succesAjax = false;
                })
        return succesAjax;
    }
});