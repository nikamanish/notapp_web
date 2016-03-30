$("#formValidate").validate({
    rules: {
        
        title: {
            required: true
        },
        
        
    },
    //For custom messages
    messages: {
        
        title:{
            required: "Enter the title"
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