<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .collapse-item {
        cursor: pointer;
    }

    .custom-bg {
        background-color: hsla(135, 14%, 78%, 0.459);
    }

    .custom-nav-link i {
        color: #3067ff; /* Change également la couleur de l'icône */
    }

    .custom-nav-link span {
        font-size: bold;
        color: #000000; /* Change également la couleur de l'icône */
    }
</style>
<ul class="navbar-nav custom-bg sidebar" id="sidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            Groupe althea
        </div>
        {{-- <div class="sidebar-brand-text mx-3">Give job  </div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link custom-nav-link" href="{{route('showCandidats')}}">
            <i class="fas fa-users fa-tachometer-alt"></i>
            <span>Voir Candidats</span></a>
    </li>
 
    <!-- Navigation Menu -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link custom-nav-link collapsed" href="#" data-toggle="collapse"  data-bs-target="#collapseComponents1" aria-expanded="false" aria-controls="collapseComponents1">
                <i class="fas fa-plus-square"></i>
                <span>Nouveau Candidats</span>
            </a>
            <!-- Collapsible content -->
            <div id="collapseComponents1" class="collapse" aria-labelledby="headingComponents" data-bs-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Type de cv:</h6>
                    <a class="collapse-item" href="{{route('showFormulaire')}}">Cv physique</a>
                    <a class="collapse-item" href="{{route('showImport')}}">Importer CV</a>
                </div>
            </div>
        </li>
    </ul>

    <hr class="sidebar-divider my-0">

    <!-- Navigation Menu -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link custom-nav-link collapsed" href="#" data-toggle="collapse" data-bs-target="#collapseComponents2" aria-expanded="false" aria-controls="collapseComponents2">
                <i class="fas fa-envelope"></i>
                <span>E-mail</span>
            </a>
            <!-- Collapsible content -->
            <div id="collapseComponents2" class="collapse" aria-labelledby="headingComponents" data-bs-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">option:</h6>
                    <a class="collapse-item" href="{{route('email.formulaire')}}">Envoyer E-Mail</a>
                    <a class="collapse-item" href="{{ route('suggestion.index')}}">Gerer suggestion message</a>
                    <a class="collapse-item" href="{{ route('email.parametre_form')}}">Paramètre E-mail</a>
                </div>
            </div>
        </li>
    </ul>

    <hr class="sidebar-divider my-0">

    <!-- Navigation Menu -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link custom-nav-link collapsed" href="#" data-toggle="collapse" data-bs-target="#collapseComponents4" aria-expanded="false" aria-controls="collapseComponents4 ">
                <i class="fas fa-tasks"></i>
                <span>Gestion Entretien</span>
            </a>
            <!-- Collapsible content -->
            <div id="collapseComponents4" class="collapse" aria-labelledby="headingComponents" data-bs-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">option:</h6>
                    <a class="collapse-item" href="{{ route('entretien.liste')}}">Liste candidats</a>
                    <a class="collapse-item" href="{{ route('classement.index')}}">Resultat entretien</a>
                </div>
            </div>
        </li>
    </ul>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link custom-nav-link" href="{{route ('poste.index')}}">
            <i class="bi bi-collection"></i>
            <span>Gestion Poste</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Navigation Menu -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link custom-nav-link collapsed" data-toggle="collapse"  data-bs-target="#collapseComponents3" aria-expanded="false" aria-controls="collapseComponents3">
                <i class="bi bi-question-octagon"></i>
                <span>Questionnaire</span>
            </a>
            <!-- Collapsible content -->
            <div id="collapseComponents3" class="collapse" aria-labelledby="headingComponents" data-bs-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">option:</h6>
                    <a class="collapse-item" href="{{route('question.formulaire')}}"> Creer Questionnaire </a>
                    <a class="collapse-item" href="{{ route('question.liste')}}"> Voir Questionnaire </a>
                </div>
            </div>
        </li>
    </ul>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link custom-nav-link" href="{{ route('statistique.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Statistique</span></a>
    </li>

    {{-- <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

{{--  --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
{{-- <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-link');
        const collapseItems = document.querySelectorAll('.collapse-item');

        // Gère la marque de l'élément actif
        collapseItems.forEach(item => {
            item.addEventListener('click', function () {
                // Supprimer la classe active de tous les éléments
                collapseItems.forEach(el => el.classList.remove('active'));
                // Ajouter la classe active à l'élément cliqué
                this.classList.add('active');
            });
        });

        // Optionnel : Garde le menu collapsible ouvert en ajoutant la classe show si l'élément est actif
        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                if (target) {
                    new bootstrap.Collapse(target, {
                        toggle: true
                    });
                }
            });
        });
    });
</script>