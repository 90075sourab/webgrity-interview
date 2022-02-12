<?php 
function getData()
{   try{
       if(isset($_COOKIE["db_1234"])){
           return json_decode($_COOKIE["db_1234"]);
       }else{
           return null;
       }
    }catch(Exception $e){
        return null;
    }

}
function insertData($data)
{       
        $fetched_data = getData();
        $fetched_data_array =[];
        $store_data = [];
        
        if(!empty($fetched_data)){
            foreach($fetched_data  as $f){
                $fetched_data_array[] = ["name"=>$f->name,"age"=>$f->age];
            }
            $fetched_data_array[] = $data;
            $store_data = $fetched_data_array;
        }else{
            $store_data[] = $data;
        }
        setcookie("db_1234", json_encode($store_data), time() + (86400 * 30), "/");
}
function clear_input($data) {

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    return $data;

}
$name_error  = "";
$age_error   = "";
$name  = "";
$age = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["name"]) && empty($_POST["age"])){
        $name_error  = "name is required";
        $age_error   = "age is required";
    }else if(empty($_POST["name"])){
        $name_error  = "name is required";
        $age = clear_input($_POST["age"]);
    }else if( empty($_POST["age"])){
        $age_error   = "age is required";
        $name = clear_input($_POST["name"]);
    }else{
        
        $age = clear_input($_POST["age"]);
        $name = clear_input($_POST["name"]);
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$name)){
            $name_error  = "name should be alphabatic";
        }else if(intval($age) <=0 || intval($age) >100){
            $age_error   = "age should be valid";
        }else{ 
          insertData(["name"=>$name,"age"=>$age]);
          header("Location:./bb.php");
        }
    }
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error{
            color:red;
        }
    </style>
</head>
<body>
     <form action="aa.php" method="POST" style="padding:30px 50px;border:1px solid #333;width:400px;">
          <label for="">Name</label><br>
          <input type="text" name="name" id="name" value="<?php echo $name;?>">
          <br>
          <span class="error"><?php echo $name_error;?></span>
          <br><br>
          <label for="">Age</label><br>
          <input type="number" name="age" id="age" value="<?php echo $age;?>">
          <br>
          <span class="error"><?php echo $age_error;?></span>
          <br><br>
          <button type="submit">Submit</button>
     </form>
</body>
</html>

