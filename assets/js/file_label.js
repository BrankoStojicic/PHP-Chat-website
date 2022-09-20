$(document).ready(function(){
    $(document).on("change","#file", function(){
        var image_name = $("#file").val();
        $("#file_label").html(image_name);
    })
})