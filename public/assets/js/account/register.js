function onSignIn(googleUser) {
    const id_token = googleUser.getAuthResponse().id_token;

    ajaxRequest(id_token).catch(error => {
        console.log('Error : ' + error);
    });
}

async function ajaxRequest(id_token) {
    const xhr = new XMLHttpRequest();

    xhr.open('POST', '/ajax/googleRegister');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        console.log(id_token);
        signOut();
        document.location.href = '/';
    };

    xhr.send('id_token=' + id_token);
}

// google sign in
function signOut() {
    gapi.auth2.getAuthInstance().signOut().then(function () {
        console.log('User signed out !');
    });
}