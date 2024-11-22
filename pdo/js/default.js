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


    $("#searchBar").submit(function(e){
        e.preventDefault();
    })    

    $("#searchBtn").click(function(e){
        $query = $("#searchTxt").val();

        $data = {
            action: 'performSearch',
            query: $query
        }

        $.ajax({
            type: 'POST',
            url: 'protected/db/db.class.php',
            data: $data
        }).done(function(msg){
            console.log(msg);
        });

        // console.log($data);
    })
}