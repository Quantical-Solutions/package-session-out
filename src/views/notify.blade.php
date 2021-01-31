@auth
    <link rel="stylesheet" href="{{ asset('vendor/session-out/css/session-modal.css') }}" />

    {{-- Modal --}}
    @include('vendor.session-out.modal')
    <form id="session-expired-form" method="post" action="{{ route('session-out.session') }}">
        @csrf
        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
    </form>
    <script type="text/javascript">
        window.sessionout = window.sessionout || {};
        sessionout.authpingEndpoint = "{{ route('session-out.check-auth') }}";
        sessionout.requestGap = {{ config('expired-session.gap_seconds') }};
        sessionout.userId = {{ auth()->user()->id }};
        sessionout.usingBroadcasting = {{ config('expired-session.avail_broadcasting') === true? 1 : 0 }};
    </script>
    <script type="text/javascript">
        function closeSessionOutModal(){
            document.querySelector("#modal-quantic").style.visibility = "hidden";
            newSession();
        }

        function newSession(){
            document.querySelector('#session-expired-form').submit();
        }
    </script>
@endauth