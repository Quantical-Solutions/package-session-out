<div id="modal-quantic" class="flex justify-center items-center">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ __('Session expiration') }}...
            </h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                    <p id="session-count-down">
                        <!-- JS Replacer -->
                    </p>
                    <p>
                        {{ __('Your session will expire') }}.
                    </p>
                    <p>
                        {{ __('To resume your current activity please click on the button') }}.
                    </p>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="closeSessionOutModal();">
                        {{ __('Going on') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>