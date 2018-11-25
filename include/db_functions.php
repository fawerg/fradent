<?php

function connect(){
    $servername = "localhost";
    $username = "Fradent";
    $password = "Shannara1";
    $db = "Fradent";
    $result;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return null;
    }
    return $conn;
}


function getUserList() {
    $conn = connect();
    $result;
    $i=0;
    if($statement = $conn->prepare("SELECT * FROM User")){
        $statement->execute();
        $statement->bind_result($result[$i][0],$result[$i][1],$result[$i][2],$result[$i][3],$result[$i][4]);
        while($statement->fetch()!=null){
            $i++;
            $statement->bind_result($result[$i][0],$result[$i][1],$result[$i][2],$result[$i][3],$result[$i][4]);
        }
        $statement->close();
    }
    unset($result[count($result)-1]);
    $conn->close();
    return $result;
}

function login($username,$password){
    $conn = connect();
    $result;
    if($conn){
        if($statement =$conn->prepare("SELECT * FROM User WHERE USERNAME=?")){
            $statement->bind_param("s",$username);
            $statement->execute();
            $statement->bind_result($result[0],$result[1],$result[2],$result[3],$result[4]);
            $statement->fetch();
            if($result[3]==$password){
                $_SESSION['isLogged']=true;
                return true;
            }
            else{
                return false;
            }
            $statement->close();
        }
        $conn->close();
    }
    return false;
}
?>