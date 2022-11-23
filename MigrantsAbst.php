<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Migrant List</title>
	 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	</head>
	<body>
		<div class="container">
			<h1 class="text-primary text-center">Migrants   Abstract</h1>
            <p>
				<a href="/tmc" class="btn btn-info "> Back  </a>
				<a href="MigrantsList.php" class="btn btn-primary float-right">View Detail </a>
			</p>
          

		<div id="abstract" ></div>
		</div>
		<div class="container-fluid">	
			<div id="record_contain">
			</div>
        </div>
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		//
       $(document).ready(function(){
		var abcode='abstract';
		$.ajax({
		url:"getTMC.php",
		type:'POST',
		data:{abcode:abcode},
		success:function(data,status){
		$('#abstract').html(data);
		}
		});
		});
		//

		</script>
	</body>
</html>