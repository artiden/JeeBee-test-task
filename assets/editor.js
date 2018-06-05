$(document).ready(function(){
    $(".edit-task").on("click", function(event){
        var taskId = $(this).data("task-id");
        var description = $(this).data("task-description");
        edit(taskId, description);
    });
    $(document).on("click", ".js-close-edit", function(event){
        hideEditBox();
    });

    $("#btn_edit-save").on("click", function(event){
        $("#frm_edit").submit();
    });

    function edit(id, description)
    {
        $("#fld_task-id").val(id);
        $("#fld_edit-description").val(description);
        showEditBox();
    }

    function showEditBox()
    {
        $("#edit-box").css("display", "block");
    }

    function hideEditBox()
    {
        $("#edit-box").css("display", "none");
        $("#frm_edit")[0].reset();
    }
});

