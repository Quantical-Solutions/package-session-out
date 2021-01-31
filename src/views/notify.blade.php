@auth
    <link rel="stylesheet" href="{{ asset('vendor/session-out/css/session-modal.css') }}" />

    {{-- Modal --}}
    @include('vendor.session-out.modal')

    <script type="text/javascript">
        window.sessionout = window.sessionout || {};
        sessionout.authpingEndpoint = "{{ route('session-out.check-auth') }}";
        sessionout.requestGap = {{ config('expired-session.gap_seconds') }};
        sessionout.userId = {{ auth()->user()->id }};
        sessionout.usingBroadcasting = {{ config('expired-session.avail_broadcasting') === true? 1 : 0 }};
    </script>
    <script type="text/javascript" src="{{ asset('vendor/session-out/dist/js/main.js') }}"></script>
    <script type="text/javascript">
        function closeSessionOutModal(){
            document.getElementById("modal-quantic").style.visibility = "hidden";
        }
    </script>
@endauth