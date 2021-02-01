@auth
    <link rel="stylesheet" href="{{ asset('vendor/session-out/css/session-modal.css') }}" />

    {{-- Modal --}}
    @include('vendor.session-out.modal')
    <form id="session-expired-form" method="post" action="{{ route('session-out.session') }}">
        @csrf
        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
    </form>
    <form id="regenerate-session" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
    </form>
    <script type="text/javascript">
        window.sessionout = window.sessionout || {};
        sessionout.authpingEndpoint = "{{ route('session-out.check-auth') }}";
        sessionout.userId = {{ auth()->user()->id }};
        sessionout.cookieDuration = "{{ config('session.lifetime') }}";
        sessionout.stamp = null;
        sessionout.usingBroadcasting = {{ config('expired-session.avail_broadcasting') === true? 1 : 0 }};

        function closeSessionOutModal() {

            var formElement = document.querySelector("#regenerate-session"),
                request = new XMLHttpRequest();
            request.open("POST", "/rebirth-session");

            request.onload = function(ev) {

                if (request.status === 200) {

                    var json = JSON.parse(request.response),
                        session = json.session;

                    if (parseInt(session) === 1) {

                        document.querySelector("#modal-quantic").classList.remove('modal-quantic-show');
                        setTimeout(function(){
                            document.querySelector("#session-count-down").innerHTML = '';
                        }, 300);
                    }

                } else {

                    newSession();
                }
            };
            request.setRequestHeader('X-Requested-With', 'XmlHttpRequest')
            request.send(new FormData(formElement));
        }

        function newSession() {

            document.querySelector('#session-expired-form').submit();
        }
    </script>
@endauth