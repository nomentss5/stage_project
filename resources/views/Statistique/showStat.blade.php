@extends('layoutsAdmin.app')
@section('contents')
<style>

    h5{
        text-decoration: underline;
    }

    .input-group select{
        background-color:  rgb(166, 202, 255) ;
    }

</style>
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="text-align: center">Statistique de recrutement</h4>
                <br>
                <div class="row justify-content-center align-items-center">
                    <div>
                        <label style="margin-top: 5px">Choisir annee :</label>
                    </div>
                    <div class="col-md-3" style="margin-left:10px">
                        <div class="input-group">
                            <select class="custom-select" id="year-select" >
                                <option value="">Choisir une année</option>
                            </select>
                        </div>
                    </div>
                </div>
                

                <br>
                
                <h5 style="font-style:italic; font-weight: 750 ">Nombre de candidature</h5>
            
                <br>

                <div style="width: 65%; margin: 0 auto;">
                    <canvas id="CharteGenre"></canvas>
                </div>
                <br>
                <hr>
                <br>
                <div class="row justify-content-center align-items-center" style="">
                    <div style="">
                        <label style="margin-top: 5px">Chosir mois :</label>
                    </div> 
                    <div class="col-md-3" style="margin-left:10px">
                        <div class="input-group">
                            <select class="custom-select" id="month-select">
                                <option value="0" style="text-align: center">Pour une année</option>
                                @foreach ($mois as $m)
                                    <option value={{$m->numero}} style="text-align:center">{{$m->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <h5 style="font-weight: 750">Classement par poste</h5>
                {{-- <br> --}}
                <div style="width: 65%; margin: 0 auto;">
                    <canvas id="ChartePoste"></canvas>
                </div>
                <br>
          
                <h5 style="font-weight: 750">statistique de decision</h5>
                <br>
                <div style="width: 65%; margin: 0 auto;">
                    <canvas id="CharteStatut"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartGenre = null;
    let chartPoste = null;
    let chartStatut = null;


    const ct = document.getElementById('CharteGenre').getContext('2d');
    const cx = document.getElementById('ChartePoste').getContext('2d');
    const cy = document.getElementById('CharteStatut').getContext('2d');


    // Fonction pour récupérer les données depuis le backend
    function fetchDataGenre(annee) {
        fetch('/get_stat_genre/' + annee)
        .then(response => response.json())
        .then(data => {
           // Obtenir tous les mois disponibles dans les données pour les labels du graphique
           const moisFemmes = data.femmes.map(item => item.mois);
            const moisHommes = data.hommes.map(item => item.mois);
            
            // Fusionner les mois des deux datasets et supprimer les doublons
            const labels = [...new Set([...moisFemmes, ...moisHommes])];

            // Créer des tableaux de données pour chaque genre en fonction des labels (mois)
            
            const hommesData = labels.map(mois => {
                const match = data.hommes.find(item => item.mois === mois);
                return match ? match.nombre : 0; // Si aucun match, retourner 0
            });
            
            const femmesData = labels.map(mois => {
                const match = data.femmes.find(item => item.mois === mois);
                return match ? match.nombre : 0; // Si aucun match, retourner 0
            });

            // Créer le graphique avec les données dynamiques
            chartGenre = new Chart(ct, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Homme',
                            data: hommesData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        },
                        {
                            label: 'Femme',
                            data: femmesData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            ticks: {
                            stepSize: 1 // Affiche uniquement des entiers
                            }
                        },
                    }
                }
            });
        });

        if (chartGenre) {
            chartGenre.destroy();
        }
    }

    // Fonction pour générer une couleur hexadécimale aléatoire
    function getRandomColor() {
        let letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function fetchDataPoste(annee, mois){
        console.log('/get_stat_poste/' + annee +'/' + mois);
    // Utilisation de fetch pour récupérer les données JSON
    fetch('/get_stat_poste/' + annee +'/' + mois) 
        .then(response => response.json()) // Convertir la réponse en JSON
        .then(data => {
            // Récupérer les données du JSON
            var poste = data.poste;

            // Variables pour le graphique
            var xValues = [];
            var yValues = [];
            var barColors = [];

            // Boucle pour extraire les données du poste et générer des couleurs aléatoires
            poste.forEach(function(item, index) {
                    xValues.push(item.poste_postule); // Poste postulé
                    yValues.push(item.nombre);         // Nombre de postulants
                    barColors.push(getRandomColor());  // Couleur aléatoire
            });

            yValues.push(0); // ajouter 0 au axe des y
           
            chartPoste = new Chart(cx, {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors, // Couleurs aléatoires
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: "Nombre de postulants par poste"
                    },
                    scales: {
                        y: {
                            ticks: {
                            stepSize: 1 // Affiche uniquement des entiers
                            }
                        },
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données :', error);
        });

        if (chartPoste) {
            chartPoste.destroy();
        }
    }

    function fetchDataStatut(annee, mois){
    // Utilisation de fetch pour récupérer les données JSON
    fetch('/get_stat_statut/' + annee +'/' + mois) 
        .then(response => response.json()) // Convertir la réponse en JSON
        .then(data => {
            // Récupérer les données du JSON
            var statut = data.statut;

            // Variables pour le graphique
            var xValues = [];
            var yValues = [];
            var barColors = ["blue","yellow","orange"];

            // Boucle pour extraire les données du poste et générer des couleurs aléatoires
            statut.forEach(function(item, index) {
                    xValues.push(item.statut); // Poste postulé
                    yValues.push(item.nombre);         // Nombre de postulants
                    
            });

            yValues.push(0); // ajouter 0 au axe des y
           
            chartStatut = new Chart(cy, {
                type: "doughnut",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors, // Couleurs aléatoires
                        data: yValues
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Doughnut Chart'
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données :', error);
        });

        if (chartStatut) {
            chartStatut.destroy();
        }
    }
   
</script>
{{-- script pour recuperer les annee dans input select --}}
<script>

    // Fonction principale pour charger les données selon l'année
    function fetchData(annee,mois) {
        fetchDataGenre(annee);
        fetchDataPoste(annee,mois);
        fetchDataStatut(annee,mois);
    }

    function populateYearSelect() {
    // Récupérer l'élément <select>
    const select = document.getElementById('year-select');

    // Définir l'année de début et de fin
    const currentYear = new Date().getFullYear(); // Année en cours
    const startYear = 2000; // Année de début

    // Boucle pour créer les options du select
    for (let year = startYear; year <= currentYear; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        select.appendChild(option);
    }

    // Sélectionner l'année actuelle par défaut
    select.value = currentYear;

    // // attribuer 0 pour le debut d'affichage pour avoir nombre total par ans pour poste et statut
    let start=0;

    // Charger les données de l'année par défaut
    fetchData(currentYear, start);
    }

    let yearr = new Date().getFullYear(); //avoir l'annee actuel dans la variable puis quand on modifie l'annee ca change
    let monthh = 0; //avoir le mois selectionne dans la variable puis quand on modifie le mois ca change

     // Event Listener pour changer l'année
     document.getElementById('year-select').addEventListener('change', function() {
        const selectedYear = this.value;
        yearr = selectedYear;
        console.log(monthh);
        fetchData(selectedYear, monthh); // Recharger les données en fonction de l'année sélectionnée
    });

    // Event Listener pour changer mois
    document.getElementById('month-select').addEventListener('change', function() {
        monthh = this.value;
        fetchData(yearr, monthh);
    });

    // Charger les options du select et afficher les données initiales pour l'année en cours
    populateYearSelect();
</script>
@endsection