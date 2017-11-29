<?php
   
session_start();

//DATABASE CONNECT

class DbHelper{
    var $connect;

    //maakt de DB connectie aan
    public function __construct(){
        $this -> connect = new PDO('mysql:host=localhost; dbname=love2sing;','root','');
    } 

//SELECT USER FUNCTION
    
function selectUser(){
    //select query voor de users
    $create = 'SELECT * FROM user WHERE username=:username AND userPassword=:password';
    
    //zorgt dat de connectie wordt gestart vanuit de db
    $statement = $this->connect->prepare($create);
    
    //haalt de gegevens op uit deze rijen
    $statement->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
    $statement->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
    
    $statement->execute();
    
    //controlleerd of alles klopt
    $result = $statement->fetchAll();
    
    //functie userrights
    if(isset($result) && isset($result[0])){
        $user = $result[0];
        
        if($user[0] > 0){
            $_SESSION['logIn'] = 'true';
            $_SESSION['username'] = $user[1];
            $_SESSION['userId'] = $user[0];
            $_SESSION['userRights'] = 'user';
            
            header('Location: index.php');
        }
    }else{
        //select query voor de employees
        $create = 'SELECT * FROM admin WHERE adminUsername=:username AND adminPassword=:password';
    
        //zorgt dat de connectie wordt gestart vanuit de db
        $statement = $this->connect->prepare($create);

        //haalt de gegevens op uit deze rijen
        $statement->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $statement->bindParam(':password', $_POST['password'], PDO::PARAM_STR);

        $statement->execute();

        //controlleerd of alles klopt
        $result = $statement->fetchAll();

        //functie userrights
        if(isset($result) && isset($result[0])){
            $user = $result[0];

            if($user[0] > 0){
                $_SESSION['logIn'] = 'true';
                $_SESSION['username'] = $user[1];
                $_SESSION['userId'] = $user[0];
                $_SESSION['userRights'] = 'admin';

                header('Location: index.php');
            }
        }
        
    }
    
}
    
    //EDIT USER FUNCTION
    
function editUserStart($case){
    //select query die de gegevens van de klant ophaald zodat hij/zij deze kan veranderen
    $create = "SELECT * FROM user WHERE userId = :id";
    
    //deze functie zorgt ervoor dat de gegevens uit de databse worden gehaald
    $statement = $this-> connect -> prepare($create);
    
    //zorgt ervoor dat het juiste id wordt gepakt
    $statement->bindParam(':id', $_SESSION['editPassword'], PDO::PARAM_STR);
    
    $statement -> execute();
    
    $user = $statement->fetchAll();
    
    $userEdit = $user[0];
    
    
    //zorgt ervoor dat wanneer de klant iets vergeet, deze melding in beeld komt
    if(!isset($case)){
        echo "<p>Er is een fout opgetreden met het wijzigen van uw gegevens. Probeer het opnieuw.</p>";
    }else{
        //zorgt ervoor dat wanneer alles correct is, de gegevens worden doorgestuurd naar de db
        print $userEdit[$case];
    }
}
    
function editUser(){
    //update query voor de gebruikers
    $edit = "UPDATE user SET  
    userPassword = :password
    WHERE userId = :id";
    
    //bereid de db voor
    $statement = $this -> connect ->prepare($edit);
    
    //de gegevens die gewijzigd mogen worden (het id wordt NIET aangepast)
    $statement->bindParam(':id', $_SESSION['userId'], PDO::PARAM_STR);
    $statement->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
    
    $statement->execute();
}
    
}

?>
