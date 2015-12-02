$(function () {
    ajaxResult = ajaxParentModeGet("services/familly_parentModeGet.php", $(".btnEdit"));
    
    dialogPasword = $("#dialogParentMode").dialog({
        autoOpen: false,
        resizable: false,
        height: 200,
        width: 400,
        modal: true,
        buttons: {
            "OK": function () {
                ajaxResult = ajaxParentModePwd("services/familly_parentModeValidatePassword.php", $("#mdpParent").val(), $(".btnEdit"), $("#modeParentMessage"));
                if (ajaxResult) {
                    $(this).dialog("close");
                }
            },
            Cancel: function () {
                $(this).dialog("close");
                $("#btnOpenDialogParentMode").show();
            }
        }
    });
    
    $("#btnOpenDialogParentMode").click(function () {
        $("#modeParentMessage").hide();
        $("#mdpParent").val("");
        dialogPasword.dialog("open");
    });
    
    $("#parentModeQuit").click(function () {
        ajaxResult = ajaxParentModeQuit("services/familly_parentModeQuit.php");
        $("#parentModeActive").hide();
        $(".btnEdit").hide();
        $(".formEdit").hide();
        $("#btnOpenDialogParentMode").show();
    });    

    function ajaxParentModePwd(url, password, btnToDisplay, errorDisplay) {
        // Ajax
        var succesAjax = false;
        $(errorDisplay).hide();
        url = url + "?password=" + password;
        var jqxhr = $.ajax({
            url: url,
            dataType: "json",
            async: false,
            context: this
        })
                .done(function (msg) {
                    console.log("done");
                    $(btnToDisplay).show();
                    $("#parentModeActive").show();
                    $("#btnOpenDialogParentMode").hide();
                    succesAjax = true;
                })
                .fail(function (msg) {
                    console.log("fail");
                    $(errorDisplay).show();
                    $(errorDisplay).text("Erreur, mot de passe invalide.");
                    $("#mdpParent").val("");
                    $(errorDisplay).show();
                    succesAjax = false;
                })
        return succesAjax;        
    }
    
    function ajaxParentModeQuit(url) {
        // Ajax
        var succesAjax = false;
        url = url;
        var jqxhr = $.ajax({
            url: url,
            dataType: "json",
            async: false,
            context: this
        })
                .done(function (msg) {
                    console.log("done");
                    succesAjax = true;
                })
                .fail(function (msg) {
                    console.log("fail");
                    alert("Problème de communication !")
                    succesAjax = false;
                })
        return succesAjax;        
    }    

    function ajaxParentModeGet(url, btnToDisplay) {
        // Ajax
        var succesAjax = false;
        url = url;
        var jqxhr = $.ajax({
            url: url,
            dataType: "json",
            async: false,
            context: this
        })
                .done(function (msg) {
                    console.log("done");
                    if (msg.parentMode) {
                        $(btnToDisplay).show();
                        $("#parentModeActive").show();
                        $("#btnOpenDialogParentMode").hide();            
                    }
                    succesAjax = true;
                })
                .fail(function (msg) {
                    console.log("fail");
                    alert("Problème de communication !")
                    succesAjax = false;
                })
        return succesAjax;        
    }

});