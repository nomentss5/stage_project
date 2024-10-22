@extends('layoutsAdmin.app')
@section('contents')

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="text-align: center">Statistique de recrutement</h5>
                <br>
                

                <h5 style="font-style:italic; font-weight: 750 ">Nombre de candidature</h5>
                <div class="row">
                    <label class="col-sm-2 col-form-label" >Choisir une année</label>
                    <div class="col-md-3">
                        <div class="input-group">
                            <select class="custom-select" id="year-select" >
                                <option value="">Choisir une année</option>
                            </select>
                        </div>
                    </div>
                </div>
            
                <br>

                <div style="width: 65%; margin: 0 auto;">
                    <canvas id="myChart"></canvas>
                </div>
                <br>
                <hr>
                <br>
                <h5 style="font-weight: 750">Classement par poste</h5>
                <br>
                <div style="width: 65%; margin: 0 auto;">
                    <canvas id="myCharte"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ct = document.getElementById('myChart').getContext('2d');

    // Fonction pour récupérer les données depuis le backend
    function fetchData() {
        fetch('/get_stat_genre') // Assure-toi que la route '/get-stats' existe et pointe vers ton contrôleur
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
            new Chart(ct, {
                type: 'bar',
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
    }

    // Appeler la fonction pour récupérer les données et créer le graphique
    fetchData();
</script>

<script>
    // Fonction pour générer une couleur hexadécimale aléatoire
    function getRandomColor() {
        let letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function fetchData2(){
    // Utilisation de fetch pour récupérer les données JSON
    fetch('/get_stat_poste') // Remplace '/ton-endpoint' par ton URL
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

            // Vérifier les données dans la console
            console.log(xValues, yValues, barColors);

            // Optionnel : Intégration dans un graphique (ex. Chart.js)
            new Chart("myCharte", {
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
                }
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données :', error);
        });
    }
    fetchData2();
</script>
{{-- script pour recuperer les annee dans input select --}}
<script>
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

</script>
@endsection