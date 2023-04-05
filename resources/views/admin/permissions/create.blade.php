<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Manage Permissions</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.permissions.store') }}" class="w-full max-w-lg">
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Permission Name</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-name" name="name" type="text" placeholder="Enter Name">
                                    @error('name')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="guard_name">Guard</label>
                                    <select id="guard_name" name="guard_name" autocomplete="guard_name" class="mt-1 block w-full py-2 px-3 rounded">
                                        <option value="web">web</option>
                                        <option value="admin">admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 mt-5">
                                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
