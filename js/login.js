
$("#formValidate").validate({
    rules: {
        username: {
            required: true,
            email: true
            
        },
        password: {
            required: true
        },
        
    },
    //For custom messages
    messages: {
        
        username:{
            required: "Enter your email",
            email: "Enter a valid email"
        },
        password:{
            required: "Enter your password"
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