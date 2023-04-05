<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Mange Users</a>
                </div>
                <div class="flex flex-col p-2 bg-slate-100">
                    <div>{{ $user->name }}</div>
                    <div>{{ $user->email }}</div>
                </div>
                <div class="md-6 p-2">
                    <h2 class="text-2xl font-semibold">Roles</h2>
                    <div class="flex space-x-2 mt-4 p-2">
                        @if ($user->roles)
                            @foreach ($user->roles as $user_role)
                                <form method="POST" action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}" onsubmit="return confirm('Are you sure want to delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" type="submit">{{ $user_role->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="max-w-xl mt-6">
                        <form method="POST" action="{{ route('admin.users.roles', $user->id) }}" class="w-full max-w-lg">
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
                </div>
                {{-- <div class="md-6 p-2">
                    <h2 class="text-2xl font-semibold">Permissions</h2>
                    <div class="flex space-x-2 mt-4 p-2">
                        @if ($user->permissions)
                            @foreach ($user->permissions as $user_permission)
                                <form method="POST" action="{{ route('admin.users.permissions.revoke', [$user->id, $user_permission->id]) }}" onsubmit="return confirm('Are you sure want to delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" type="submit">{{ $user_permission->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="max-w-xl mt-6">
                        <form method="POST" action="{{ route('admin.users.permissions', $user->id) }}" class="w-full max-w-lg">
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Permission</label>
                                    <select id="permission" name="permission" autocomplete="permission-name" class="mt-1 block w-full py-2 px-3 rounded">
                                        <option>Select Permission</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
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
