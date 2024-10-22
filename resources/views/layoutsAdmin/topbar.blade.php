<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="handleDropdownClick(event)">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                {{-- <span class="badge badge-danger badge-counter">4</span> --}}
            </a>
            <!-- Dropdown - Alerts -->  
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" id="topbar-notifications">
                <h6 class="dropdown-header">
                    Centre de notifications
                </h6>
                {{-- <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">RAKOTO a terminer de repondre sur un entretien</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        RANDRETSA Nouveau candidat en entretien 
                    </div>
                </a> --}}
            </div>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ auth()->user()->name }}
                </span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('admin_assets/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href=" {{ route('logoutAction') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<script>
  // Fonction pour charger les notifications
  function loadNotifications() {
        // fetch("{{ route('notification.getListe') }}")
        fetch("{{ route('notification.getNotificationRecruteur', ['id_recruteur' => auth()->user()->id]) }}")
            .then(response => response.json())
            .then(data => {

                 // Récupérer les notifications
                const notifications = data.notification;
                
                // Récupérer le nombre de notifications non lues
                const alert = data.alert;

                const notificationsContainer = document.getElementById('topbar-notifications');

                const AlertContainer = document.getElementById('alertsDropdown');

                // notificationsContainer.innerHTML = ''; // Vider le conteneur avant de le remplir

                notifications.forEach(notification => {


                    const message = notification.type === 0
                        ? `${notification.name} , nouveau candidat en attente d'entretien`
                        : `${notification.name} a terminé de répondre sur un entretien`; // Changez ce message selon votre besoin


                    const idnotification = `${notification.id_notification}`;

                    
                    const notificationItem = `
                        <div class="dropdown-item d-flex align-items-center">
                            <div style="display: flex; flex-direction: column;">
                                <div style="display: flex; gap: 50%;">
                                    <div class="small text-gray-500">
                                        ${new Date(notification.created_at).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}
                                    </div>
                                    <div class="small text-gray-500">
                                        <a href="#" onclick="deleteNotification(event, ${idnotification})">Supprimer</a>
                                    </div>
                            
                                </div>
                                <a href="dfur" style="text-decoration:none; color:grey" class="font-weight-bold">
                                    <span>${message}${idnotification}</span>
                                </a>
                            </div>  
                        </div>
                    `;

                    notificationsContainer.insertAdjacentHTML('beforeend', notificationItem);
                });

                loadAlert(); //afficher le nombre de nouvelles notifications
            })
            .catch(error => console.error('Erreur:', error));
    }


    // Charger les notifications au chargement de la page
    document.addEventListener('DOMContentLoaded', loadNotifications);

    function loadAlert() {
        // fetch("{{ route('notification.getListe') }}")
        fetch("{{ route('notification.getNotificationRecruteur', ['id_recruteur' => auth()->user()->id]) }}")
            .then(response => response.json())
            .then(data => {
                
                // Récupérer le nombre de notifications non lues
                const alert = data.alert;

                const AlertContainer = document.getElementById('alertsDropdown');    

                let AlertItem = ''; // Initialisation d'AlertItem par une chaîne vide

                if(alert === 0){
                    AlertItem =`
                        <span></span>
                    `;
                }else {
                    AlertItem =`
                        <span class="badge badge-danger badge-counter">${alert}</span>
                    `;
                }

                AlertContainer.insertAdjacentHTML('beforeend', AlertItem); // Ajoute l'élément AlertItem à la fin
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Fonction à exécuter lors du clic
    function handleDropdownClick(event) {
        fetchNotifications();
    }

    // mettre a jour alert
    function fetchNotifications() {
        fetch("{{ route('notification.updateNotification', ['id_recruteur' => auth()->user()->id]) }}")

        const Badge = document.getElementById('.badge'); 
        Badge.innerHTML = '';
        
        loadAlert();

    }

    function deleteNotification(event, id_notification) {

        fetch("{{ route('notification.delete', ['id_recruteur' => auth()->user()->id, 'id_notification' => ':id_notification']) }}".replace(':id_notification', id_notification))
        .then(response => {
            if (response.ok) {
                location.reload();

            } else {
                console.error('Erreur lors de la suppression de la notification');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête:', error);
        });
        
    }

</script>