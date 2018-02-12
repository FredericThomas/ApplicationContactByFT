<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Faker;
use DB;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;

use \Illuminate\Http\RedirectResponse;


class Contact extends Controller {

    public function CreateContactRandom()
    {
		
		
        //Faker
		// use the factory to create a Faker\Generator instance
		$faker = Faker\Factory::create('fr_FR');
		for ($i=0; $i < 10; $i++) {
		  
		    $Prenom = $faker->firstName;
			$Nom = $faker->lastName;
			$Service = $faker->jobTitle;
			$Email = $faker->email;
			$Telephone = $faker->e164PhoneNumber;
			$Date_de_naissance = $faker->date($format = 'Y-m-d', $max = 'now');
			$Adresse = $faker->streetName;
			$Code_postal = $faker->postcode;
			$Ville = $faker->city;
			
			
			//DB
			DB::insert('insert into contact 
						(prenom,nom,service,email,telephone,date_de_naissance,adresse,code_postal,ville)
						values 
						(?, ?, ?, ?, ?, ?, ?, ?, ?)',
						[$Prenom, $Nom, $Service, $Email, $Telephone, $Date_de_naissance, $Adresse, $Code_postal, $Ville]);
			
		}

    }
	
	public function ListeContact()
	{
		//DB
		$users = DB::select('select * from contact');
		return view('liste_contact',['liste_contacts' => $users]);
	}
	public function ExportXlsX()
	{
		//xlsx
		$style = (new StyleBuilder())
           ->setFontBold()
           ->setFontSize(15)
           ->setFontColor(Color::BLACK)
           ->setShouldWrapText()
           ->setBackgroundColor(Color::ORANGE)
           ->build();

		$writer = WriterFactory::create(Type::XLSX);
		$pathToFile = "Sheets\ListeDesContacts.xlsx";
		$writer->openToFile($pathToFile);
		$singleRow = ["Prénom","Nom","Service","Email","Téléphone","Date de naissance","Adresse","Code postal","Ville"];
		$writer->addRowWithStyle($singleRow, $style);		
		$users = DB::select('select * from contact');
		
		foreach ($users as $user) {
			$singleRow = [$user->prenom,$user->nom,$user->service,$user->email,$user->telephone,$user->date_de_naissance,$user->adresse,$user->code_postal,$user->ville];
			$writer->addRow($singleRow);		
		}
		$writer->close();
		return response()->download($pathToFile);
	}
	
	public function FicheContact(Request $request)
	{
		$id_contact = $request->get("contact_id");
		$btn_event = $request->get("btn_event");
		if($btn_event == "modifier_contact")
		{
			$contacts = DB::select('select * from contact where id = ?',[$id_contact]);
			$contact_edit = array();
			foreach ($contacts as $contact) {
				$contact_edit['id'] = $contact->id;
				$contact_edit['prenom'] = $contact->prenom;
				$contact_edit['nom'] = $contact->nom;
				$contact_edit['service'] = $contact->service;
				$contact_edit['email'] = $contact->email;
				$contact_edit['telephone'] = $contact->telephone;
				$contact_edit['date_de_naissance'] = $contact->date_de_naissance;
				$contact_edit['adresse'] = $contact->adresse;
				$contact_edit['code_postal'] = $contact->code_postal;
				$contact_edit['ville'] = $contact->ville;
			}
			return view('fiche_contact',['contact' => $contact_edit]);
		}
		else if ($btn_event == "supprimer_contact")
		{
			//db delete
			DB::delete('delete from contact where id = ?',[$id_contact]);
			return $this->ListeContact();
		}
		else if ($btn_event == "ajouter_contact")
		{
			return view('fiche_contact',['contact' => '']);
		}
	}
	public function EnregistrerContact(Request $request)
	{
		$contact = array();
		$contact['id'] = $request->get('id_contact');
		$contact['prenom'] = $request->get('prenom');
		$contact['nom'] = $request->get('nom');
		$contact['service'] = $request->get('service');
		$contact['email'] = $request->get('email');
		$contact['telephone'] = $request->get('telephone');
		$contact['date_de_naissance'] = $request->get('date_de_naissance');
		$contact['adresse'] = $request->get('adresse');
		$contact['code_postal'] = $request->get('code_postal');
		$contact['ville'] = $request->get('ville');
		if(!empty($contact['prenom'] && $contact['nom'] && $contact['email']))
		{
			if(!empty($id))
			{
				//update
				DB::update('update contact set prenom = ?, nom = ?, service = ?, email = ?, telephone = ?,
											   date_de_naissance = ?, adresse = ?, code_postal = ?,
											   ville = ?  where id = ?', 
											   [$contact['prenom'],$contact['nom'],$contact['service'], 
											   $contact['email'], $contact['telephone'], $contact['date_de_naissance'],
											   $contact['adresse'], $contact['code_postal'],$contact['ville'],$contact['id']]);
			}
			else
			{
				//insert
				DB::insert('insert into contact 
							(prenom,nom,service,email,telephone,date_de_naissance,adresse,code_postal,ville)
							values 
							(?, ?, ?, ?, ?, ?, ?, ?, ?)',
							[$contact['prenom'],$contact['nom'],$contact['service'], 
											   $contact['email'], $contact['telephone'], $contact['date_de_naissance'],
											   $contact['adresse'], $contact['code_postal'],$contact['ville'],$contact['id']]);
			}
			return $this->ListeContact();
			
		}
		else
		{
			return view('fiche_contact',['contact' => $contact, 'error' => 'Nom, Prénom et Email obligatoire.']);
			//return redirect()->back()->withInput()->with('error','Nom, Prénom et Email obligatoire.');
			
		}
		
	}

}
