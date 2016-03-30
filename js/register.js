
$("#formValidate").validate({
    rules: {
        fname: {
            required: true
        },
        lname: {
            required: true
        },
        email: {
            required: true,
            email:true
        },
        password: {
            required: true
        },
        confirm: {
            required: true,
            equalTo: "#password"
        },
        phone: {
            required: true,
            digits: true
        },
        dob: {
            required: true,
            date: true
        },
        prn: {
            required: true
        },
        class: {
            required: true
        },
        dept: {
            required: true
        },
    },
    //For custom messages
    messages: {
        lname:{
            required: "Enter your last name"
        },
        fname:{
            required: "Enter your first name"
        },
        email:{
            required: "Enter your email",
            email: "Enter a valid email"
        },
        password:{
            required: "Enter your password"
        },
        confirm:{
            required: "Confirm your password",
            equalTo: "Password doesn't match"
        },
        phone: {
            required: "Enter yout phone number",
            digits: "Not a phone number"
        },
        dob: {
            required: "Enter your Date of Birth"
        },
        prn: {
            required: "Enter your PRN"

        },
        class: {
            required: "Select your class"
        },
        dept: {
            required: "Select your department"
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

