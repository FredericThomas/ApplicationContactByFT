<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
		<link rel="stylesheet" type="text/css" href="css\bs\bootstrap.css">
		
		<script type="text/javascript" language="javascript" src="js\bs\jquery-3.3.1.js"></script>
		<script type="text/javascript" language="javascript" src="js\bs\jquery.dataTables.min.js"></script>
		<script type="text/javascript" language="javascript" src="js\bs\dataTables.select.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css\bs\jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="css\bs\select.dataTables.min.css">
		
		<script type="text/javascript" class="init">
	
$(document).ready(function() {
	$('#contact_liste').DataTable( {
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    } );
} );

	</script>
		
        <title>Liste des contacts</title>

		
		
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

			<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
				<form action="{{ url('contactfiche') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" id="contact_id" name="contact_id" value="0">
				<input type="hidden" id="btn_event" name="btn_event" value="">
                <div class="btn-group" role="group" aria-label="Basic example">
				  <button type="submit" class="btn_contact btn btn-primary" id="ajouter_contact">Ajouter</button>
				  <button type="submit" class="btn_contact btn btn-primary" id="modifier_contact">Modifier</button>
				  <button type="submit" class="btn_contact btn btn-primary" id="supprimer_contact">Supprimer</button>
				</div>
				</form>
				<div class="btn-group" role="group" aria-label="Basic example">
				  <button type="button" onclick="location.href='{{ url('xlsxdll')}}'" class="btn btn-success">Exporter en XLSX</button>
				</div>
			</div>
				<table id="contact_liste" class="stripe cell-border" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th scope></th>
							<th scope>Prénom</th>
							<th scope>Nom</th>
							<th scope>Service</th>
							<th scope>Email</th>
							<th scope>Téléphone</th>
							<th scope width="18%">Date de naissance</th>
							<th scope>Adresse</th>
							<th scope>Code postal</th>
							<th scope>Ville</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($liste_contacts as $liste_contact) {
								echo '<tr>';
								echo '<td scope="row"><input type="hidden" class="id_contact" value="'.$liste_contact->id.'"></td>';
								echo '<td scope>'.$liste_contact->prenom.'</td>';
								echo '<td scope>'.$liste_contact->nom.'</td>';
								echo '<td scope>'.$liste_contact->service.'</td>';
								echo '<td scope>'.$liste_contact->email.'</td>';
								echo '<td scope>'.$liste_contact->telephone.'</td>';
								echo '<td scope>'.$liste_contact->date_de_naissance.'</td>';
								echo '<td scope>'.$liste_contact->adresse.'</td>';
								echo '<td scope>'.$liste_contact->code_postal.'</td>';
								echo '<td scope>'.$liste_contact->ville.'</td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
                
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$( ".btn_contact" ).click(function() {
		var btn_select = this.id;
		var id_contact;
		if(btn_select == "ajouter_contact")
		{
			id_contact=0;
		}
		else{
			id_contact = $( ".selected" ).find(".id_contact").val();
		}
		$("#btn_event").val(btn_select);
		$("#contact_id").val(id_contact);
		
	});
</script>
