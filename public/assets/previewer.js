$(document).ready(function(){
    $("#btn_preview").on('click', function(event){
        event.preventDefault();
        showPreview();
    });
    $("#btn_save").on("click", function(event){
        if (confirm("Сохранить задачу?")) {
            $("#frm_newTask").submit();
        }
    });

    function showPreview()
    {
        $("#btn_save").prop("disabled", true);
        $("#btn_closeModal").on("click", function(event){
            hidePreview();
        });
        $("#btn_modal-save").on("click", function(event){
            hidePreview();
            $("#frm_newTask").submit();
        });
        $("#btn_modal-cancel").on("click", function(event){
            hidePreview();
        });
        var task = {
            "user_name": $("#fld_user_name").val(),
            "user_email": $("#fld_user_email").val(),
            "description": $("#fld_description").val(),
            "image": $("#fld_image").val()
        };
        var headerColumns = ['Имя пользователя', 'E-mail', 'Описание', 'Изображение'];
        $("#modal-body").empty();
        $("#modal-body").append(createPreviewTable(headerColumns, task));
        $("#preview_modal").css("display", "block");
    }

    function createPreviewTable(headerColumns, task)
    {
        var table = $("<table></table>");
        var tHead = $("<thead></thead>");
        var tBody = $("<tbody></tbody>");
        var th = $("<th></th>");
        var tr = $("<tr></tr>");
        var td = $("<td></td>");
        var header = tr.clone();
        headerColumns.forEach(function(h){
            header.append(th.clone().text(h));
        });
        table.append(tHead.append(header));
        var row = tr.clone();
        row.append(td.clone().text(task.user_name));
        row.append(td.clone().text(task.user_email));
        row.append(td.clone().text(task.description));
        var image = $("<img />");
        var im = new Image;
        image.prop("alt", "Task image");
        var imageFiles = $("#fld_image").prop("files");
        var imageSrc = "/assets/no_image.jpg";
        image.prop("src", imageSrc);
        if (imageFiles && imageFiles[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function(e){
                im.src = e.target.result;
                im.onload = function()
                {
                    var neededWidth = 320;
                    var neededHeight = 240;
                    var currentWidth = im.width;
                    var currentHeight = im.height;
                    if (currentWidth > currentHeight) {
                        if (currentWidth > neededWidth) {
                            currentHeight *= neededWidth / currentWidth;
                            currentWidth = neededWidth;
                        }
                    } else {
                        if (currentHeight > neededHeight) {
                            currentWidth *= neededHeight / currentHeight;
                            currentHeight = neededHeight;
                        }
                    }

                    var canvas = $("<canvas/>")
                    .width(currentWidth)
                    .height(currentHeight);
                    var ctx = canvas[0].getContext("2d");

                    ctx.drawImage(this, 0, 0, currentWidth, currentHeight);
                    var dataURL = canvas[0].toDataURL("image/jpeg");
                    image.prop("src", dataURL);
                }
            };
            fileReader.readAsDataURL(imageFiles[0]);
        }
        row.append(td.clone().append(image));
        tBody.append(row);
        table.append(tBody);
        return table;
    }

    function hidePreview()
    {
        $("#modal-body").empty();
        $("#preview_modal").css("display", "none");
        $("#btn_save").prop("disabled", false);
    }
});