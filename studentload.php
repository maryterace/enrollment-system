<?php  
include('db.php');
include 'navigation.php';

?>
<html>
<br>
    <form action="./studentload.php" method="get">
            <div class="form-group">
                <input type="text" name="search" class="form-control" value="<?php echo @$_GET['search'] ?>" placeholder="Search Student">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <?php 
        if(isset($_GET['search'])) {
            ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Lastname</th>
                </tr>
            </thead>
            <tbody>
        <?php
            }
        ?>
        <?php 
        if(isset($_GET['search'])) {
            include_once "./db.php";
            $student = $_GET['search'];
            $sql = "select * from student where Firstname like '%$student%' or Lastname like '%$student%'";
            $result = $conn->query($sql);
            $res = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                    <th scope="row"><?php echo $row['ID'] ?></th>
                    <td><?php echo $row['FirstName'] ?></td>
                    <td><?php echo $row['LastName'] ?></td>
                    <form action="./studload.php" method="get">
                        <input type="text" name="id" value="<?php echo $row['ID'] ?>" hidden/>
                        <input type="text" name="firstname" value="<?php echo $row['FirstName'] ?>" hidden/>
                        <input type="text" name="lastname" value="<?php echo $row['LastName'] ?>" hidden/>
                        <!-- <input type="text" name="loadrow" value="1" hidden> -->
                        <td><button type="submit" class="btn btn-success"><i class="fas fa-eye"></i></button></td>
                    </form>
                    </tr>
                    <?php
                }
            }
        }
        ?>
</html>