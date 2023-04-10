
<div class="py-12 w-full">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
            <div class="flex justify-between">
                <div class="p-2">
                    <input wire:model.debound.500ms="search" type="search" placeholder="Search" class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white">
                </div>
                <div class="p-4">
                    <a href="" class="py-3 px-4 mb-3 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Add Employee</a>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                        <table class="min-w-full text-center text-sm font-light">
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
                                            @if ($sortBy == 'name')
                                                @if (!$sortAsc)
                                                <span class="w-4 h-4 ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-2 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </span>
                                                @endif

                                                @if ($sortAsc)
                                                <span class="w-4 h-4 ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-2 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                                    </svg>
                                                </span>
                                                @endif
                                            @endif
                                        </div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('email')">Email</button>
                                            <x-sort-icon sortField="email" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                                        </div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">
                                        <div class="flex items-center">
                                            <button wire:click="sortBy('phone')">Phone</button>
                                            <x-sort-icon sortField="phone" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                                        </div>
                                    </th>
                                    <th scope="col" class=" px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $key=>$employee)
                                <tr class="border-b dark:border-neutral-500">
                                    <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ $employee->id; }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $employee->name; }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $employee->email; }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">{{ $employee->phone; }}</td>
                                    <td class="whitespace-nowrap  px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>

                                            <button type="button" wire:click="deleteId({{ $employee->id }})" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right p-4 py-10">
                            {{ $employees->links() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
