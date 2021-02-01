import axios from 'axios';

function checkAuth(){

    axios.post(`${window.sessionout.authpingEndpoint}`, {
        pinguser: 1
    })
        .then(function (response) {
            if (parseInt(response.data.auth) === 0){
                // show modal
                document.querySelector("#modal-quantic").classList.add('modal-quantic-show');

                setTimeout(function(){
                    document.querySelector('#session-expired-form').submit();
                }, 60000);
            }
            else{
                // user session available, hide the modal
                document.querySelector("#modal-quantic").classList.remove('modal-quantic-show');
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

(function(){

    if (document.querySelector("#modal-quantic")) {
        // check every minute if not logged out already
        setInterval(checkAuth, parseInt(window.sessionout.requestGap) * 1000);

        if (parseInt(window.sessionout.usingBroadcasting) === 1) {
            // listen for laravel echo
            Echo.private(`user.session-track.${window.sessionout.userId}`)
                .listen('.session.active', (e) => {
                    // user auth session resumed
                    // close the notification modal
                    document.querySelector("#modal-quantic").classList.remove('modal-quantic-show');
                });
        }
    }
})();