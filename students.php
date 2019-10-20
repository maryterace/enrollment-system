<?php  
include('db.php');
include 'navigation.php';

//UPDATING STUDENT
if(isset($_POST['ID'])) {
	$ID = $_POST['ID'];
	$firstname = $_POST['FirstName'];
	$middlename = $_POST['MiddleName'];
	$lastname = $_POST['LastName'];
	$age = 18;
	$birthdate = $_POST['Birthdate'];
	$birthplace = $_POST['Birthplace'];
	$gender = $_POST['Gender'];
	$status = $_POST['Status'];
	$contact = $_POST['Contact'];
	$nationality = $_POST['Nationality'];
	$course = $_POST['Course'];
	//  $schedule = $_POST['Schedule'];
	$email = $_POST['Email'];
	$password = $_POST['Password'];

	$sql = "update student set FirstName='$firstname',
	MiddleName='$middlename', 
	LastName='$lastname', 
	Age=$age,
	Birthdate='$birthdate',
	Birthplace='$birthplace',
	Gender='$gender',
	Status='$status',
	Contact='$contact',
	Nationality='$nationality',
	Course='$course',
	Email='$email',
	Password='$password',
	Role='student'
	where ID='$ID'";

	if ($conn->query($sql) === TRUE) {
		header('location: /students.php?updated=true');
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		header('location: /students.php?updated=false');
	}
	$conn->close();
}

// ADDING STUDENT
if(isset($_POST['add'])) {
	$firstname = $_POST['FirstName'];
	$middlename = $_POST['MiddleName'];
	$lastname = $_POST['LastName'];
	$age = $_POST['Age'];
	$birthdate = $_POST['Birthdate'];
	$birthplace = $_POST['Birthplace'];
	$gender = $_POST['Gender'];
	$status = $_POST['Status'];
	$contact = $_POST['Contact'];
	$nationality = $_POST['Nationality'];
	$course = $_POST['Course'];
	$schedule = $_POST['Schedule'];
	$email = $_POST['Email'];
	$password = $_POST['Password'];

	$sql = "insert into student (FirstName, MiddleName, LastName, Age,Birthdate,Birthplace,Gender,Status,Contact,Nationality,Course,Schedule,Email,Password,Role) values ('$firstname','$middlename','$lastname','$age','$birthdate','$birthplace','$gender','$status','$contact','$nationality','$course','$schedule','$email','$password','student')";
	if ($conn->query($sql) === TRUE) {
			header('location: /students.php?added=true');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('location: /students.php?added=false');
		}
	$conn->close();

}
// DELETING STUDENT
if(isset($_GET['delete'])) {
	$sql = "delete from student where ID=".$_GET['delete'];
    if ($conn->query($sql) === TRUE) {
        header('location: /students.php?deleted=true');
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        header('location: /students.php?deleted=false');
    }
    $conn->close();
}

?>

<!DOCTYPE html>
<html>
    <head>
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
	<?php
    if (isset($_GET['updated'])) {
		if($_GET['updated'] == 'true') {
			echo '<div class="msg">Student updated!</div>';
		}
	}
	if (isset($_GET['deleted'])) {
		if($_GET['deleted'] == 'true') {
			echo '<div class="msg">Student deleted!</div>';
		}
	}
	if (isset($_GET['added'])) {
		if($_GET['added'] == 'true') {
			echo '<div class="msg">Student added!</div>';
		}
	}
	
	?>
<body>


<?php 
	if($_SESSION['user'][4] == 'admin') {
?>

<?php 
if(isset($_GET['edit'])) { ?>
	<form method="post" action="students.php">
		<div class="input-group">
			<label>First Name *</label>
			<input type="text" name="FirstName" value="<?php echo @$_GET['FirstName'] ?>">
		</div>
		<div class="input-group">
			<label>Middle Name </label>
			<input type="text" name="MiddleName" value="<?php echo @$_GET['MiddleName'] ?>">
		</div>
        <div class="input-group">
			<label>Last Name *</label>
			<input type="text" name="LastName" value="<?php echo @$_GET['LastName'] ?>">
		</div>
		<div class="input-group">
			<label>Birthdate *</label>
			<input type="date" name="Birthdate" value="<?php echo @$_GET['Birthdate'] ?>">
		</div>
		<div class="input-group">
			<label>Birthplace</label>
			<input type="text" name="Birthplace" value="<?php echo @$_GET['Birthplace'] ?>">
		</div>
		<div class="input-group">
			<label>Gender *</label>
			<select class="input-group" name="Gender" value="<?php echo $_POST['Gender']?>">
				<option  <?php if($_GET['Gender']=='Male') echo 'selected'?>>Male</option>
				<option  <?php if($_GET['Gender']=='Female') echo 'selected'?>>Female</option>
            </select>
		</div>
		<div class="input-group">
			<label>Status</label>
			<select class="input-group" name="Status" value="<?php echo $_POST['Status']?>">
				<option  <?php if($_GET['Status']=='Single') echo 'selected'?>>Single</option>
				<option  <?php if($_GET['Status']=='Married') echo 'selected'?>>Married</option>
			 </select>
		</div>
		<div class="input-group">
			<label>Contact</label>
			<input type="text" name="Contact" value="<?php echo @$_GET['Contact'] ?>">
		</div>
		<div class="input-group">
			<label>Nationality</label>
			<input type="text" name="Nationality" value="<?php echo @$_GET['Nationality'] ?>">
		</div>
		<div class="input-group">
			<label>Course</label>
			<select class="input-group" name="Course" id="exampleFormControlSelect1" value="<?php echo $_POST['Course']?>">
                <?php
                $sql = "select * from Course";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
						$course = $row['Code'];
                        ?>
                        <option <?php if ($_GET['Course'] == $course) echo 'selected'; ?>>
                            <?php echo $course;?>
                        </option>
                    <?php }} ?>
                </select>
		</div>
		<div class="input-group">
			<label>Email *</label>
			<input type="text" name="Email" value="<?php echo @$_GET['Email'] ?>">
		</div>
		<div class="input-group">
			<label>Password *</label>
			<input type="text" name="Password" value="<?php echo @$_GET['Password'] ?>">
		</div>
		<div class="input-group">
			<input type="text" name="ID" value="<?php echo @$_GET['id'] ?>" hidden>
			<button class="btn" type="submit" name="save">UPDATE</button>
		</div>
	</form>

	<?php } ?>

	<?php 
			if($_SESSION['user'][4] == 'admin') {
			?>

<?php } if(!isset($_GET['edit'])) { ?>

	<form method="post" action="students.php">
		<div class="input-group">
			<label>First Name *</label>
			<input type="text" name="FirstName">
		</div>
		<div class="input-group">
			<label>Middle Name </label>
			<input type="text" name="MiddleName">
		</div>
        <div class="input-group">
			<label>Last Name *</label>
			<input type="text" name="LastName">
		</div>
		<div class="input-group">
			<label>Birthdate *</label>
			<input type="date" name="Birthdate" >
		</div>
		<div class="input-group">
			<label>Birthplace</label>
			<input type="text" name="Birthplace">
		</div>
		<div class="input-group">
			<label>Gender *</label>
			<select class="input-group" name="Gender">
				<option>Male</option>
				<option>Female</option>
            </select>
		</div>
		<div class="input-group">
			<label>Status</label>
			<select class="input-group" name="Status">
				<option>Single</option>
				<option>Married</option>
				<option>Divorced</option>
				<option>Widowed</option>
				<option>Widower</option>
			</select>
		</div>
		<div class="input-group">
			<label>Contact</label>
			<input type="text" name="Contact">
		</div>
		<div class="input-group">
			<label>Nationality</label>
			<input type="text" name="Nationality">
		</div>
		<div class="input-group">
			<label>Course *</label>
			<select class="input-group" name="Course" value="<?php echo $_POST['Course']?>">
                <?php
                $sql = "select * from Course";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $course = $row['Code'];
                        ?>
                        <option>
                            <?php echo $course; ?>
                        </option>
                    <?php }} ?>
                </select>
		</div>
		<div class="input-group">
			<label>Email *</label>
			<input type="text" name="Email">
		</div>
		<div class="input-group">
			<label>Password *</label>
			<input type="text" name="Password">
		</div>
		<div class="input-group">
			<input type="text" name="add" value="add" hidden>
			<button class="btn" type="submit" name="save">ADD</button>
		</div>
	</form>
	
<?php } ?>
<?php } ?> 

<table>
	<thead>
		<tr>
            <th>ID</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Last Name</th>
			<th>Course</th>

			<?php 
				if($_SESSION['user'][4] == 'admin') {
			?>
			<th colspan="2">Action</th>
			<?php } ?>

		</tr>
	</thead>
	
    <?php 
    $sql = "select * from student";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
		<tr>
			<td><?php echo $row['ID']; ?></td>
			<td><?php echo $row['FirstName']; ?></td>
			<td><?php echo $row['MiddleName']; ?></td>
			<td><?php echo $row['LastName']; ?></td>
			<td><?php echo $row['Course']; ?></td>
			
			<?php 
			if($_SESSION['user'][4] == 'admin') {
			?>

			<td>
                <a href="students.php?edit=true&id=<?php echo $row['ID'] ?>&FirstName=<?php echo $row['FirstName'] ?>&MiddleName=<?php echo $row['MiddleName'] ?>&LastName=<?php echo $row['LastName'] ?>&Birthdate=<?php echo $row['Birthdate'] ?>&Birthplace=<?php echo $row['Birthplace'] ?>&Gender=<?php echo $row['Gender'] ?>&Status=<?php echo $row['Status'] ?>&Contact=<?php echo $row['Contact'] ?>&Nationality=<?php echo $row['Nationality'] ?>&Course=<?php echo $row['Course'] ?>&Email=<?php echo $row['Email'] ?>&Password=<?php echo $row['Password'] ?>" class="edit_btn">Edit</a>
			</td>
			<td>
				<a href="students.php?delete=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
			</td>
			<?php } ?>
			
		</tr>
    <?php }
    } ?>
</table>
    </body>
</html>