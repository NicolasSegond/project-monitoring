function creerGraphiqueTemperature($data,$labels) {
    console.log("fonction éxécuté");
    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: {
            labels: $labels,
            datasets: [
                {
                    data: $data,
                    label: "Température",
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
}