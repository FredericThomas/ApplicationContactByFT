<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" type="text/css" href="css\bs\bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css\bs\bootstrap-datepicker.css">
		<link rel="stylesheet" type="text/css" href="css\bs\jquery-ui.css">
		<script type="text/javascript" language="javascript" src="js\bs\jquery-3.3.1.js"></script>
		<script type="text/javascript" language="javascript" src="js\bs\jquery-ui.js"></script>
		

		<script type="text/javascript" class="init">
		
			$(document).ready(function() {
				$( "#date_de_naissance" ).datepicker({
					altField: "#datepicker",
					closeText: 'Fermer',
					prevText: 'Précédent',
					nextText: 'Suivant',
					currentText: 'Aujourd\'hui',
					monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
					monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
					dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
					dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
					weekHeader: 'Sem.',
					dateFormat: 'yy-mm-dd'
				});
			} );

		</script>


        <title>Fiche contacts</title>
		
		
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
			
			<?php

			/*$email = 'test@example.com';
			 
			// Vérifie si la chaine ressemble à un email
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo 'Cet email est correct.';
			} else {
				echo 'Cet email a un format non adapté.';
			}*/
			$ok_c = false;
			if(!empty($contact)){
				$ok_c=true;
			}
			
			
			?>
			@if (!empty($error))
				<div class="alert alert-danger">
					{{ $error }}
				</div>
			@endif
			<form action="{{ url('contactfichesave') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="prenom">Prénom</label>
					<input type="text" class="firstmaj form-control" name="prenom" id="prenom" value="<?php if($ok_c) echo $contact['prenom']; ?>">
				</div>
				<div class="form-group">
					<label for="nom">Nom</label>
					<input type="text" class="firstmaj form-control" name="nom" id="nom" value="<?php if($ok_c) echo $contact['nom']; ?>">
				</div>
				<div class="form-group">
					<label for="service">Service</label>
					<input type="text" class="form-control" name="service" id="service" value="<?php if($ok_c) echo $contact['service']; ?>">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="exemple@exemple.com" value="<?php if($ok_c) echo $contact['email']; ?>">
				</div>
				<div class="form-group">
					<label for="telephone">Téléphone</label>
					<input type="text" class="form-control" name="telephone" id="telephone" value="<?php if($ok_c) echo $contact['telephone']; ?>">
				</div>
				
				<div class="form-group">
					<label for="date_de_naissance">Date de naissance</label>
					<input type="text" class="form-control" name="date_de_naissance" id="date_de_naissance" value="<?php if($ok_c) echo $contact['date_de_naissance']; ?>">
				</div>
				
				<div class="form-group">
					<label for="adresse">Adresse</label>
					<input type="text" class="form-control" name="adresse" id="adresse" value="<?php if($ok_c) echo $contact['adresse']; ?>">
				</div>
				<div class="form-group">
					<label for="code_postal">Code postal</label>
					<input type="text" class="form-control" name="code_postal" id="code_postal" value="<?php if($ok_c) echo $contact['code_postal']; ?>">
				</div>
				<div class="form-group">
					<label for="ville">Ville</label>
					<input type="text" class="form-control" name="ville" id="ville" value="<?php if($ok_c) echo $contact['ville']; ?>">
				</div>
				<div class="form-group">
					<input type="hidden" name="id_contact" value="<?php if($ok_c) echo $contact['id']; ?>">
					<input type="submit" class="btn btn-primary" id="btnEnregistrer" value="Enregistrer">
				</div>
				 
			</form>
			
			

            </div>
        </div>
    </body>
</html>
<script type='text/javascript'>
	$( ".firstmaj" ).keyup(function() {
		$str = $(this).val();
		$str = $str[0].toUpperCase() + $str.substring(1).toLowerCase();
	  $(this).val($str);
	});

</script>