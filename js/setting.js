
$("#password").validate({
    onkeyup: false,
    onclick: false,
    rules: {
        current: {
            required: true,
            checkPassword: true
        },
        new: {
            required: true
        },
        repeat: {
            required: true,
            equalTo: "#new"      
        },
    },
    //For custom messages
    messages: {
        current:{
            required: "Enter your current password"
            
        },
        new:{
            required: "Enter a new password"
        },
        repeat:{
            required: "Confirm your new password",
            equalTo: "Password doesn't match"
        },

    },

    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
 });

$.validator.addMethod("checkPassword", 
    function(value, element) {
        var re = false;
        $.ajax({
            type:"GET",
            async: false,
            url: "validation/checkPassword.php", // script to validate in server side
            data: {'password': value},
            success: function(res) {
                if(res == "true")
                {
                    re = true;    
                }
                else
                {
                    re = false;
                }
            }
        });
        // return true if username is exist in database
        return re; 
    }, 
    "Incorrect Password"
);

