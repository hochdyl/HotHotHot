Chart.defaults.global.defaultFontColor = 'white'
Chart.defaults.global.defaultFontFamily = '"Roboto", "Arial", "Helvetica", "sans-serif"'

let colors = []
colors.push({
    0: 'rgb(29,140,248)',
    1: 'rgba(29,140,248,0.6)',
    2: 'rgba(29,140,248,0.3)'
})
colors.push({
    0: 'rgb(208,72,182)',
    1: 'rgba(208,72,182,0.6)',
    2: 'rgba(208,72,182,0.2)'
})
colors.push({
    0: 'rgb(38,195,62)',
    1: 'rgba(38,195,62,0.6)',
    2: 'rgba(38,195,62,0.2)'
})

function parse_data(data) {
    let temperature_comparison = []
    let time_comparison = []
    let name_comparison = []
    for (let i = 0; i < data.length; i++) {
        let type = data[i]['type']
        if (!type) {
            type = "type inconnu"
        }
        let name = data[i]['name']
        if (name) {
            $("#sensor"+i+"-title").text(name+" ("+type+")")
            $("#sensor"+i+"-name").text(name)
        } else {
            name = i
            $("#sensor"+i+"-title").text(name)
            $("#sensor"+i+"-name").text(name)
        }
        let sensor_data = data[i]['data']
        let temperature = []
        let time = []
        if (sensor_data.length === 0) {
            $("#sensor" + i + "-dot").css("background-color", "red")
            let text = $("#sensor" + i + "-state").text()
            $("#sensor" + i + "-state").text(text.replace("Actif", "Inactif"))
            $("#sensor" + i + "-state").css({"--main-color": "red"})
            $("#sensor" + i + "-now").text("NaN")
            $("#sensor" + i + "-max").text("NaN")
            $("#sensor" + i + "-min").text("NaN")
        } else {
            if (Date.now() - Date.parse(data[i]['data'][0]['time']) > sensors_sync_time*60000) {
                $("#sensor" + i + "-dot").css("background-color", "red")
                let text = $("#sensor" + i + "-state").text()
                $("#sensor" + i + "-state").text(text.replace("Actif", "Inactif"))
                $("#sensor" + i + "-state").css({"--main-color": "red"})
            }
            for (let j = 0; j < sensors_comparison_data; j++) {
                temperature.push(data[i]['data'][j]['temperature'])
                time.push(data[i]['data'][j]['time'])
            }
            $("#sensor"+i+"-now").text(data[i]['data'][0]['temperature']+"°C")
            $("#sensor"+i+"-max").text(Math.max(...temperature)+"°C")
            $("#sensor"+i+"-min").text(Math.min(...temperature)+"°C")
        }
        temperature_comparison.push(temperature)
        time_comparison.push(time)
        name_comparison.push(name)
        chart(i, temperature, time)
    }
    comparison_chart(temperature_comparison, time_comparison, name_comparison)
}

function reverse_data(data) {
    let array = []
    for (let i = data.length - 1; i >= 0; i--) {
        array.push(data[i])
    }
    return array
}

function chart(id, data, labels) {
    const ctx = document.getElementById("sensor"+id+"-charts").getContext('2d')
    let id_color = id % (colors.length)
    let degradeCouleur = ctx.createLinearGradient(0, 230, 0, 50);
    degradeCouleur.addColorStop(1, colors[id_color][2]);
    degradeCouleur.addColorStop(0.2, "rgba(0, 0, 0, 0)");
    let date = []
    let time = []
    let label = []
    let value = []
    let y = 0
    for (let i = value_sensors - 1; i >= 0; i--) {
        value.push(data[i])
        let str = labels[i].split(' ')
        let str_date = str[0].split('-')
        let str_time = str[1].split(':')
        date.push(str_date[2]+'-'+str_date[1]+'-'+str_date[0])
        time.push(str_time[0]+'h'+str_time[1])
        let str2 = str[1].split(':')
        if (label.length === 0) {
            label.push(str2[0]+'h'+str2[1])
        } else if (date[y] === date[y-1]) {
            label.push(str2[0]+'h'+str2[1])
        } else {
            label.push(str_date[2]+'-'+str_date[1]+'-'+str_date[0])
        }
        y++
    }
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: "Température ",
                backgroundColor: degradeCouleur,
                borderColor: colors[id_color][0],
                borderWidth: 2,
                data: value
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            scales: { yAxes: [{ ticks: { beginAtZero: true } }] },
            tooltips: { callbacks: {
                    title: function(tooltipItem) {
                        tooltipItem.xLabel = date[tooltipItem[0].index] + " - " + time[tooltipItem[0].index]
                        return tooltipItem.xLabel;
                    } }
            }
        }
    })
}

function comparison_chart(data, labels, name) {
    const ctx = document.getElementById("comparison").getContext('2d')
    let degradeCouleur = ctx.createLinearGradient(0, 230, 0, 50);
    degradeCouleur.addColorStop(1, 'rgba(29,140,248,0.3)');
    degradeCouleur.addColorStop(0.4, 'rgba(29,140,248,0.0)');
    degradeCouleur.addColorStop(0, 'rgba(29,140,248,0)');
    let date = []
    let time = []
    let label = []
    let datasets = []
    let y = 0
    for (let i = sensors_comparison_data - 1; i >= 0; i--) {
        let str = labels[0][i].split(' ')
        let str_date = str[0].split('-')
        let str_time = str[1].split(':')
        date.push(str_date[2]+'-'+str_date[1]+'-'+str_date[0])
        time.push(str_time[0]+'h'+str_time[1])
        let str2 = str[1].split(':')
        if (label.length === 0) {
            label.push(str2[0]+'h'+str2[1])
        } else if (date[y] === date[y-1]) {
            label.push(str2[0]+'h'+str2[1])
        } else {
            label.push(str_date[2]+'-'+str_date[1]+'-'+str_date[0])
        }
        y++
    }
    for (let i = 0; i < labels.length; i++) {
        datasets.push({
            label: name[i]+' ',
            borderColor: colors[i][1],
            borderWidth: 2,
            pointBackgroundColor: colors[i][0],
            data: reverse_data(data[i])
        },)
    }
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: label,
            datasets: datasets
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            scales: { yAxes: [{ ticks: { beginAtZero: true } }] },
            tooltips: { callbacks: {
                    title: function(tooltipItem) {
                        tooltipItem.xLabel = date[tooltipItem[0].index] + ' - ' + time[tooltipItem[0].index]
                        return tooltipItem.xLabel;
                    } }
            }
        }
    })
}

parse_data(sensors_data)
