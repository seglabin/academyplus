@php
  use Illuminate\Support\Facades\DB;
  $tparam = explode('|', 'role|permission|rolepermission|anneescolaire|circonscolaire|classetype|matiere|motif|nationalite|ddemp|sessionacademique|personne');
  $tscolarite = explode('|', 'apprenant|composition|evaluation|paiement|moyenne-annuelle|moyenne-periode|moyenne-generale-periode|moyenne-periode-apprenant|mvtfinancier');
  $tconfig = explode('|', 'abonnement|classannesco|coefficient|paramfrais');
  $tcompte = explode('|', 'utilisateur');


  $stylactive = "style='color:red;'";
  
  $userEncours = (session('userEncours') != null) ? session('userEncours') : null;
  $idanEncours = (session('idanEncours') != null) ? session('idanEncours') : null;
  $idabonnementEncours = (session('idabonnementEncours') != null) ? session('idabonnementEncours') : null;

  $compte = $userEncours != null ? $userEncours->login : "Mon compte";
  
$classannescosEncours = lesclassesAnnesco($userEncours->id, $userEncours->idrole, $idabonnementEncours, $idanEncours);

  //dd($rekclas);
  //dd($classannescosEncours);
@endphp

<style>
  .monactive {
    color: green;
  }
</style>

<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="/" style="{{ session('config') == 'accueil' ? 'color:green; font-weight: bold;' : '' }}"
        class="{{ session('config') == '' ? 'active' : '' }}">Accueil</a></li>
    @if(is_array($menusUser) && in_array(4, $menusUser))
    <li class="dropdown"><a style="{{ session('config') == 'classeAbonne' ? 'color:green; font-weight: bold;' : '' }}"
      href="#"><span>Classes</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
      @foreach ($classannescosEncours as $c)
      <li><a href="#" onclick="afficheClasse('{{ $c->id }}');">{{ $c->sigle }}</a></li>
    @endforeach
      </ul>
    </li>
  @endif
    @if(is_array($menusUser) && in_array(5, $menusUser))
    <li class="dropdown"><a class="{{ in_array(session('config'), $tscolarite) ? 'active' : '' }}"
      href="#"><span>SCOLARITE</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
      @if(is_array($menusUser) && in_array(6, $menusUser))
      <li><a style="{{ session('config') == 'apprenant' ? 'color:green; font-weight: bold;' : '' }}"
      href="/apprenant">Apprenants</a></li>
    @endif
      @if(is_array($menusUser) && in_array(6, $menusUser))
      <li><a style="{{ session('config') == 'mvtfinancier' ? 'color:green; font-weight: bold;' : '' }}"
      href="/mvtfinancier">Cotisation</a></li>
    @endif
    @if(is_array($menusUser) && in_array(7, $menusUser))
      <li><a style="{{ session('config') == 'composition' ? 'color:green; font-weight: bold;' : '' }}"
      href="/composition">Evaluations primaires</a></li>
    @endif
    @if(is_array($menusUser) && in_array(8, $menusUser))
      <!-- <li><a style="{{ session('config') == 'evaluation' ? 'color:green; font-weight: bold;' : '' }}"
      href="/evaluation">Evaluations</a></li> -->
    @endif
    @if(is_array($menusUser) && in_array(9, $menusUser))
      <li><a style="{{ session('config') == 'paiement' ? 'color:green; font-weight: bold;' : '' }}"
      href="/paiement">Paiements</a></li>
    @endif
    @if(is_array($menusUser) && in_array(32, $menusUser))
      <li><a style="{{ session('config') == 'moyenne-periode' ? 'color:green; font-weight: bold;' : '' }}"
      href="/moyenne-periode">Moyenne par matière et par période</a></li>
    @endif
    @if(is_array($menusUser) && in_array(36, $menusUser))
      <li><a style="{{ session('config') == 'moyenne-periode-apprenant' ? 'color:green; font-weight: bold;' : '' }}"
      href="/moyenne-periode-apprenant">Moyenne d'un apprenant par période</a></li>
    @endif
    @if(is_array($menusUser) && in_array(35, $menusUser))
      <li><a style="{{ session('config') == 'moyenne-generale-periode' ? 'color:green; font-weight: bold;' : '' }}"
      href="/moyenne-generale-periode">Moyenne générale par période</a></li>
    @endif
    @if(is_array($menusUser) && in_array(33, $menusUser))
      <li><a style="{{ session('config') == 'moyenne-annuelle' ? 'color:green; font-weight: bold;' : '' }}"
      href="/moyenne-annuelle">Moyenne annuelle</a></li>
    @endif
      </ul>
    </li>
  @endif
    <!-- <li><a href="students-life.html">EVALUATIONS</a></li>
    <li><a href="news.html">SUBVENTIONS</a></li> -->
    @if(is_array($menusUser) && in_array(10, $menusUser))
    <li class="dropdown"><a class="{{ in_array(session('config'), $tconfig) ? 'active' : '' }}"
      href="#"><span>CONFIGURATION</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
      <li><a style="{{ session('config') == 'abonnement' ? 'color:green; font-weight: bold;' : '' }}"
        href="/abonnement">Abonnements</a></li>
      <li><a style="{{ session('config') == 'classannesco' ? 'color:green; font-weight: bold;' : '' }}"
        href="/classannesco">Classes</a></li>
      <li><a style="{{ session('config') == 'coefficient' ? 'color:green; font-weight: bold;' : '' }}"
        href="/coefficient">Coefficents</a></li>
      <li><a style="{{ session('config') == 'paramfrais' ? 'color:green; font-weight: bold;' : '' }}"
        href="/paramfrais">Paramétrage des frais</a></li>
      <!-- <li><a href="faculty-staff.html">Paiements</a></li> -->

      </ul>
    </li>
  @endif
    @if(is_array($menusUser) && in_array(14, $menusUser))
    <li class="dropdown "><a class="{{ in_array(session('config'), $tparam) ? 'active' : '' }}"
      href="#"><span>Paramètres</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
      @if(is_array($menusUser) && in_array(15, $menusUser))  
      <li><a class="" style="{{ session('config') == 'role' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/role">Profil
        utilisateur</a></li>
      @endif  
      @if(is_array($menusUser) && in_array(16, $menusUser))
      <li><a class="" style="{{ session('config') == 'permission' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/permission">Fonctionnalités </a></li>
      @endif  
      @if(is_array($menusUser) && in_array(17, $menusUser))
      <li><a class="" style="{{ session('config') == 'rolepermission' ? 'color:green;  font-weight: bold;' : '' }}"
        href="#" onclick="afficheDroitAcces();">Droits d'accès </a></li>
      @endif  
      @if(is_array($menusUser) && in_array(18, $menusUser))
      <li><a class="" style="{{ session('config') == 'anneescolaire' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/anneescolaire">Année scolaire</a></li>
      @endif 
      @if(is_array($menusUser) && in_array(19, $menusUser)) 
      <li><a class="" style="{{ session('config') == 'circonscolaire' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/circonscolaire">Circonscriptions scolaires</a></li>
      @endif
      @if(is_array($menusUser) && in_array(20, $menusUser))  
      <li><a class="" style="{{ session('config') == 'classetype' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/classetype">Classes     types</a></li>

      <li><a class="" style="{{ session('config') == 'typematiere' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/typematiere">Type de matière</a></li>
      @endif  
        @if(is_array($menusUser) && in_array(21, $menusUser))
      <li><a class="" style="{{ session('config') == 'matiere' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/matiere">Matières</a>
      </li>
      @endif
      @if(is_array($menusUser) && in_array(22, $menusUser))
      <li><a class="" style="{{ session('config') == 'motif' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/motif">Motifs</a></li>
        @endif
        @if(is_array($menusUser) && in_array(23, $menusUser))
      <li><a class="" style="{{ session('config') == 'nationalite' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/nationalite">Nationalités</a></li>
        @endif
        @if(is_array($menusUser) && in_array(34, $menusUser))
      <li><a class="" style="{{ session('config') == 'personne' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/personne">Personnes</a></li>
        @endif
        @if(is_array($menusUser) && in_array(24, $menusUser))
      <li><a class="" style="{{ session('config') == 'ddemp' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/ddemp">DDEMP</a></li>
        @endif
        @if(is_array($menusUser) && in_array(31, $menusUser))
      <li><a class="" style="{{ session('config') == 'sessionacademique' ? 'color:green;  font-weight: bold;' : '' }}"
        href="/session-academique">Session académique</a></li>
        @endif
      </ul>
    </li>
  @endif
    <li class="dropdown"><a class="{{ in_array(session('config'), $tcompte) ? 'active' : '' }}"
        href="#"><span>{{ $compte }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
        <li>
          <a class="flex items-center " href="#" data-toggle="modal" data-target="#modalChangerPassword"
            title="Changer mot de passe "> Changer mot de passe </a>
        </li>
        @if(is_array($menusUser) && in_array(25, $menusUser))
        <li><a style="{{ session('config') == 'utilisateur' ? 'color:green; font-weight: bold;' : '' }}"
            href="/utilisateur">Gestion des utilisateurs</a></li>
        @endif    
        
        <li><a href="{{ route('deconnecter') }}">Déconnexion</a></li>
      </ul>
    </li>

  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>


<!-- <form id="formNav" action="" method="get"> -->


<!-- </form> -->

<script>
  function afficheClasse(id) {

    // alert(id);
    $('#idclassannescosEncours').val(id);
    $('#module').val('listeApprenant');
    // alert( $('#idclassannescosEncours').val());
    document.forms["myform"].method = 'GET';
    document.forms["myform"].action = '/classeAbonne';
    document.forms["myform"].submit();
  }

  function afficheDroitAcces() {    //alert('Merci');
    $('#module').val('listeProfil');

    document.forms["myform"].method = 'GET';
    document.forms["myform"].action = '/rolepermission';
    document.forms["myform"].submit();

  }
</script>