<?php 


//connection

$servername =   'localhost';
$username   =   'root';
$password   =   '';
$dbname     =   "practice";
$conn=mysqli_connect($servername,$username,$password,"$dbname");

if($conn === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


//query to select table from database

$query = "SELECT * FROM form";

//condition to set page number

if(isset($_GET['page'])){
    // echo "hello";
    $page = $_GET['page'];   
}else{
    
    if(isset($_GET['two'])){
            
        $page = $_GET['two'];
        // echo "hi";
    }else{
        $page = 1;
       
    }
}

//codintion for search


if (isset($_GET['search'])) {
        // echo "hi ";
		$search = $_GET['search'];
        // echo $search;
		$query = "SELECT * FROM form WHERE first_name LIKE '%$search%'";
        
     } 

//sort
if(isset($_GET['order'])){
    // echo "success";
    $order = $_GET['order'];

}else{
    $order = "id";
}

if (isset($_GET['sort'])) {
	$sort = $_GET['sort'];   
}else{
    $sort = 'ASC';
}

$query .= " ORDER BY $order $sort";


//dropdown limit

$num_per_page = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 2;

//pagination logic

$start_from = ($page - 1) * $num_per_page;

$filterquery = $query . " LIMIT $start_from,$num_per_page";

$result = mysqli_query($conn, $filterquery);

$pr_result = mysqli_query($conn, $query);
$total_result = mysqli_num_rows($pr_result);
$totalpage = ceil($total_result / $num_per_page);

?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            .btn-prev ,.btn-next {
                background-color: lightgray;
                color: black;
                border: solid;
                padding: 3px;
                border-width: 1px;
                margin-right: 5px;
                margin-left: 5px ;
            }

            th{
                background-color: lightgray;
                border: solid;
                border-width: 1px;
            }
            td{
                background-color: whitesmoke;
                border-left: solid;
                border-bottom: solid;
                border-width: 1px;
                padding-right: 30px;

            }
            .center{
                margin-left: auto;
                margin-right: auto;
                height: 100px;
            }
           
            
        </style>
        <title>pagination</title>
        
    </head>


    <body>
    
    
    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" id = "two" name="two" value="<?php echo $page?>">
    
    <?php
    $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC ';
    
    //echo $sort;
    ?>

    <ul style="padding-inline-start: 0px;">
        <li style="display: inline-block; float:left">
            <span>Show</span>
            <select name="limit" id="limit" onchange="this.form.submit()">
                <option <?php if (isset($_GET["limit"]) && $_GET["limit"] ==  $num_per_page)
                echo 'selected'?> value="<?= $num_per_page; ?>"><?= $num_per_page; ?></option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>Entries</span>
        </li>
        <li style="display: inline-block; float:right">   
            <input type="submit">     
            <input  type="search" id="search" name="search" placeholder="search firstname" value="<?php if(isset($_GET['search'])){echo $search;}?>"> 
        </li>
    </ul>
    <br><br>
    <div>
    <table class="center">
        <?php 
        ?>
        <tr>
            <th>
                <a href="advance_pagination.php?page=<?= $page ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=id&sort=<?= $sort?>" style="text-decoration: none;">id <?php if($_GET['sort'] === "DESC"){ echo "↓"; }else{echo "↑";} ?></a>
            </th>
            
            <th>
                <a href="advance_pagination.php?page=<?= $page ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=first_name&sort=<?= $sort?>" style="text-decoration: none;">firstname <?php if($_GET['sort'] === "DESC"){ echo "↓"; }else{echo "↑";} ?></a>
            </th>

            <th>
                <a href="advance_pagination.php?page=<?= $page ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=last_name&sort=<?= $sort?>" style="text-decoration: none;">lastname <?php if($_GET['sort'] === "DESC"){ echo "↓"; }else{echo "↑";} ?></a>
            </th>

            <th>
                <a href="advance_pagination.php?page=<?= $page ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=email&sort=<?= $sort?>" style="text-decoration: none;">email <?php if($_GET['sort'] === "DESC"){ echo "↓"; }else{echo "↑";} ?></a>
            </th>


            <th style="padding-right: 30px;"> password </th>
        </tr>
        <tr>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <td><?= $row['id'] ?></td>
                <td><?= $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td style="border-right: solid; border-width:1px"><?= $row['password'] ?></td>
        </tr>
            <?php } ?>
    </table>
    
    <input type="hidden" id = "three" name="order" value="<?php echo $order;?>">
    <input type="hidden" id = "four" name="sort" value="<?php if($sort === 'ASC'){echo 'DESC';}else{echo 'ASC';}?>">

    
   <?php 
   if($sort == 'ASC'){
   
    ?>
    <div style="text-align: center;margin-top:50px" id="default">
        <?php if($page > 1) { ?>
            <a class="btn-prev" href="advance_pagination.php?page=<?= $page - 1 ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=<?= $order?>&sort=DESC" style="text-decoration: none;"><?php echo "Previous" ?></a>
        <?php } ?>  
        
        <?php for ($i = 1; $i <= $totalpage; $i++) { ?>
            <a href="advance_pagination.php?page=<?= $i ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=<?= $order?>&sort=DESC" style="text-decoration: none;"><?= $i ?></a>
        <?php } ?>      
        <?php if($page < $totalpage) { ?>
            <a class="btn-next" href="advance_pagination.php?page=<?= $page + 1 ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=<?= $order?>&sort=DESC" style="text-decoration: none;"><?php echo "Next" ?></a>
        <?php } ?>  
    </div>

    <?php
   }else {
    
    ?>
    <div style="text-align: center;margin-top:50px" id="default">
        <?php if($page > 1) { ?>
            <a class="btn-prev" href="advance_pagination.php?page=<?= $page - 1 ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=<?= $order?>&sort=ASC" style="text-decoration: none;"><?php echo "Previous" ?></a>
        <?php } ?>  
        
        <?php for ($i = 1; $i <= $totalpage; $i++) { ?>
            <a href="advance_pagination.php?page=<?= $i ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=<?= $order?>&sort=ASC" style="text-decoration: none;"><?= $i ?></a>
        <?php } ?>      
        <?php if($page < $totalpage) { ?>
            <a class="btn-next" href="advance_pagination.php?page=<?= $page + 1 ?>&limit=<?= $num_per_page ?>&search=<?= $search?>&order=<?= $order?>&sort=ASC" style="text-decoration: none;"><?php echo "Next" ?></a>
        <?php } ?>  
    </div>

    <?php
   }
   ?>

    <br>
    <br>
    <div style="text-align: center; font-size: 18px">
        <?php 
        if($page <= $totalpage){
            ?>
            <p>Showing <?php echo $start_from + 1 ?> to <?php echo $start_from  + $num_per_page ?> of <?php echo $total_result ?> entries. <br><br> Page: <?php echo $page ?></p>
            <?php
        }else{
            ?>
            <p style="color: red;">No Data Found On Current Page.<br>Go To Page: <?php echo $totalpage ?></p>
            <?php
        }
        ?>
    </div>    

	</form>
    </div>

    </body>
</html>

