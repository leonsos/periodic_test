<?php
//I create a class where I put the data for the connection with the database
class Model{
	protected $host='localhost';
    protected $username='root';
    protected $password='';
    protected $database='test_periodic';
    protected $connection;
	//in the constructor method I make the connection to the database
	public function __construct()
    {
        try {
			$this->connection= new PDO ("mysql:host=$this->host;dbname=$this->database",$this->username, $this->password,                			
			);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, 
			PDO::ERRMODE_EXCEPTION);                
            } catch (PDOException $e) {
			echo "Connection failed: " 
			. $e->getMessage();            
            }
    }
	//in the AllCountries method I get all the countries that are going to be loaded in the subsequent select
	public function AllCountries()
    {        
        $select_stmt=$this->connection->prepare('SELECT * FROM `countries`');
        $select_stmt->execute();
        $data=$select_stmt->fetchAll();       
        return $data;
    }
	//in the AllCountries method I get all the data that will be loaded in the subsequent select
	public function AllSearchEngine()
    {        
        $select_stmt=$this->connection->prepare('SELECT * FROM `search_engine`');
        $select_stmt->execute();
        $data=$select_stmt->fetchAll();       
        return $data;
    }
	//in the InsertDb method the data is inserted into the database
	public function InsertDb($name,$email,$password,$address1,$address2,$address3,$towm_city,$where_heard,$where_heard_other,$county,$country,$terms){
		$select_stmt=$this->connection->prepare('INSERT INTO `user` (name,email,password,address1,address2,address3,county,town_city,country,where_heard,where_heard_other,terms) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
        $select_stmt->execute(array($name,$email,$password,$address1,$address2,$address3,$county,$towm_city,$country,$where_heard,$where_heard_other,$terms));
	}
	//in the checkEmail method it is verified if there are records with the email passed by parameter
	public function checkEmail($email){
		$select_stmt=$this->connection->prepare("SELECT count(id) FROM `user` WHERE email='$email'");
        $select_stmt->execute();
        $data=$select_stmt->fetchColumn();       
        return $data;
	}
}
//instantiating the model class
$model = new Model();
if ($_POST) {	
	if ($_POST['where_heard_other']!='') {
		$where_heard_other = $_POST['where_heard_other'];
	}else{
		$where_heard_other = 'null';
	}
	if ($_POST['where_heard']!='') {
		$where_heard = $_POST['where_heard'];
	}

	if (strlen($_POST['towm_city'])>2 && strlen($_POST['towm_city'])<49) {
		$towm_city = $_POST['towm_city'];		
	}else{
		echo "towm_city invalid";		
	}
	//validator characters county
	if (strlen($_POST['country'])>2 && strlen($_POST['country'])<49) {
		$country = $_POST['country'];		
	}else{
		echo "country invalid";		
	}
	//validator characters county
	if (strlen($_POST['county'])>2 && strlen($_POST['county'])<49) {
		$county = $_POST['county'];		
	}else{
		echo "county invalid";		
	}
	//validator characters name
	if (strlen($_POST['name'])>2 && strlen($_POST['name'])<49) {
		$name = $_POST['name'];		
	}else{
		echo "name invalid";		
	}
	// validator characteres password
	if (strlen($_POST['password'])>5 && strlen($_POST['password'])<19) {
		$password = password_hash($_POST['password'],PASSWORD_DEFAULT);		
	}else{
		echo "password invalid";		
	}
	//validator confirm password is the same
	if ($_POST["password"] === $_POST["confirm_password"]) {
		$confirm_password = $_POST['confirm_password'];
	 }
	 else {?><script>
			alert("Passwords do no match");
		</script><?php		
	 }	
	//validator email address
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email format";
	}else{
		$email = $_POST['email'];
	}
	//validator characters address1
	if (strlen($_POST['address1'])>3 && strlen($_POST['address1'])<49) {
		$address1 = $_POST['address1'];		
	}else{
		echo "addres 1 invalid";	
	}
	//validator characters address2
	if (strlen($_POST['address2'])>3 && strlen($_POST['address2'])<49) {
		$address2 = $_POST['address2'];		
	}else{
		echo "addres 2 invalid";	
	}
	//validator characters address3
	if (strlen($_POST['address3'])>3 && strlen($_POST['address3'])<49) {
		$address3 = $_POST['address3'];		
	}else{
		echo "addres 3 invalid";	
	}
	if ($_POST['terms']) {
		$terms = $_POST['terms'];
	}
	if ($address1!='' && $address2!='' && $address3!='' && $county!='' && $country!='' && $terms!='' && $where_heard!='' && $where_heard_other!= '' && $name!='' && $password!=''){
		$rows = $model->checkEmail($email);
		if($rows!=0){?>
			<script>alert("this email is realy exist tri again")</script>;
			<?php
			}else{
				$model->InsertDb($name,$email,$password,$address1,$address2,$address3,$towm_city,$where_heard,$where_heard_other,$county,$country,$terms);				
				header("Location: success.php");
				exit();				
			}
	}	
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">    
    <title>php test</title>
  </head>
  <body>      
  <section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4 text-center" style="color: #7611f7;">Register</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off" action="register.php">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Name</label>
									<input id="name" type="text" class="form-control" name="name" value="" required autofocus>
									<div class="invalid-feedback">
										Name is required	
									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="password">Confirm password</label>
									<input id="password" type="password" class="form-control" name="confirm_password" required>
								    <div class="invalid-feedback">
								    	confirm password dont match
							    	</div>
								</div>

								<!-- <p class="form-text text-muted mb-3">
									By registering you agree with our terms and condition.
								</p> -->
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Address 1</label>
									<input id="name" type="text" class="form-control" name="address1" value="" required autofocus>
									<div class="invalid-feedback">
										Address 1 is invalid
									</div>
								</div>
								
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Address 2</label>
									<input id="name" type="text" class="form-control" name="address2" value="" required autofocus>
									<div class="invalid-feedback">
										Address 2 is invalid
									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Address 3</label>
									<input id="name" type="text" class="form-control" name="address3" value="" required autofocus>
									<div class="invalid-feedback">
										Address 3 is invalid
									</div>
								</div>
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">County</label>
									<input id="name" type="text" class="form-control" name="county" value="" required autofocus>
									<div class="invalid-feedback">
										County is invalid
									</div>
								</div>
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Towm/City</label>
									<input id="name" type="text" class="form-control" name="towm_city" value="" required autofocus>
									<div class="invalid-feedback">
										towm/city is invalid
									</div>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Contry</label>
									<select class="form-select" aria-label="Default select example" required name="country" required>
										<option selected for="invalidCheck" value="">Open to select country</option>
										<?php								
											$rows = $model->AllCountries();
											if (!empty($rows)) {
												foreach ($rows as $row) {?>
													<option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
												<?php
												}
											}
										?>										
									</select>	
									<div class="invalid-feedback">
										towm/city is invalid
									</div>								
								</div>	

								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Where heard</label>
									<select class="form-select" name="where_heard" onchange="checkSelect(this)" aria-label="Default select example" required>
										<option selected value="" for="invalidCheck">Open to selectWhere heard</option>
										<?php						
											$rows = $model->AllSearchEngine();
											if (!empty($rows)) {
												foreach ($rows as $row) {?>
													<option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
												<?php
												}
											}
										?>										
									</select>									
								</div>	

								<div class="mb-3" id="other" style="display: none;">
									<label class="mb-2 text-muted" for="name">Where heard other</label>
									<input  type="text" class="form-control" name="where_heard_other" value="" autofocus>
									<!-- <div class="invalid-feedback">
										Address 1
									</div> -->
								</div>

								<div class="mb-3">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="termCheck" required name="terms" onclick="check()">
											<label class="form-check-label" for="invalidCheck">
												Agree to terms and conditions
											</label>										
									</div>
								</div>

								<div class="align-items-center d-flex">
									<button type="submit" class="btn btn-primary ms-auto w-100 shadow-lg" value="" name="btnSubmit">
										Register	
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center" >
								Already have an account? <a href="index.html" class="text-dark" style="color: #7611f7;">Login</a>
							</div>
						</div>
					</div>
					<!-- <div class="text-center mt-5 text-muted">
						Copyright &copy; 2017-2021 &mdash; Your Company 
					</div> -->
				</div>
			</div>
		</div>
	</section>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../js/login.js"></script>
	
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>