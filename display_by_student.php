<?php
	//form detection
	require_once("include_function.php");
	require_once("validation_functions.php");
	require_once("connection.php");
	$errors = array();
	$message ="";
	if(isset($_POST['submit']))
	{
		
		$student_id = trim($_POST['Student_id']);
		
	
		
		//validations
		
		//1
		$fields_required =array( "Student_id");
		foreach($fields_required as $field){
			$value = trim($_POST[$field]);
			if(!has_presence($value))
			{		
				$errors[$field] = ucfirst($field) . " can't be Blank";
			}		
		}
		
		
		$fields_with_max_lengths = array("Student_id" => 10,);
		validate_max_lengths($fields_with_max_lengths);
		
		$query0 ="select student_id
						from student
						where student_id ='$student_id'; ";
		$result110 = mysqli_query($connection, $query0);
		$test110 = mysqli_fetch_assoc($result110);
		if(!empty($test110["student_id"]))
		{
			$query= " select concat(b.student_first_name, ' ', b.student_last_name) as name,
					a.issue_date, a.return_date, c.due_date, a.book_id
					from issue_return a, student b, issue_date c
					where a.student_id = b.student_id
					and a.issue_date = c.issue_date
					and a.student_id= '$student_id';";
			$result = mysqli_query($connection, $query);
			
			$result112 = mysqli_query($connection, $query);
			$test112 = mysqli_fetch_assoc($result112);
			 if(empty($test112["book_id"]))
			{
				$errors["exist"]="No record exist";
			}
		}
		else
		{
			$errors["exist"]="Student is not Registered";
		}
		
	}
	else{
		$student_id ="";
	}
?>

<html>
<head>
	<title> Librarian </title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css">
	<link rel="stylesheet" type="text/css" href="issue_book.css">
	<link rel="stylesheet" type="text/css" href="table.css">
</head>

<body>
<div class="main">

		<div id="banner">
			<img src="banner.jpg" width="100%" height="192"/>
		</div>



		<div id="sidelinks" >
			<ul>

				<div class="button"> <li>  <a  class="ban" href="admin.php" >  Home </a> </div>
				
				<hr align="left" width=80% size=1 color="black"> 
				
				<div class="button"> <li>  <a  class="ban" href="add_book.php" >  Add Books </a> </div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="issue_book.php"> Issue Books </a> </div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="return_book.php"> Return Book </a> </div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="delete_book.php"> Delete Book </a></div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="search_book.php"> Search Book </a></div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="register_user.php"> Register User </a></div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="fine_list.php"> Fine List </a> </div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="active" class="ban" href="display_book.php"> Display Book </a></div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="add_category.php"> Add Category </a></div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="show_category.php"> Show Category </a></div>
				<hr align="left" width=80% size=1 color="black">
				<div class="button"> <li>  <a class="ban" href="login.php"> Log Out </a></div>
				<hr align="left" width=80% size=1 color="black">
				
			</ul>
		</div>
		
		<div id="content">
			
			
		
				<div class="log">			
		
			
			</div>
			<h2 style="text-shadow: 0 0 4px black; color:#4CAF50;  text-align:center; text-decoration:blink; font:18pt Impact; ">
				Display Book
				
			</h2>
			
			<div class="issue">
					<form action="display_by_student.php" method ="post">
						
						Student Id:		<input   class="inputs"  type="text" name="Student_id" value="<?php echo htmlspecialchars($student_id); ?>" /> <br />
							
						<div class="space">
							<div class="button">
								<input type="submit" name="submit" value="Display" />
							</div>
						</div>
					</form>
				</div>
			<table>
					<tr>
						
						<th>Student Name</th>
						<th>Book Id</th>
						<th>Issue Date</th>
						<th>Return Date</th>
						<th>Due Date</th>
					</tr>
					<?php
						global $result;
						if($result){
							while($display = mysqli_fetch_assoc($result))
							{
					?>
					
					<tr>
						<td><?php echo ucfirst($display['name']); ?> </td>
						<td><?php echo ucfirst($display['book_id']); ?></td>
						<td><?php echo ucfirst($display['issue_date']); ?></td>
						<td><?php echo ucfirst($display['return_date']); ?></td>
						<td><?php echo ucfirst($display['due_date']); ?></td>
					
			
					</tr>
					<?php
							}
						}
					?>
			</table>
				<div class="error" >
						<?php
							echo form_errors($errors);
							?>
				</div>			
		</div>			
		</div>
</div>
</body>
</html>
<?php
	//5. Close database connection
	mysqli_close($connection);

?>