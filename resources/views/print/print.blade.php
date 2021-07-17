@extends('layout.index')
@section('nav-items')
<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="{{url('/agentp-edit-profil' . $LoggedUserInfo['id'])}}"><i class="align-middle me-1 fas fa-fw fa-user"></i> Modifier Profile</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{route('logout')}}"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Se deconnecter</a>
</div>
@endsection
@section('Sidebar')
<ul class="sidebar-nav">
	<li class="sidebar-item">
		<a href="{{route('clientListagentp')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-list-alt"></i> <span class="align-middle">Liste des clients</span>
		</a>
	</li>

	<li class="sidebar-header">
		Metier
	</li>
	<li class="sidebar-item">
		<a class="sidebar-link collapsed" href="{{route('printeragentp')}}">
			<i class="align-middle me-2 fas fa-fw fa-print"></i> <span class="align-middle">Impression des chèques</span>
		</a>
	</li>
	<li class="sidebar-header">
		Pramètres d'utilisateur
	</li>
	<li class="sidebar-item">
		<a href="{{url('/agentp-edit-profil' . $LoggedUserInfo['id'])}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-user-alt"></i> <span class="align-middle">Modifier mes informations</span>
		</a>
	</li>
	<li class="sidebar-item ">
		<a href="{{route('logout')}}" class="sidebar-link collapsed">
			<i class="align-middle me-2 fas fa-fw fa-arrow-alt-circle-right"></i> <span class="align-middle">Se Deconnecter</span>
		</a>
	</li>
</ul>
	
@endsection
@section('page-body')

<head>
<link href="css/checkcss.css" rel="stylesheet">
<style type="text/css" media="print">
	@page { size: landscape; }
	* {
		  -webkit-print-color-adjust: exact !important;
	  }
  </style>
</head>
<form action="" method="post">
	
	<div class="card">
		<!-- js script for printing "print me div" -->
    <script>
    function printDiv(divName){
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    }
		</script>
	  <div class="card-body">
		  <!-- printed div -->
		<div id='printMe'>
		<!-- php getting infos from printer.blade.php -->
	<?php
		$name = $_POST["name"];
		$lastname = $_POST["lastname"];
		$add = $_POST["add"];
		$mn = $_POST["mn"];
		$stringOutput = $_POST["stringOutput"];
		$datenaiss = $_POST["date_naiss"];
		$memo = $_POST["memo"];
	?>
	<!-- css linking -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

<!-- check body with css bcs printing won't work with class methode -->
  <div style="float: left; background-color: #cde7f0; height: 291px; width: 67%; border-radius: 0; font-family: arial, unicode, ms-century;color: #111;padding: 5px;font-family: monospace, arial, sans-serif, helvetica;font-size: 10pt;border:4px solid #006699;" >
    <div class="check-bank">
      <img src="img/armadillo_fullt.png" alt="" style="margin-bottom: 8px;height: 40px;">
    </div>
	<span style="font-style:oblique;">Montant en lettre:</span>
	<span style="margin: 26%; font-style:oblique;">Montant en chiffres:</span>
    <div style="  float:right; margin-top:-15px; clear:both; background-color:#FFF; color:#111; padding:1px 10px; border:1px solid #006699;"><?php echo $mn;?> MAD</div>
    <div style=" border-bottom:1px #111 solid; margin-bottom:10px; width: 280px; max-width:280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
	<?php echo $stringOutput;?> DIRHAM</div> 
	<span style="font-style:oblique;">Nom :</span>
	<span style="margin-left: 55%;font-style: oblique;">signature :</span>
    <div style="border-bottom:1px #111 solid; margin-bottom: 9px;">
      <span><?php echo $name."&nbsp".$lastname;?></span>
      <span style="font-family:mistral;font-size:14pt;float:right;margin-right:10%;"><?php echo $name."&nbsp".$lastname;?></span>
    </div>
	<span style="font-style:oblique;">Nom de beneficiaire :</span>
	<div style="border-bottom:1px #111 solid; width: 194px;">
      <span><?php echo $memo;?></span>
    </div>
    <br />
    <div style="margin-top: -10px;width: 87%;float: left;font-size: 10pt;margin-right: 10px;">
      <div ><b style="font-style:oblique;">Addresse :</b><br /><?php echo $add;?></div>
    </div>
	<div style="margin-top: -39px;width: 34%;float: right;font-size: 10pt;margin-right: 92px;">
      <div><b style="font-style:oblique;">Date :</b><br /> <?php echo $datenaiss;?></div>
    </div>
	<div style="margin-top: 7px;width: 87%;float: left;font-size: 10pt;margin-right: 10px;">
      <div ><b style="font-style:oblique;">RIB :</b><?php echo $rib;?></div>
    </div>
  </div>
</div>

	</div>
	</div>


<!-- buttons -->
	<button onclick="printDiv('printMe')" class="btn btn-success">Inprimer le cheque</button>
	<a href="javascript:history.back()" class="btn btn-primary"">Modifier</a>
	<a href='{{ URL::previous() }}' class="btn btn-info">nouveau cheque</a>


  </form>
  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- end scripts -->
	


@endsection

