let sensors_id = []
let temperature = []
let title = []
let name = []
let description = []

function parse_data(data) {
    for (let i = 0; i < Object.keys(data).length; i++) {
        sensors_id[i] = data[i]['id']
        temperature[i] = data[i]['data'][sensors_comparison_data - 1]['temperature']
    }
}

function parse_alert(alert) {
    for (let i = 0; i < sensors_id.length; i++) {
        for (let y = 0; y < alert.length; y++) {
            if (sensors_id[i] === alert[y]['sensor_id']) {
                if (alert[y]['operator'] === 1) {
                    if (temperature[i] > alert[y]['value']) {
                        show_alert(i, alert[y]['name'], alert[y]['description'])
                        y = alert.length
                    }
                } else if (alert[y]['operator'] === 2) {
                    if (temperature[i] >= alert[y]['value']) {
                        show_alert(i, alert[y]['name'], alert[y]['description'])
                        y = alert.length
                    }
                } else if (alert[y]['operator'] === 3) {
                    if (temperature[i] === alert[y]['value']) {
                        show_alert(i, alert[y]['name'], alert[y]['description'])
                        y = alert.length
                    }
                } else if (alert[y]['operator'] === 4) {
                    if (temperature[i] <= alert[y]['value']) {
                        show_alert(i, alert[y]['name'], alert[y]['description'])
                        y = alert.length
                    }
                } else if (alert[y]['operator'] === 5) {
                    if (temperature[i] < alert[y]['value']) {
                        show_alert(i, alert[y]['name'], alert[y]['description'])
                        y = alert.length
                    }
                }
            }
        }
    }
}

function show_alert(i, title, desc) {
    name[i] = title
    description[i] = desc
    $("#sensor"+i+"-alert p").text(title)
    $("#sensor"+i+" section").css({"filter": "blur(8px)","pointer-events": "none", "user-select": "none"})
    $("#sensor"+i+"-alert").css({"opacity": "1", "transition": "opacity 0.4s 0.2s", "filter": "blur(0px)", "pointer-events": "auto", "user-select": "auto"})
}

function show_details_alert(id, details) {
    if (details !== true) {
        title[id] = $("#sensor"+id+"-alert h2").text()
        $("#sensor"+id+"-details-btn").css({"display": "none"})
        $("#sensor"+id+"-back-btn").css({"display": "inline"})
        $("#sensor"+id+"-alert h2").text("Détails de l'alerte :")
        $("#sensor"+id+"-alert p").text(description[id])
    } else {
        $("#sensor"+id+"-details-btn").css({"display": "inline"})
        $("#sensor"+id+"-back-btn").css({"display": "none"})
        $("#sensor"+id+"-alert h2").text(title[id])
        $("#sensor"+id+"-alert p").text(name[id])
    }
}

function close_alert(id) {
    $("#sensor"+id+" section").css({"filter": "blur(0px)","pointer-events": "auto", "user-select": "auto"})
    $("#sensor"+id+"-alert").css({"opacity": "0", "transition": "opacity 0.2s", "filter": "blur(0px)", "pointer-events": "none", "user-select": "none"})
}

parse_data(sensors_data)
setTimeout(parse_alert, 1000, sensors_alert);
