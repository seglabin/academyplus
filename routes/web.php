<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AnneescolaireController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\ClassetypeController;
use App\Http\Controllers\ClassannescoController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\CoefficientController;
use App\Http\Controllers\ParamfraiController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\CompositionController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\DeconnexionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolepermissionController;
use App\Http\Controllers\AffectationsController;
use App\Http\Controllers\SessionacademiqueController;
use App\Http\Controllers\MoyperiodapprenantsController;
use App\Http\Controllers\MoyenneController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\ImpressionController;
use App\Http\Controllers\MvtfinancierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/accueil', function () {
    // session(['config' => '']);
    return view('public.bienvenue');
})->name('bienvenue');

Route::get('/decouvrir', function () {
    // session(['config' => '']);
    return view('public.presentation');
})->name('decouvrir');

// Route::get('/classes', function () {
//     // session(['config' => '']);
//     return view('Abonnes.listeClasse');
// });

Route::get('/login', function () {
    session(['config' => '']);
    return view('login');
})->name('login');

Route::get('/deconnecter', [DeconnexionController::class, 'deconnecter'])->name('deconnecter');

// Route::get('/cartes', function () {
//     session(['config' => '']);
//     return view('print.cartes');
// })->name('cartes');



Route::post('/connecter', [ConnexionController::class, 'connecter'])->name('connecter');
Route::get('/imprimer', [ImpressionController::class, 'imprimer'])->name('imprimer');
Route::get('/cartes', [ImpressionController::class, 'cartes'])->name('cartes');


Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // ===========-------------Role----------===========
    Route::get('/role', [RoleController::class, 'index'])->name('role');
    Route::get('/ajout-role', [RoleController::class, 'form']);
    Route::get('/modifier-role/{id}', [RoleController::class, 'formModif']);
    Route::POST('/enregistrer-role', [RoleController::class, 'enregistrer']);
    Route::get('/supprimer-role/{id}', [RoleController::class, 'supprimer']);

    // ===========-------------Permission----------===========
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission');
    Route::get('/ajout-permission', [PermissionController::class, 'form']);
    Route::get('/modifier-permission/{id}', [PermissionController::class, 'formModif']);
    Route::POST('/enregistrer-permission', [PermissionController::class, 'enregistrer']);
    Route::get('/supprimer-permission/{id}', [PermissionController::class, 'supprimer']);

    // ===========-------------rolepermission----------===========
    Route::get('/rolepermission', [RolepermissionController::class, 'index'])->name('rolepermission');
    Route::get('/ajout-rolepermission', [RolepermissionController::class, 'form']);
    Route::get('/valider-droitsAcces', [RolepermissionController::class, 'validerDroitsAcces']);
    // Route::POST('/enregistrer-rolepermission', [RolepermissionController::class, 'enregistrer']);
    // Route::get('/supprimer-rolepermission/{id}', [RolepermissionController::class, 'supprimer']);

    // ===========-------------Apprenant----------===========
    Route::get('/apprenant', [ApprenantController::class, 'index'])->name('apprenant');
    Route::get('/ajout-apprenant', [ApprenantController::class, 'form']);
    Route::get('/modifier-apprenant/{id}', [ApprenantController::class, 'formModif']);
    Route::POST('/enregistrer-apprenant', [ApprenantController::class, 'enregistrer']);
    Route::get('/supprimer-apprenant/{id}', [ApprenantController::class, 'supprimer']);

    // ===========-------------Personne----------===========
    Route::get('/personne', [PersonneController::class, 'index'])->name('personne');
    Route::get('/ajout-personne', [PersonneController::class, 'form']);
    Route::get('/modifier-personne/{id}', [PersonneController::class, 'formModif']);
    Route::POST('/enregistrer-personne', [PersonneController::class, 'enregistrer']);
    Route::POST('/enregistrer-personne-modal', [PersonneController::class, 'enregistrerModal']);
    Route::get('/supprimer-personne/{id}', [PersonneController::class, 'supprimer']);

    // ===========-------------Affectation----------===========
    // Route::get('/classe-enseignant', [ApprenantController::class, 'index'])->name('apprenant');
    // Route::get('/ajout-apprenant', [ApprenantController::class, 'form']);
    // Route::get('/modifier-apprenant/{id}', [ApprenantController::class, 'formModif']);
    Route::POST('/enregistrer-affectation', [AffectationsController::class, 'enregistrer']);
    Route::get('/supprimer-affectation/{id}', [AffectationsController::class, 'supprimer']);
    Route::get('/retirer-affectation/{id}', [AffectationsController::class, 'retirer']);

    // ===========-------------Inscription----------===========
    Route::POST('/enregistrer-inscription', [InscriptionController::class, 'enregistrer']);

    // ===========-------------Paiement----------===========
    Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement');
    Route::get('/ajout-paiement', [PaiementController::class, 'form']);
    Route::get('/modifier-paiement/{id}', [PaiementController::class, 'formModif']);
    Route::POST('/enregistrer-paiement', [PaiementController::class, 'enregistrer']);
    Route::POST('/enregistrer-paiement-modal', [PaiementController::class, 'enregistrerModal']);
    Route::get('/supprimer-paiement/{id}', [PaiementController::class, 'supprimer']);

    // ===========-------------mvtfinancier----------===========
    Route::get('/mvtfinancier', [MvtfinancierController::class, 'index'])->name('mvtfinancier');
    Route::get('/ajout-paiement', [MvtfinancierController::class, 'form']);
    Route::get('/modifier-paiement/{id}', [MvtfinancierController::class, 'formModif']);
    Route::POST('/enregistrer-mvtfinancier', [MvtfinancierController::class, 'enregistrerPayer']);
    Route::POST('/enregistrer-payer-par-cotisation', [MvtfinancierController::class, 'enregistrerPayerParCotisation']);
    Route::get('/supprimer-paiement/{id}', [MvtfinancierController::class, 'supprimer']);

    // ===========-------------Gestion des utilisateurs----------===========
    Route::get('/utilisateur', [UtilisateurController::class, 'index'])->name('utilisateur');
    Route::get('/ajout-utilisateur', [UtilisateurController::class, 'form']);
    Route::get('/modifier-utilisateur/{id}', [UtilisateurController::class, 'formModif']);
    Route::POST('/changer-mon-password', [UtilisateurController::class, 'changerPassword']);
    Route::POST('/changer-login', [UtilisateurController::class, 'changerLogin']);
    Route::POST('/reinitialiser-password', [UtilisateurController::class, 'reinitialiserPassword']);
    Route::POST('/enregistrer-utilisateur', [UtilisateurController::class, 'enregistrer']);
    Route::get('/supprimer-utilisateur/{id}', [UtilisateurController::class, 'supprimer']);

    // ===========-------------Anneescolaire----------===========
    Route::get('/changer-anneescolaire', [AnneescolaireController::class, 'ChangerAnnesco'])->name('ChangerAnnesco');
    Route::get('/anneescolaire', [AnneescolaireController::class, 'index'])->name('anneescolaire');
    Route::get('/ajout-anneescolaire', [AnneescolaireController::class, 'form']);
    Route::get('/modifier-anneescolaire/{id}', [AnneescolaireController::class, 'formModif']);
    Route::POST('/enregistrer-anneescolaire', [AnneescolaireController::class, 'enregistrer']);
    Route::get('/supprimer-anneescolaire/{id}', [AnneescolaireController::class, 'supprimer']);

    // ===========-------------Classe type----------===========
    Route::get('/classetype', [ClassetypeController::class, 'index'])->name('classetype');
    Route::get('/ajout-classetype', [ClassetypeController::class, 'form']);
    Route::get('/modifier-classetype/{id}', [ClassetypeController::class, 'formModif']);
    Route::POST('/enregistrer-classetype', [ClassetypeController::class, 'enregistrer']);
    Route::get('/supprimer-classetype/{id}', [ClassetypeController::class, 'supprimer']);

    // ===========-------------Coefficients----------===========
    Route::get('/coefficient', [CoefficientController::class, 'index'])->name('coefficient');
    Route::get('/ajout-coefficient', [CoefficientController::class, 'form']);
    Route::get('/modifier-coefficient/{id}', [CoefficientController::class, 'formModif']);
    Route::POST('/enregistrer-coefficient', [CoefficientController::class, 'enregistrer']);
    Route::get('/supprimer-coefficient/{id}', [CoefficientController::class, 'supprimer']);

    // ===========-------------Matières----------===========
    Route::get('/matiere', [MatiereController::class, 'index'])->name('matiere');
    Route::get('/ajout-matiere', [MatiereController::class, 'form']);
    Route::get('/modifier-matiere/{id}', [MatiereController::class, 'formModif']);
    Route::POST('/enregistrer-matiere', [MatiereController::class, 'enregistrer']);
    Route::get('/supprimer-matiere/{id}', [MatiereController::class, 'supprimer']);

    // ===========-------------paramfrais----------===========
    Route::get('/paramfrais', [ParamfraiController::class, 'index'])->name('paramfrais');
    Route::get('/ajout-paramfrais', [ParamfraiController::class, 'form']);
    Route::get('/modifier-paramfrais/{id}', [ParamfraiController::class, 'formModif']);
    Route::POST('/enregistrer-paramfrais', [ParamfraiController::class, 'enregistrer']);
    Route::get('/supprimer-paramfrais/{id}', [ParamfraiController::class, 'supprimer']);

    // ===========-------------Classe année scolaire----------===========
    Route::get('/classeAbonne', [ClassannescoController::class, 'classeAbonne'])->name('classeAbonne');
    Route::get('/classannesco', [ClassannescoController::class, 'index'])->name('classannesco');
    Route::get('/ajout-classannesco', [ClassannescoController::class, 'form']);
    Route::get('/modifier-classannesco/{id}', [ClassannescoController::class, 'formModif']);
    Route::POST('/enregistrer-classannesco', [ClassannescoController::class, 'enregistrer']);
    Route::get('/supprimer-classannesco/{id}', [ClassannescoController::class, 'supprimer']);

    // ===========-------------Abonnements----------===========
    Route::get('/abonnement', [AbonnementController::class, 'index'])->name('abonnement');
    Route::get('/ajout-abonnement', [AbonnementController::class, 'form']);
    Route::get('/modifier-abonnement/{id}', [AbonnementController::class, 'formModif']);
    Route::POST('/enregistrer-abonnement', [AbonnementController::class, 'enregistrer']);
    Route::get('/supprimer-abonnement/{id}', [AbonnementController::class, 'supprimer']);

    // ===========-------------Evaluation----------===========
    Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluation');
    Route::get('/ajout-evaluation', [EvaluationController::class, 'form']);
    Route::get('/modifier-evaluation/{id}', [EvaluationController::class, 'formModif']);
    Route::POST('/enregistrer-evaluation', [EvaluationController::class, 'enregistrer']);
    Route::get('/supprimer-evaluation/{id}', [EvaluationController::class, 'supprimer']);

    // ===========-------------Evaluation----------===========
    Route::get('/session-academique', [SessionacademiqueController::class, 'index'])->name('sessionacademique');
    Route::get('/ajout-session-academique', [SessionacademiqueController::class, 'form']);
    Route::get('/modifier-session-academique/{id}', [SessionacademiqueController::class, 'formModif']);
    Route::POST('/enregistrer-session-academique', [SessionacademiqueController::class, 'enregistrer']);
    Route::get('/supprimer-session-academique/{id}', [SessionacademiqueController::class, 'supprimer']);

    // ===========-------------Composition----------===========
    Route::get('/composition', [CompositionController::class, 'index'])->name('composition');
    Route::get('/ajout-composition', [CompositionController::class, 'form']);
    Route::get('/modifier-composition/{id}', [CompositionController::class, 'formModif']);
    Route::get('/details-composition/{id}', [CompositionController::class, 'formDetails']);
    Route::POST('/enregistrer-composition', [CompositionController::class, 'enregistrer']);
    Route::get('/supprimer-composition/{id}', [CompositionController::class, 'supprimer']);

    // ===========-------------Moyenne periode----------===========
    Route::get('/moyenne-periode', [MoyperiodapprenantsController::class, 'index'])->name('moyenneperiode');
    Route::get('/moyenne-periode-apprenant', [MoyperiodapprenantsController::class, 'moyenneperiodeapprenant'])->name('moyenneperiodeapprenant');
    Route::get('/moyenne-generale-periode', [MoyperiodapprenantsController::class, 'moyennegeneraleperiode'])->name('moyennegeneraleperiode');
    Route::get('/ajout-moyenne-periode', [MoyperiodapprenantsController::class, 'form']);
    Route::get('/modifier-moyenne-periode/{id}', [MoyperiodapprenantsController::class, 'formModif']);
    Route::get('/details-moyenne-periode/{id}', [MoyperiodapprenantsController::class, 'formDetails']);
    Route::POST('/enregistrer-moyenne-periode', [MoyperiodapprenantsController::class, 'enregistrer']);
    Route::get('/supprimer-moyenne-periode/{id}', [MoyperiodapprenantsController::class, 'supprimer']);

    // ===========-------------Moyenne annuelle----------===========
    Route::get('/moyenne-annuelle', [MoyenneController::class, 'index'])->name('moyenneannuelle');
    Route::get('/ajout-moyenne-annuelle', [MoyenneController::class, 'form']);
    Route::get('/modifier-moyenne-annuelle/{id}', [MoyenneController::class, 'formModif']);
    Route::get('/details-moyenne-annuelle/{id}', [MoyenneController::class, 'formDetails']);
    Route::POST('/enregistrer-moyenne-periode-apprenant', [MoyenneController::class, 'validerMoyPeriodeApprenant']);
    Route::POST('/enregistrer-moyenne-annuelle', [MoyenneController::class, 'enregistrer']);
    Route::get('/supprimer-moyenne-annuelle/{id}', [MoyenneController::class, 'supprimer']);

    // ===========-------------circonscolaires----------===========

    Route::get('/circonscolaire', function () {
        session(['nomtable' => 'circonscolaire']);
        return redirect()->route('element');
    });
    Route::get('/motif', function () {
        session(['nomtable' => 'motif']);
        return redirect()->route('element');
    });
    Route::get('/nationalite', function () {
        session(['nomtable' => 'nationalite']);
        return redirect()->route('element');
    });
    Route::get('/ddemp', function () {
        session(['nomtable' => 'ddemp']);
        return redirect()->route('element');
    });
    Route::get('/sexe', function () {
        session(['nomtable' => 'sexe']);
        return redirect()->route('element');
    });
    Route::get('/motif', function () {
        session(['nomtable' => 'motif']);
        return redirect()->route('element');
    });
    Route::get('/typematiere', function () {
        session(['nomtable' => 'typematiere']);
        return redirect()->route('element');
    });


    Route::get('/element', [ElementController::class, 'index'])->name('element');
    Route::get('/ajout-element', [ElementController::class, 'form']);
    Route::get('/modifier-element/{id}', [ElementController::class, 'formModif']);
    Route::POST('/enregistrer-element', [ElementController::class, 'enregistrer']);
    Route::get('/supprimer-element/{id}', [ElementController::class, 'supprimer']);

});