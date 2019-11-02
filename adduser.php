<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$username=$_POST['ownername'];
$password=$_POST['adhar'];
$name=$_POST['no'];
$DOB=$_POST['zip'];
$gender=$_POST['carname'];
$acctype=$_POST['modelno'];
$Nname=$_POST['price'];
$adhaar=$_POST['bookdt'];
$address=$_POST['shwrm'];
$balance=$_POST['bkamt'];


$conn = new mysqli('localhost','pmauser','Myname@2527','car');
    if ($conn->connect_error) {
     die('Connection Failed : '.$conn->connect_error);
    }else
    {
    //Prepare statement
      $stmt =$conn->prepare("insert into adduser(Owner,Mod_name,Ser_no,Reg_no,Engine,Fac_Type,Dos,Fac_man,Dom,Fac_loc) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssssss",$username,$password,$name,$DOB,$gender,$acctype,$Nname,$adhaar,$address,$balance);
      $stmt->execute();
      echo "New record inserted sucessfully";
       
       $sql =$conn->prepare("insert into userlog(Name, Username, Password) values(?, ?, ?)");
    	$sql->bind_param("sss",$username, $name, $DOB);
    	$sql->execute();
    	echo"Record Inserted Successfully";
    	
  $stmt->close();
  $sql->close();
  $conn->close();
    }
  
       
?>      

