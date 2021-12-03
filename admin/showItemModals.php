<?php
include("../connect.php");

if (isset($_POST['dataId'])) {
    $id = $_POST['dataId'];

    $sql = "SELECT * FROM menu_details WHERE id_menu = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {


?>
            <tr>
                <td><?= $row["price"]; ?></td>
                <td><?= $row["size"]; ?></td>
                <td><?= $row["about"]; ?></td>
                <td> <a href="delete_menu_item.php?item_del=<?= $row['id'] ?>"  class="btn btn-danger btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fas fa-trash-alt"></i></a>  </td>

            </tr>
        <?php
        }
    } else {
        ?>
        <td>No Item !</td>
    <?php

    }
    ?>
<?php
}

?>