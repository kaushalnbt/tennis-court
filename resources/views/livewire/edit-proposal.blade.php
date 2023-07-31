<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="mb-4">
        <h2 class="underline text-center font-medium text-4xl">Agreement</h2>
    </div>
    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <x-label for="work_to_be_performed">
                    Work to be Performed
                </x-label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="work_to_be_performed" rows="5" wire:model="work_to_be_performed">

                </textarea>
            </div>
            <div class="mb-4">
                <x-label for="work_to_be_performed">
                    Customer
                </x-label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="customer" rows="5" wire:model="customer">

                </textarea>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="mb-4">
                <x-label for="customer_name">
                    Customer Name
                </x-label>
                <x-input id="customer_name" class="border w-full py-2 px-3 outline-none" wire:model="customer_name" />
                @error('customer_name')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <x-label for="construction_of">
                    Construction of
                </x-label>
                <x-input id="construction_of" class="border w-full py-2 px-3 outline-none"
                    wire:model="construction_of" />
                @error('construction_of')
                    <span class="error text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <hr />

        <div wire:sortable="updateChecklistOrder">
            <div >
                <input type="checkbox" wire:model="show_overseas_conditions" id="show_overseas_conditions">
                <x-proposal-input-group :array="$overseas_conditions" :title="$overseas_conditions_heading" variable="overseas_conditions"
                    change="overseas_conditions_heading" />
            </div>


            <hr />
            <div>
                <input type="checkbox" wire:model="show_base" id="show_base">
                <x-proposal-input-group :array="$base" :title="$base_heading" change="base_heading" variable="base" />
            </div>
            <hr />

            <div>
                <input type="checkbox" wire:model="show_court_preparation" id="show_court_preparation">
                <x-proposal-input-group :array="$court_preparation" :title="$court_preparation_heading" change="court_preparation_heading" variable="court_preparation" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_surfacing" id="show_surfacing">
                <x-proposal-input-group :array="$surfacing" title="Surfacing" variable="surfacing" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_fence" id="show_fence">
                <x-proposal-input-group :array="$fence" title="Fence" variable="fence" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_lights" id="show_lights">
                <x-proposal-input-group :array="$lights" title="Lights" variable="lights" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_court_accessories" id="show_court_accessories">
                <x-proposal-input-group :array="$court_accessories" title="Court Accessories" variable="court_accessories" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_fee" id="show_fee">
                <x-proposal-input-group :array="$fee" title="Fee" variable="fee" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_provisions" id="show_provisions">
                <x-proposal-input-group :array="$provisions" title="Provisions" variable="provisions" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_conditions" id="show_conditions">
                <x-proposal-input-group :array="$conditions" title="Conditions" variable="conditions" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_guarantee" id="show_guarantee">
                <x-proposal-input-group :array="$guarantee" title="Guarantee" variable="guarantee" />
            </div>

            <hr />
            <div>
                <input type="checkbox" wire:model="show_credit" id="show_credit">
                <x-proposal-input-group :array="$credit" title="Credit" variable="credit" />
            </div>
        </div>
        <hr />


        <!-- Signature Pad -->
        <div x-data="{ signaturePad: null, showSuccessMessage: false }" x-init="initSignaturePad()">
            <canvas x-ref="signatureCanvas" width="400" height="200" id="signature-pad"></canvas>
            <div id="sign-here-text">Sign Here</div>
            <button @click="signaturePad.clear(); resetSuccessMessage()" type="button" id="clear-proposal-btn"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-green-500  hover:bg-green-800 mx-3">Clear</button>
            <button @click="saveSignature()" type="button" id="save-proposal-btn"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-blue-500  hover:bg-green-800 mx-3">Save</button>
            @error('signatureData')
                <span class="error text-red-500">{{ $message }}</span>
            @enderror
            <template x-if="showSuccessMessage">
                <div class="alert alert-success">
                    Signature saved successfully.
                </div>
            </template>

        </div>

        <hr />
        <div class="my-4">
            <x-label for="send_proposal_to">
                Send Proposal To
            </x-label>
            <x-input type="text" id="send_proposal_to" class="border w-full py-2 px-3 outline-none"
                wire:model="send_proposal_to" placeholder="Enter email address" />
            @error('send_proposal_to')
                <span class="error text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="my-4 flex justify-center">
            <x-button type="submit" class="bg-green-500  hover:bg-green-800 mx-3">Update Proposal</x-button>
            <button wire:click="sendPdfEmail('{{ $pid }}')" type="button" id="save-proposal-btn"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-red-500  hover:bg-green-800 mx-3">EMAIL
                PDF</button>
            <a href="{{ route('proposal.export', ['proposal' => $proposal->id]) }}"><button type="button"
                    id="save-proposal-btn"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-blue-500  hover:bg-green-800 mx-3">EXPORT
                    PDF</button></a>

    </form>
</div>

@push('sign')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        function initSignaturePad() {
            const signatureCanvas = document.querySelector('[x-ref="signatureCanvas"]');
            if (signatureCanvas) {
                const signaturePad = new SignaturePad(signatureCanvas, {
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    penColor: 'blue', // Change this to a darker color if needed
                });
                this.signaturePad = signaturePad;
            }
        }

        function saveSignature() {
            if (this.signaturePad.isEmpty()) {
                alert('Please provide your signature before saving.');
                return;
            }
            const signatureDataUrl = this.signaturePad.toDataURL();
            Livewire.emit('saveSignature', signatureDataUrl);
            this.showSuccessMessage = true;
            alert('Signature saved successfully!');
        }

        function resetSuccessMessage() {
            this.showSuccessMessage = false;
        }
        // Alpine.start();
    </script>
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .pen-icon {
            cursor: pointer;
            margin-left: 0.5rem;
        }

        .edit-field {
            display: none;
            margin-top: 0.5rem;
        }

        .edit-field.visible {
            display: block;
        }
    </style>
@endpush
@push('sorts')
<script src="{{ asset('js/sortable.min.js') }}"></script>
<script src="{{ asset('js/livewire-sortable.min.js') }}"></script>
@endpush