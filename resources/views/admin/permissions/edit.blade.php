<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Manage Permissions</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="w-full max-w-lg">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name"> Permission Name</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-name" name="name" type="text" value="{{ $permission->name; }}" placeholder="Enter Name">
                                    @error('name')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="guard_name">Guard</label>
                                    <select id="guard_name" name="guard_name" autocomplete="guard_name" class="mt-1 block w-full py-2 px-3 rounded">
                                        <option value="web" {{ $permission->guard_name == 'web' ? 'selected' : '' }}>web</option>
                                        <option value="admin" {{ $permission->guard_name == 'admin' ? 'selected' : '' }}>admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 mt-5">
                                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="md-6 p-2">
                    <h2 class="text-2xl font-semibold">Roles</h2>
                    <div class="flex space-x-2 mt-4 p-2">
                        @if ($permission->roles)
                            @foreach ($permission->roles as $permission_role)
                                <form method="POST" action="{{ route('admin.permissions.roles.remove', [$permission->id, $permission_role->id]) }}" onsubmit="return confirm('Are you sure want to delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" type="submit">{{ $permission_role->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="max-w-xl mt-6">
                        <form method="POST" action="{{ route('admin.permissions.roles', $permission->id) }}" class="w-full max-w-lg">
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Roles</label>
                                    <select id="role" name="role" autocomplete="role-name" class="mt-1 block w-full py-2 px-3 rounded">
                                        <option>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full px-3  mt-5">
                                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-admin-layout>
