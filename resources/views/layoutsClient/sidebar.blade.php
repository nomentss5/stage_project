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
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            Groupe althea
        </div>
        {{-- <div class="sidebar-brand-text mx-3">Give job  </div> --}}
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <br>



    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link custom-nav-link" href="{{ route('client.Home')}}">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link custom-nav-link" href={{ route('entretien.getListe', ['id_user' => auth()->user()->id ]) }}>
            <i class="fas fa-question-circle"></i>
            <span>Question</span>
        </a>
    </li>
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link custom-nav-link" href={{ route('entretien.getListeFiche', ['id_user' => auth()->user()->id ]) }}>
            <i class="fas fa-list-alt"></i>
            <span>Mes reponses</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

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