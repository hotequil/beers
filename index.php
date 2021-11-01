<?php
    require_once("./utils/connection.php");
    require_once("./utils/date.php");

    $statement = $connection -> prepare("SELECT id, name, value, expiration FROM $table");

    try{
        $statement -> execute();

        $results = $statement -> fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $error){
        showError($error);
    }
?>

<?php require_once("./components/header.php") ?>

<div class="list">
    <div class="list__content">
        <h2 class="subtitle">List</h2>
        <a class="button" href="./save.php" target="_self">Create</a>
    </div>

    <?php
        if(!$results){
            echo "
                <div class='not-found'>
                    <h4 class='not-found__title'>Not found items</h4>
                    <p class='not-found__description'>Create an item, please</p>
                </div>
            ";
        } else{
            $rows = "";

            foreach($results as $row){
                $columns = "";
                $id = $row['id'];

                foreach($row as $key => $value){
                    $value = $key === 'expiration' ? formatString($value) : $value;

                    if($key !== "id") $columns = "$columns<td class='table__column'>$value</td>";
                }

                $rows = "$rows
                    <tr>
                        $columns
                        <td class='table__column'><a class='button' href='save.php?id=$id' target='_self'>Edit</a></td>
                        <td class='table__column'><a class='button' href='delete.php?id=$id' target='_self'>Delete</a></td>
                    </tr>
                ";
            }

            echo "
                <table class='table'>
                    <thead>
                        <tr>
                            <th class='table__column table__column--head'>Name</th>
                            <th class='table__column table__column--head'>Value</th>
                            <th class='table__column table__column--head'>Expiration</th>
                            <th class='table__column table__column--head'>Edit</th>
                            <th class='table__column table__column--head'>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        $rows
                    </tbody>
                </table>
            ";
        }
    ?>
</div>

<?php require_once("./components/footer.php") ?>
