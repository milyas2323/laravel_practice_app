<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Manage Users</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="w-full max-w-lg">
                            @csrf
                            @method('PUT')
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Name</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-name" name="name" type="text" value="{{ $user->name; }}" placeholder="Enter Name">
                                    @error('name')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Email</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-email" name="email" type="text" value="{{ $user->email; }}" placeholder="Enter Email">
                                    @error('name')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Password</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="password" name="password" type="password" value="{{ old('password') }}" placeholder="Enter password">
                                    @error('password')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Confirm Password</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="password_confirmation" name="password_confirmation" type="password" value="" placeholder="Re-enter password">
                                    @error('password')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-cols-3 px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="guard_name">Role</label>
                                    @foreach($roles as $role)
                                        <div class="flex flex-col justify-cente">
                                            <div class="flex flex-col">
                                                <label class="inline-flex items-center mt-3">
                                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" name="roles[]" value="{{$role->id}}"
                                                    @if(count($user->roles->where('id',$role->id)))
                                                        checked
                                                    @endif
                                                    ><span class="ml-2 text-gray-700">{{ $role->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
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
            </div>
        </div>
    </div>
</x-admin-layout>
