
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>  View TMC</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	</head>
	<body>
		<div class="container">
			<h1 class="text-primary text-center">Temporary Medical Centre</h1>
			<div class="form-group"  id="blkid">
            			<p>
				<a href="/tmc" class="btn btn-primary "> Back  </a>
			</p>
				<label for="block">Select Block </label>
				<select name="block" id="block" class="form-control" required data-error="Please Select Block"  onchange="readRecord()">
					<option value="" selected="" disabled=""> -- Select  Block -- </option>
					<option value="2601" >BHAWANIPATNA</option>
					<option value="2602">KARLAMUNDA</option>
					<option value="2603">KESINGA</option>
					<option value="2604">LANJIGARH</option>
					<option value="2605">MADANPUR-RAMPUR</option>
					<option value="2606">NARLA</option>
					<option value="2607">THUAMUL-RAMPUR</option>
					<option value="2608">DHARAMGARH</option>
					<option value="2609">GOLAMUNDA</option>
					<option value="2610">JAIPATNA</option>
					<option value="2611">JUNAGARH</option>
					<option value="2612">KALAMPUR</option>
					<option value="2613">KOKSARA</option>
                    <option value="2701" >BHAWANIPATNA-MPL</option>
					<option value="2702">JUNAGARH-NAC</option>
					<option value="2703">KESINGA-NAC</option>
					<option value="2704">DHARMAGARH-NAC</option>
				</select>
			</div>
			
			<div id="record_contain">
			</div>

		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function readRecord(){
				var bcd=$('#block').val();
				$.ajax({
					url:"getMigrants.php",
					type:'POST',
					data:{bcode_tmc:bcd},
					success:function(data,status){
						$('#record_contain').html(data);
					}
				});
			}
		</script>
	</body>
</html>