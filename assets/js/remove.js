$(document).ready(function(){
    $(".remove").click(function(){
       $(".flash").fadeOut(400); 
    });
     $("body").click(function(){
       $(".flash").fadeOut(400); 
    });
    setTimeout(function(){
       $(".flash").fadeOut(400);
    }, 5000);
    
    $(document).on("change", ".change-img", function(){
       var image_name = $(".change-img").val(); 
        var file = image_name.split("\\").pop();
        $("#change-image-label").html(file);
    });
    
});