<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Manage Posts</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.posts.store') }}" class="w-full max-w-lg">
                            @csrf
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Title</label>
                                    <input class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-title" name="title" type="text" placeholder="Enter Title" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full px-3">
                                    <label for="description" class="text-gray-700 select-none font-medium">Description</label>
                                    <textarea name="description" id="description" placeholder="Enter description" class="appearance-none block w-full bg-gray-50 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-red-400 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full px-3">
                                    <label class="block tracking-wide text-xs font-bold mb-2" for="grid-name">Role</label>
                                    <div class="relative inline-flex">
                                        <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="publish">
                                          <option value="0">Draft</option>
                                          <option value="1">Publish</option>
                                        </select>
                                      </div>
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
