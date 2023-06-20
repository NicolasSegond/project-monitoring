/**
 * Fonction qui créer le graphique témpérature et consommation des détails des modules
 * @param {*} $data 
 * @param {*} $labels 
 * @param {*} $joursConso 
 * @param {*} $ConsoJournaliere 
 */

function creerGraphiqueTemperature($data, $labels, $joursConso, $ConsoJournaliere) {
    console.log("fonction éxécuté");
    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: {
            labels: $labels,
            datasets: [
                {
                    data: $data,
                    label: "Température (°C)",
                    borderColor: "#3cba9f",
                    fill: true
                }]
        },
        options: {
            title: {
                display: true,
                text: 'Chart JS Line Chart Example'
            }
        }
    });

    new Chart(document.getElementById("ChartConso"), {
        type: 'bar',
        data: {
                labels: $joursConso,
                datasets: [
                    {
                        label: 'Consommation journalière (en KWh)',
                        data: $ConsoJournaliere,
                        borderWidth: 1,
                        borderRadius: 10,
                        borderSkipped: false,
                    },
                ]
        },
        options: {
            responsive: true,
        },
    });
}


/**
 * Fonction qui crée le graphique d'état inactif du tableau de bord
 * @param {*} $etat 
 * @param {*} $heures 
 */
function creerGraphiqueEtat($etat, $heures) {
    console.log('fonction éxécuté');
    new Chart(document.getElementById("myChart2"), {
        type: 'line',
        data: {
            labels: $heures,
            datasets: [
                {
                    label: 'état des modules',
                    data: $etat,
                    fill: false,
                    stepped: true,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                intersect: false,
                axis: 'x'
            },
        }
    });
}

