<?php 
    /* VARIABLES */
    $hostDB="localhost";
    $userDB = "root";
    $passwordDB = "";
    $DBName = "logup";

    /* BUSCAR USUSARIOS REPETIDOS*/ 
    $tblName = "";

    /* ENCRIPTAR PASSWORD */

    $passwordOrig = $_POST['password'];
    $hast = password_hash($passwordOrig,PASSWORD_BCRYPT);
    
    /* CONECCION  A LA BASE DE DATOS*/

    $conexion = new mysqli($hostDB,$userDB,$passwordDB,$DBName);
    if($conexion->connect_error){
        die("La Conexion a fallado: " . $conexion->connect_error);
    }

    /* BUSCAR USUSARIOS REPETIDOS*/ 

    $searchUser="select * from user where userName='$_POST[userName]'";

    $result = $conexion->query($searchUser);

    $count = mysqli_num_rows($result);

    //COMPARO SI HAY ALGUNA RESPUESTA REPETIDA

    if($count==1){
        echo "<br />" . "User Already Exists" . "<br />";
        echo "<a href='index.html'> Enter Another User</a>";
    }else{
        $query="insert into user(userName,password) values ('".$_POST['userName']."','".$hast."')";
    }

    if($conexion->query($query)===TRUE){
        echo "<br /> . "."<h2>" . "User created successfully..."."</h2>";
        echo "<h4>" . "Welcome..." . $_POST['userName'] . "</h4>"."\n\n";
        echo "<h5>" . "New "."<a href='index.html'>Log Up</a>". "<h5/>";
    }else{
        echo "Error. Try again". $query. "<br>" . $conexion->error;
    }
    mysqli_close($conexion);
?>