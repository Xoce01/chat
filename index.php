<?php
session_start ();
function loginForm() {
    echo '
   
	<div class="form-group"  style="width:70%; height:100px; float:center; background-color: #075E54; border:1px solid #063; margin:auto;">
		<div id="loginform">
			<form action="index.php" method="post">
			<h1>bienvenido</h1>
				<p style="text-align: center; color:white;"><label for="name" >por favor entra con su nombre</label>
                </p>
				<input type="text" name="name" id="name" class="form-control" placeholder="nombre"/>

				<button style=" width:100%; background-color:#075E54; color:white;><input type="submit" class="btn btn-default" name="enter" id="enter" value="Enviar" />Entrar
                </button>
			</form>
		</div>
	</div>
   ';
}
 
if (isset ( $_POST ['enter'] )) {
    if ($_POST ['name'] != "") {
        $_SESSION ['name'] = stripslashes ( htmlspecialchars ( $_POST ['name'] ) );
        $cb = fopen ( "log.html", 'a' );
        fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['name'] . " se ha unido a la sesión de chat.</i><br></div>" );
        fclose ( $cb );
    } else {
        echo '<span class="error" >entra con su nombre</span>';
    }
}
 
if (isset ( $_GET ['logout'] )) {
    $cb = fopen ( "log.html", 'a' );
    fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['name'] . " ha abandonado la sesión de chat.</i><br></div>" );
    fclose ( $cb );
    session_destroy ();
    header ( "Location: index.php" );
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Linvir</title>
    <link  rel="stylesheet" href="style.css">
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>
    body{
        box-sizing: border-box;
    }
    #wrapper{
        width: 45%;
        margin:auto;
       background-color: #075E54; 

    }
        #menu {
           
            margin:auto;
             width: 100%;
            
        }
        h1{
           text-align: center;
           color:white;
        }
        #chatbox{
            width:100%;
            height: 150px;
            background-color: white;
            overflow: auto;
        }
        #submitmsg{
            width:100%;
            background-color: #075E54;
            color: #e1e2e2;
            
        }
         #submitmsg:hover{
             color:white;
         }
        #menu p{
            display: inline;
            color:white;
        }
         #menu p .nom{
             color:white;
         }
        #exit{
            float: right;
           background-color:#f54f26;
           border-style: none;
           color:white;
        }
        .ve{
            width:7px ;
            height:7px;
            background-color:#79e962;
             position: relative;
            left:2% ;
             top:0px ;
             border-radius:50px ;
              display: inline-block;
        }
        hr{
            background-color:red;
        }
        .error { color: #ff0000;
                position: relative;
                left: 40%;
    }
       @media (max-width: 600px) {
  #wrapper{
        width: 90%;
        

  }
}
    </style>
</head>
<body>
<?php
	if (! isset ( $_SESSION ['name'] )) {
	loginForm ();
	} else {
?>
<div id="wrapper">
	<div id="menu">
	<h1>chat linvir!</h1><hr/>
		<p class="welcome">NOMBRE - <a class="nom"><?php echo $_SESSION['name']; ?></a></p><div class="ve"></div>
		<p class="logout"><a id="exit" href="#" class="btn btn-default">salir del Chat</a></p>
	<div style="clear: both"></div>
	</div>
	<div id="chatbox">
	<?php
		if (file_exists ( "log.html" ) && filesize ( "log.html" ) > 0) {
		$handle = fopen ( "log.html", "r" );
		$contents = fread ( $handle, filesize ( "log.html" ) );
		fclose ( $handle );

		echo $contents;
		}
	?>
	</div>

    <div class="con">
<form name="message" action="">
	<input name="usermsg" class="form-control" type="text" id="usermsg" placeholder="crea un mensaje" />
	<input name="submitmsg" class="btn btn-default" type="submit" id="submitmsg" value="Enviar" />

</form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
});
$(document).ready(function(){
    $("#exit").click(function(){
        var exit = confirm("¿Estás seguro de que quieres dejar esta página?");
        if(exit==true){window.location = 'index.php?logout=true';}     
    });
});
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});             
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});
function loadLog(){    
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){       
            $("#chatbox").html(html);       
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
            }              
        },
    });
}
setInterval (loadLog, 2500);
</script>
<?php
}
?>
</body>
</html>