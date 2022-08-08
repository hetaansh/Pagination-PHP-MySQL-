<!DOCTYPE html>
<html>

<head>
    <title>Pagination</title>
</head>

<body>

    </form>

    <?php
    $con = mysqli_connect("localhost", "root", "");
    mysqli_select_db($con, 'practice');


    $results_per_page = 10;
    
   

    $sql = "SELECT * FROM form";
    $result = mysqli_query($con, $sql);
    $number_of_results = mysqli_num_rows($result);

   
    // echo $results_per_page;

    $number_of_page = ceil($number_of_results / $results_per_page);

    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page - 1) * $results_per_page;

    $sql = "SELECT * FROM form LIMIT " . $this_page_first_result . ',' . $results_per_page;
    $result = mysqli_query($con, $sql);

    ?>

    <table>
        <tr>
            <th style="padding-right: 30px;">id</th>
            <th style="padding-right: 30px;">firstname</th>
            <th style="padding-right: 30px;">lastname</th>
            <th style="padding-right: 30px;">email</th>
            <th style="padding-right: 30px;">password</th>
        </tr>
        <tr>
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <td style="padding-right: 30px;"><?= $row['id'] ?></td>
                <td style="padding-right: 30px;"><?= $row['first_name'] ?></td>
                <td style="padding-right: 30px;"><?= $row['last_name'] ?></td>
                <td style="padding-right: 30px;"><?= $row['email'] ?></td>
                <td style="padding-right: 30px;"><?= $row['password'] ?></td>
        </tr>
    <?php
            }
    ?>
    </table>

    <?php
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "simple_pagination.php?page=' . $page . '"> ' . $page . '</a>';
    }
    ?>



</body>

</html>