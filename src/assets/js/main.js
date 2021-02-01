import axios from 'axios';
var stamp = null;

function checkAuth(){

    axios.post(`${window.sessionout.authpingEndpoint}`, {
        pinguser: 1
    }).then(function (response) {

        var d = new Date();

        if (parseInt(response.data.auth) === 0) {
            // show modal
            if (!document.querySelector("#modal-quantic").classList.contains('modal-quantic-show')) {

                document.querySelector("#modal-quantic").classList.add('modal-quantic-show');
                document.querySelector("#session-count-down").innerHTML = '<span class="fill-loader-bar"></span>';

            } else {

                if (stamp === null) {
                    stamp = parseInt(Date.now());
                }

                if (parseInt(Date.now()) >= stamp + 45000) {
                    document.querySelector('#session-expired-form').submit();
                }
            }

        } else {
            // user session available, hide the modal
            document.querySelector("#modal-quantic").classList.remove('modal-quantic-show');
            stamp = null;
            setTimeout(function(){
                document.querySelector("#session-count-down").innerHTML = '';
            }, 300);
        }

    }).catch(function (error) {

        console.log(error);
    });
}

(function(){

    if (document.querySelector("#modal-quantic")) {
        // check every minute if not logged out already
        setInterval(checkAuth, 10000);

        if (parseInt(window.sessionout.usingBroadcasting) === 1) {
            // listen for laravel echo
            Echo.private(`user.session-track.${window.sessionout.userId}`)
                .listen('.session.active', (e) => {
                    // user auth session resumed
                    // close the notification modal
                    document.querySelector("#modal-quantic").classList.remove('modal-quantic-show');
                    setTimeout(function(){
                        document.querySelector("#session-count-down").innerHTML = '';
                    }, 300);
                });
        }
    }
})();