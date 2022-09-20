$(document).ready(function(){
    
    $(".chat-form").keypress(function(e){
        if(e.keyCode == 13){
                var send_message = $("#send_message").val();
                if(send_message.length != ""){
                    $.ajax({
                        type : 'POST',
                        url : 'ajax/send_message.php',
                        data : {send_message:send_message},
                        dataType : 'JSON',
                        success : function(feedback){
                            if(feedback.status == "success"){
                                $(".chat-form").trigger("reset");
                                show_messages();
                                $(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, 1000);
                            }
                        }
                    });
                }
           }
    });
//    Upload Images And Files
    
    $("#upload-files").change(function(){
        var file_name = $("#upload-files").val();
        if(file_name.length != ""){
            $.ajax({
                type : 'POST',
                url : 'ajax/send_files.php',
                data : new FormData($(".chat-form")[0]),
                contentType : false,
                processData : false,
                success : function(feedback){
                    if(feedback == "error"){
                        $(".files-error").show();
                        $(".files-error").html('<span>' + 'not a valid file extension' + '</span><span class="files-cross-icon">&#x2715;</span>');
                        setTimeout(function(){
                            $(".files-error").hide();
                        }, 3000);
                    }else if(feedback == "success"){
                        show_messages();
                        $(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, 2000);
                    }
                }
            });
        }
    });
//    Send Emojies
    
    $(".emoji-same").click(function(){
        var emoji = $(this).attr("src");
        $.ajax({
            type : 'POST',
            url : 'ajax/send_emoji.php',
            data : {'send_emoji':emoji},
            dataType : 'JSON',
            success : function(feedback){
                if(feedback.status == "success"){
                    show_messages();
                    $(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, 2000);
                }
            }
        });
    });
    
    var clean = 1;
   
    $(".clean").click(function(){
        $.ajax({
            type : 'POST',
            url : 'ajax/clean.php',
            data : {'clean': clean},
            dataType : 'json',
            success : function(feedback){
                if(feedback['status'] == 'clean'){
                    show_messages();
                }
            }
            
        });
    });
    
   online_users(); 
   setInterval(function(){
       show_messages();
       online_users();
   },3000);
    
    
    setInterval(function(){
       users_status();
    },300000);
    
    
});
//Display online users
function online_users(){
    $.ajax({
        type : 'GET',
        url : 'ajax/online_users.php',
        dataType : 'JSON',
        success : function(feedback){
            if(feedback['users'] == 1){
                $(".online_users").html("<span class='show-online'></span> "+"Just You");
            }else{
                $(".online_users").html("<span class='show-online'></span>Online " + feedback['users']);
            }
            
            
            
        }
        
    });
}


//Check user login time
function users_status() {

	$.ajax({
		type : 'GET',
		url  : 'ajax/users_status.php',
		dataType : 'JSON',
		success : function(feedback) {
			if(feedback['status'] == "href"){
				window.location = "login.php";
			}

		}
	})

}



//Show messages from database
function show_messages(){
    
    var msg = true;
    
    $.ajax({
        type : 'GET',
        url : 'ajax/show_messages.php',
        data : {'message': msg},
        
        success : function(feedback){
            $(".messages").html(feedback);
        }
    });
}



show_messages();


setTimeout(function(){
    $(".messages").animate({scrollTop: $(".messages")[0].scrollHeight}, 100);
}, 1000);


