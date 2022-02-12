<?php
$data=[];
$sort="asc";
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
$fetch_data=getData();
if(!empty($fetch_data)){
    foreach($fetch_data as $f){
     $data[] =["name"=>$f->name,"age"=>intval($f->age)];
    }
}


if(isset($_GET["field"]) && isset($_GET["sort"])){
    if(($_GET["field"] == "name" || $_GET["field"] == "age") && ($_GET["sort"] == "desc" || $_GET["sort"] == "asc")){
        function lcase($v)
        {
          return strtolower($v[$_GET["field"]]);
        }
        $columns = array_map('lcase',$data);
        $type = $_GET["field"] == 'age'? SORT_NUMERIC:SORT_FLAG_CASE; 
        if($_GET["sort"] == 'asc')
            array_multisort($columns, SORT_ASC, $data,$type );
        else{
            array_multisort($columns, SORT_DESC, $data,$type);
        }
        $sort= $_GET["sort"] == "desc"?'asc':'desc';
        

    }else{
        $columns = array_map('lcase',$data);
        array_multisort($columns, SORT_ASC, $data);
    }

}else{
    //  $columns = array_column($data, 'name');
    //  array_multisort($columns, SORT_ASC, $data);
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
        .a-tag{
            text-decoration:none;
            color:#333;
            font-size:25px;
        }
        table, th, td {
          border: 1px solid white;
          border-collapse: collapse;
        }
        th, td {
          background-color: #96D4D4;
          padding:10px 15px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <th>Name <a href="./bb.php?field=name&sort=<?php echo $sort;?>" class="a-tag">&#8595;&#8593;</a></th>
            <th>Age  <a href="./bb.php?field=age&sort=<?php echo $sort;?>" class="a-tag">&#8595;&#8593;</a></th>
        </thead>
        <tbody>
            <?php
              foreach($data as $d){
                  echo "<tr>";
                  echo "<td>".$d['name']; 
                  echo "</td>";
                  echo "<td>".$d['age'];
                  echo "</td>";
                  echo "</tr>";
              }
            ?>
            
        </tbody>
    </table>
     <br> <br>
     <a href="./aa.php"><button>Back</button></a>
    <?php 
      
    
    
    ?>
    
</body>
</html>