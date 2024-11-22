window.onload = function() {

    $("#login").submit(function(e){
        e.preventDefault();
    })    

    $("#loginBtn").click(function(e){
        $email = $("#emailTxt").val();
        $pass  = $("#passTxt").val();

        $data = {
            action: 'performLogin',
            email: $email,
            pass: $pass
        }

        $.ajax({
            type: 'POST',
            url: 'protected/db/db.class.php',
            data: $data
        }).done(function(msg){
            console.log(msg);
            if(msg == true){
                window.location.href = 'index.php';
            }
            else{
                alert("User/password incorrect!");
            }
        });
    })

    $("#register").submit(function(e){
        e.preventDefault();
    })    

    $("#registerBtn").click(function(e){
        $fName = $("#firstNameTxt").val();
        $mName = $("#middleNameTxt").val();
        $lName = $("#lastNameTxt").val();
        $email = $("#registerEmailTxt").val();
        $pass = $("#registerPassTxt").val();
        $passCon  = $("#registerPassConfTxt").val();

        if($pass === $passCon){
            $data = {
                action: 'createUser',
                fName: $fName,
                mName: $mName,
                lName: $lName,
                email: $email,
                pass: $pass
            }

            $.ajax({
                type: 'POST',
                url: 'protected/db/db.class.php',
                data: $data
            }).done(function(msg){
                // console.log(msg);
                if(msg){
                    window.location.reload(true);
                }
                else{
                    alert("Problem while trying to register.");
                }
            });
        } else{
            alert("passwords must match");
        }
        
    })

    $('#btnLogOut').click(function(e){
		e.preventDefault();
		
		var $data = {
			action: 'performLogout'
		};

		$.ajax({
			  type: "POST",
			  url: 'protected/db/db.class.php',
			  data: $data
		}).done(function() {
	        window.location.replace('index.php');
		});
	})


    // $("#searchBar").submit(function(e){
    //     e.preventDefault();
    // })    

    // $("#searchBtn").click(function(e){
    //     $query = $("#searchTxt").val();

    //     $data = {
    //         action: 'performSearch',
    //         query: $query
    //     }

    //     $.ajax({
    //         type: 'POST',
    //         url: 'protected/db/db.class.php',
    //         data: $data
    //     }).done(function(msg){
    //         console.log(msg);
    //     });
    // })

    $("#addPaymentForm").submit(function(e){
        e.preventDefault();
    })
    
    
    $("#addPaymentBtn").click(function(e){
        $user_id = $("#uuidTxt").val();
        $card_number = $("#cardNumberTxt").val();
        $month = $("#monthSelect").val();
        $year = $("#yearSelect").val();
        $expiration_date = $year.concat("-",$month,"-01");
        $cvv = $("#cvvTxt").val();

        $data = {
            action: 'insertPaymentMethod',
            user_id: $user_id,
            card_number: $card_number,
            expiration_date: $expiration_date,
            cvv: $cvv
        }

        console.log(JSON.stringify($data));

        $.ajax({
            type: 'POST',
            url: 'protected/db/db.class.php',
            data: $data
        }).done(function(msg){
            if(msg){
                alert("Payment information successfully Added.")
                //window.location.reload(true);
            } else{
                alert("An error occured while adding paymment information.")
            }
            //console.log(msg);
        });
    })

    $('#isPasswordUpdated').click(function() {
        if($("#isPasswordUpdated").is(':checked')){
            $("#updatePassTxt").prop("disabled", false);  // checked
        }else{
            $("#updatePassTxt").prop("disabled", true);  // unchecked
        }
    })

    $("#updateUserForm").submit(function(e){
        e.preventDefault();
    })

    $(function () {
        $('#updateBtn').attr('disabled', true);
        $('#updateEmailTxt').change(function () {
            if ($('#firstNameTxt').val() != '' && $('#middleNameTxt').val() != '' && $('#lastNameTxt').val() != '' && $('#updateEmailTxt').val() != '') {
                $('#updateBtn').attr('disabled', false);
            } else {
                $('#updateBtn').attr('disabled', true);
            }
        });
     });
    
    $("#updateBtn").click(function(e){
        
        $id = $("#uuidTxt").val();
        $fName = $("#firstNameTxt").val();
        $mName = $("#middleNameTxt").val();
        $lName = $("#lastNameTxt").val();
        $email = $("#updateEmailTxt").val();
        $pass = $("#updatePassTxt").val();

        if($("#isPasswordUpdated").is(':checked')){
            console.log("password will BE updated.");

            $data = {
                action: 'updateUser',
                id: $id,
                fName: $fName,
                mName: $mName,
                lName: $lName,
                email: $email,
                pass: $pass
            }
            
        } else{
            console.log("password will NOT be updated.");

            $data = {
                action: 'updateUser',
                id: $id,
                fName: $fName,
                mName: $mName,
                lName: $lName,
                email: $email
            }
        }

        console.log(JSON.stringify($data));

        $.ajax({
            type: 'POST',
            url: 'protected/db/db.class.php',
            data: $data
        }).done(function(msg){
            if(msg){
                alert("User information successfully updated.")
                window.location.reload(true);
            } else{
                alert("An error occured while updating user information.")
            }
        });
    })

}