<html>
<title>Sistema Upload | Hospital</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
<link href="globe.png" rel="shortcut icon">
<?php
date_default_timezone_set("America/Sao_Paulo");

?>

<?php
include('dbcon.php');
if(isset($_POST['submit'])!=""){
   $name=$_FILES['photo']['name'];

  $size=$_FILES['photo']['size'];
  $type=$_FILES['photo']['type'];
  $temp=$_FILES['photo']['tmp_name'];
  $error = $_FILES['photo']['error'];
  $date = date('Y-m-d H:i:s');


if ($error > 0) //Check file upload has error
    {
	$_SESSION['alert'] = "danger";
    $_SESSION['result'] = "<strong>Erro:</strong> " . $error . "<br />"; //Sesssio to carry error 
    }
  else{
	  
	  if ($size > 500000) { //Check File Size
	  $_SESSION['alert'] = "danger";
    $_SESSION['result'] = "<strong>Erro:</strong> Tamanho máximo do arquivo 5MB!!!<br />";
	  }else{
		  $targetPath = "files/".$name;
		  
		  if(file_exists($targetPath)){  // Check whether the file name already exist in the server.
					$rename_file= rand(01,1000).$name; //Rename the current file
					$targetPath = "files/".$rename_file;
				}else{
				$rename_file = 	$name;
				}
  move_uploaded_file($temp,$targetPath);

/******** Query para Cadastrar no banco de dados (By Fiuza)******/
$query=$conn->query("INSERT INTO upload (name,rename_file,date) VALUES ('$name','$rename_file','$date')");

if($query){

  $_SESSION['result'] = "<strong>Tudo certo! </strong> Arquivo enviado com sucesso!!!";
	$_SESSION['alert'] = "success";
  header('Location: index.php');
	exit();
  
}
else{
  die(mysqli_error());
}
	  }
  }
}
?>


<html>
<body>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"/>
</head>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/bootstrap.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>
<script type="text/javascript">

$(document).on('click', '.browse', function(){
  var file = $(this).parent().parent().parent().find('.file');
  file.trigger('click');
});
$(document).on('change', '.file', function(){
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});

</script>

<!---******** LOCAL DO CSS DA TABELA da index (By Fiuza)******---->
  <style>
    .table tr th{
      
      border:#eee 1px solid;
      
      position:relative;
      font-family:"Times New Roman", Times, serif;
      font-size:12px;
      text-transform:uppercase;
      }
      table tr td{
      
      border:#eee 1px solid;
      color:#000;
      position:relative;
      font-family:"Times New Roman", Times, serif;
      font-size:12px;
      
      text-transform:uppercase;
      }
      
    .file {
      visibility: hidden;
      position: absolute;
    }

    /******** CSS DA PAGINA INDEX *******/
    body {
      background-color: #EEEEEE;
      margin: -18px 0 0 0;
    }

    .container {
      background-color: #fff;
      padding: 40px 80px;
      border-radius: 8px;
    }

    .menu {
      background-color: #fff;
      padding: 20px 0px;
      border-radius: 8px;
      text-align: left;
    }

    .font_menu{
      color: #fff;
      font-size: 1.7rem;
      font-weight: 500;
      margin: 0 0 0 0;
      background: -webkit-linear-gradient(#fff, #999);
      -webkit-background-clip: text;
      /*-webkit-text-fill-color: transparent;*/
      text-align: center;
    }

    h1 {
      color: #000066;
      font-size: 4rem;
      font-weight: 900;
      margin: 0 0 5px 0;
      background: -webkit-linear-gradient(#fff, #999);
      -webkit-background-clip: text;
      /*-webkit-text-fill-color: transparent;*/
      text-align: center;
    }

    h4 {
      color: #a990cc;
      font-size: 24px;
      font-weight: 400;
      text-align: center;
      margin: 0 0 35px 0;
    }

    .btn.btn-primary {
      background-color: #6E1F1F;
      border-color: #6E1F1F;
      outline: none;
    }
    .btn.btn-primary:hover {
      background-color: #923737;
      border-color: #923737;
    }
    .btn.btn-primary:active, .btn.btn-primary:focus {
      background-color: #6E1F1F;
      border-color: #6E1F1F;
    }
    .alert-purple { border-color: #694D9F;background: #694D9F;color: #fff; }
    .alert-info-alt { border-color: #B4E1E4;background: #81c7e1;color: #fff; }
    .alert-danger-alt { border-color: #B63E5A;background: #E26868;color: #fff; }
    .alert-warning-alt { border-color: #F3F3EB;background: #E9CEAC;color: #fff; }
    .alert-success-alt { border-color: #19B99A;background: #20A286;color: #fff; }
    .glyphicon { margin-right:10px; }
    .alert a {color: gold;}
  </style>

  <br>

<div class="container">
<!--Titulo topo da Pagina-->
   <h1>Sistema Upload <img src="fonts/img/logo-site.png"></h1>

   <!--Menu da Pagina-->
  <div class="menu">
    <div class="font_menu">
      <a href="index.php" class="btn btn-primary "><div class="font_menu">HOME</div></a> | 
      <a href="index.php" class="btn btn-primary "><div class="font_menu">PAINEL ADMIN</div></a>  
    </div>
  </div>

  <form enctype="multipart/form-data"  action="" id="wb_Form1" name="form" method="post">
  <div class="form-group">
    <input  type="file" name="photo" id="photo" class="file">
    <div class="input-group col-xs-12">
      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
      <input type="text" class="form-control input-lg" disabled placeholder="Buscar Arquivo">
      <span class="input-group-btn">
        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i>Procurar arquivo</button>
      </span>
    </div>
  </div>
   <div class="form-group">
    <div class="input-group ">
   <input type="submit" class="btn btn-success" name="submit" value="Enviar">
   </div>
   </div>
 </form> 




 <div class = "row">
 <?php if(isset($_SESSION['result'])){ ?>
<div class="alert alert-<?php echo $_SESSION['alert'] ?>-alt alert-dismissable">
                <span class="glyphicon glyphicon-certificate"></span>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×</button> <?php echo $_SESSION['result']; ?>
					
					</div>
 <?php  unset($_SESSION['result']);   unset($_SESSION['alert']);   }  ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">


							<form method="post" action="delete.php" >
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-condensed" id="example">
                            <thead>
                                <tr>
                                    <th><center>ID.IMG</th>
                                    <th><center>Nome do Arquivo</th>
                                    <th><center>Data</th>
                                    <th><center>Download</th>
                                    <th><center>Remover</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php 
							$i=0;
							$query=mysqli_query($conn,"select * from upload ORDER BY id DESC") or die(mysqli_error());
							while($row=mysqli_fetch_array($query)){
							$id=$row['id'];
							$name=$row['name'];
							$date=$row['date'];
							?>
                              
										<tr>
										<td><?php echo ++$i; ?></td>
                                
                                         <td><?php echo $row['name'] ?></td>
                                         <td><?php echo $row['date'] ?></td>
										<td><center><a href="download.php?filename=<?php echo $row['rename_file'];?>"  title="click to download"><label class="btn btn-success" style="width: 40px;font-size: 16px;"><span class="glyphicon glyphicon-download"></span></label></a></td>
										<td><center><a href="delete.php?del=<?php echo $row['id']?>"><label style="width: 40px;font-size: 16px;" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></label></a></td>
										</tr>
                         
						          <?php } ?>
								</tbody>
								</table>
						
                              
                               
								
                            </div>
          
</form>

        </div>
        </div>
        </div>
  </div>


</body>
</html>


