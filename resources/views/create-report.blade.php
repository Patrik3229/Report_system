<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Create a report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('create.report') }}" method="post">
                @csrf
                <!-- Perpetrator ID -->
                <div>
                    <label for="perpetrator_id" class="text-lg whitetext">Perpetrator ID</label>
                    <input id="perpetrator_id" class="block mt-1 w-full inputfield" type="number" name="perpetrator_id" required/>
                </div>

                <!-- Reporter Comment -->
                <div class="mt-4">
                    <label for="reporter_comment" class="text-lg whitetext">Report Comment</label>
                    <textarea id="reporter_comment" class="block mt-1 w-full inputfield textarea" type="text" name="reporter_comment" required></textarea>
                </div>

                <div class="mt-6">
                    <button type="submit" value="Submit report" class="p-2 btnStyle text-lg" id="btnSubmitReport">Submit report</button>
                </div>
            </form>
            @if($errors->any())
                <div id="errorModal" class="whitetext">
                    <div class="modal-content">
                        <p>{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>