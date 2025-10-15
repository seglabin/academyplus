<?php

namespace App\Http\Controllers;
use App\Models\role;
use App\Models\user;
use Illuminate\Http\Request;

class RoleController extends Controller
{

   public function index(Request $request)
      {   //dd($request);
       try {

               $donnees = Role::orderBy('name')->get();

                session(['config' => 'role']);
               return view('liste', compact('donnees'
                                               ));
           } catch (\Exception $e) {
               return redirect()->route('role')->with('error', 'Une erreur est survenue lors du chargement de la page.');
           }
      }


      public function formModif(Request $request,$id)
          {
              $request['idenreg'] = $id;
             return $this->form($request) ;
          }

      public function form(Request $request)
          {
          $idenreg = $request['idenreg'];
          session(['config' => 'role']);

          $lenregistrement = ($idenreg!= null)?Role::find($idenreg):null;
              return view('parametres.formParam', compact('lenregistrement','idenreg'
                                  ));
          }


      public function enregistrer(Request $request)
      { //dd($request);
          try {

              $id = $request->input('idenreg');
              if( $id  == 0|| $id== null) {
               $doub = role::where('name',$request->name);
                      $e = new Role();
                  }else{
                   $doub = role::where('name',$request->name)
                                  ->where('id','!=',$id)
                                  ->get();
                      $e = role::findOrFail($id);
                  }
//dd($doub);
               if($doub){
//`designation`, `contact`, `email`, `adresse`
              $e->name = $request->name;
              $e->code = $request->code;

              $e->save();//die();
              return redirect()->route('role');
              }else{
              $info = "Le profil que vous tentez d'enregistrer existe déjà";
              $titre = "DOUBLON";
              return view('alertDoublon', compact('info','titre'   ));
              }
          } catch (\Exception $e) {
              return redirect()->route('role')->with('error', 'Une erreur est survenue lors de l\'enregistrement du profil.' . $e);
          }
      }

      public function supprimer($id)
      {
          try {
          //Controle de possibilité de suppression
          $v = user::where('idrole',$id)->get();
           if(count($v) == 0){
              $e = role::findOrFail($id);
              //dd($e);
              $e->delete();

              return redirect()->route('role');
              }else{
               $info = "Le profile que vous tentez de supprimer est lié à au moins un utilisateur \n Vous ne pouvez donc pas le supprimer";
                   $titre = "CONTRAINTE D'INTEGRITE";
                     return view('alertDoublon', compact('info','titre'   ));
              }
          } catch (\Exception $e) { dd($e);
              return redirect()->route('client')->with('error', 'Une erreur est survenue lors de la suppression de l\'enregistrement.');
          }
      }
}
