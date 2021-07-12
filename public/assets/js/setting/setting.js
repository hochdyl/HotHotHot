for(const[key, value] of Object.entries(id_sensors_list)) {
    const alert_information = getId('select-alert-sensor' + value);

    alert_information.addEventListener('change', (event) => {
        const xhr = new XMLHttpRequest();

        xhr.open('POST', '/ajax/alertSensor');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const sensor_data = JSON.parse(xhr.responseText);

                getId('form-update-sensor' + value).classList.remove('d-none');

                // On affecte les détails de l'alerte au input HTML
                getId('name-alert-sensor' + value).value = sensor_data.name;
                getId('description-new-alert' + value).value = sensor_data.description;
                getId('operator-alert-sensor' + value).value = sensor_data.operator;
                getId('value-alert-sensor' + value).value = sensor_data.value;
            }
        }

        xhr.send('alert_id=' + event.target.value);
    });
}