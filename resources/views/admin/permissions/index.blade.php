<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex justify-end p-2">
                    @can('Permission create')
                        <a href="{{ route('admin.permissions.create') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Create Permission</a>
                    @endcan
                </div>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                            <table class="min-w-full text-center text-sm font-light">
                                <thead
                                class="border-b bg-neutral-50 font-medium dark:border-neutral-500 dark:text-neutral-800">
                                <tr>
                                    <th scope="col" class=" px-6 py-4">#</th>
                                    <th scope="col" class=" px-6 py-4">Name</th>
                                    <th scope="col" class=" px-6 py-4">Guard</th>
                                    <th scope="col" class=" px-6 py-4">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @can('Permission access')
                                        @foreach ($permissions as $key=>$permission)
                                        <tr class="border-b dark:border-neutral-500">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ $key+1; }}</td>
                                            <td class="whitespace-nowrap  px-6 py-4">{{ $permission->name; }}</td>
                                            <td class="whitespace-nowrap  px-6 py-4">{{ $permission->guard_name; }}</td>
                                            <td class="whitespace-nowrap  px-6 py-4">
                                                <div class="flex space-x-2">
                                                    @can('Permission edit')
                                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                                                    @endcan

                                                    @can('Permission delete')
                                                        <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}" onsubmit="return confirm('Are you sure want to delete?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" type="submit">Delete</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endcan
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
