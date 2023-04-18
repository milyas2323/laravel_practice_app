
<div class="py-12 w-full">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
            @if(session()->has('message'))
                <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-2 py-4 relative" role="alert" x-data="{showKhan: true}" x-show="showKhan" x-init="setTimeout(() => showKhan = false, 3000)">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                    <p>{{ session('message') }}</p>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="showKhan = false">
                        <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </span>
                </div>
            @endif
            <div class="flex justify-between">
                <div class="p-2">
                    <input wire:model.debound.500ms="search" type="search" placeholder="Search" class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                </div>
                <div class="p-4">
                    <button class="py-3 px-4 mb-3 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md" wire:click="confirmBarcodeAdd">Add Barcode</button>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead
                            class="border-b bg-neutral-50 font-medium dark:border-neutral-500 dark:text-neutral-800">
                                <tr>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('id')">ID</button>
                                            <x-sort-icon sortField="id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                                        </div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('name')">Name</button>
                                            <x-sort-icon sortField="name" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                                        </div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">Description</div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">Price</div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">Barcode</div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barcodes as $key=>$barcode)
                                <tr class="border-b dark:border-neutral-500">
                                    <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ $barcode->id; }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $barcode->name; }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $barcode->description; }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $barcode->price; }}</td>
                                    <td class="text-center">
                                        <div class="text-left">
                                        {!! $barcode->barcode !!}
                                        </div>
                                        <div class="text-left" style="font-weight: bold;">{{ $barcode->code; }}</div>
                                    </td>
                                    <td class="whitespace-nowrap  px-6 py-4">
                                        <div class="flex space-x-2">
                                            <button wire:click="confirmBarcodeEdit( {{ $barcode->id}})" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">
                                                Edit
                                            </button>
                                            <x-danger-button wire:click="confirmBarcodeDeletion( {{ $barcode->id}})" wire:loading.attr="disabled">
                                                Delete
                                            </x-danger-button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right p-4 py-10">
                            {{ $barcodes->links() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal wire:model="confirmingBarcodeDeletion">
        <x-slot name="title">
            {{ __('Delete Barcode') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete Barcode? ') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingBarcodeDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteBarcode({{ $confirmingBarcodeDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <x-jet-dailog-modal wire:model="confirmBarcodeAdd">
        <x-slot name="title">
            {{ isset( $this->barcode->id) ? 'Edit Barcode' : 'Add Barcode'}}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-8 w-full mt-4">
                <x-label for="code" value="{{ __('Code') }}" />
                <x-input id="code" type="text" class="mt-1 block w-full" wire:model.defer="barcode.code" />
                <x-jet-input-error for="barcode.code" class="mt-2" />
            </div>

            <div class="col-span-8 w-full mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="barcode.name" />
                <x-jet-input-error for="barcode.name" class="mt-2" />
            </div>

            <div class="col-span-8 w-full mt-4">
                <x-label for="price" value="{{ __('Price') }}" />
                <x-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="barcode.price" />
                <x-jet-input-error for="barcode.price" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-label for="description" value="{{ __('Description') }}" />
                <textarea name="description" id="description" class="appearance-none block w-full bg-gray-50 border border-gray-500 rounded py-3 px-4 mb-3 mt-1 leading-tight focus:outline-none focus:bg-white" rows="5" wire:model.defer="barcode.description">{{ ('barcode.description') }}</textarea>
                <x-jet-input-error for="barcode.description" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmBarcodeAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="saveBarcode()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-danger-button>
        </x-slot>
    </x-jet-dailog-modal>

</div>
