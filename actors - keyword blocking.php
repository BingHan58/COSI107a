<?php include "head.php";?>

<body>
    <?php include "title.php";?>

    <div class="container">
        <form method="post" action="actors.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter id" name="inputId">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="submitted">Query</button>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter name" name="inputId">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" name="submitted">Query</button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="container">

        <?php
function filter_sql_keywords($input) {
    $pattern = '/\s*\b(insert|update|delete|union|join|from|where|group|into|load_file)\b\s*/i';
    return trim(preg_replace($pattern, '', $input));
}



$columns = ['id', 'name', 'nationality', 'dob', 'gender'];
$columns_str = join(',', $columns);
if (isset($_POST['submitted'])) {
    $idLimit = $_POST["inputId"];
    // Filter SQL keywords
    $idLimit = filter_sql_keywords($idLimit);
    if (empty($idLimit)) {
        echo "<p>Invalid input provided. Keyword is detected!!! Go AWAY HACKERS</p>";
        $idLimit = 0;  // You can also choose to stop execution or handle differently
    }
} else {
    $idLimit = 0; // Default value if no input provided
}

$table = execute_query("SELECT $columns_str FROM People p JOIN Role r ON p.id = r.pid WHERE r.role_name = 'Actor' AND p.id >= $idLimit");

generate_table($columns, $table);

?>

    </div>
