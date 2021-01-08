<div>
    @if (session()->has('success'))
        <div class="py-3 px-4 bg-green-300 text-green-900 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif
    <x-jet-button type="button" class="mb-5" wire:click="openNewAppModal">add new application</x-jet-button>


    <x-jet-dialog-modal wire:model="createNewAppModalOpened">
        <x-slot name="title">
            create new application
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Name') }}"/>
                <x-jet-input id="name" wire:model.debounce.500ms="name" class="block mt-1 w-full" type="text"/>
                @error('name') <span class="text-red-800 text-sm">{{ $message }}</span>@enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="owner_name" value="{{ __('Owner Name') }}"/>
                <x-jet-input id="owner_name" wire:model.debounce.500ms="owner_name" class="block mt-1 w-full"
                             type="text"/>
                @error('owner_name') <span class="text-red-800 text-sm">{{ $message }}</span>@enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="owner_mobile" value="{{ __('Owner Mobile') }}"/>
                <x-jet-input id="owner_mobile" wire:model.debounce.800ms="owner_mobile" class="block mt-1 w-full"
                             type="text"/>
                @error('owner_mobile') <span class="text-red-800 text-sm">{{ $message }}</span>@enderror
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeNewAppModal" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="createApplication" wire:loading.attr="disabled">
                Save
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="updateAppModalOpened">
        <x-slot name="title">
            create new application
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="update_name" value="{{ __('Name') }}"/>
                <x-jet-input id="update_name" wire:model.debounce.500ms="name" class="block mt-1 w-full" type="text"
                             value="{{ $name }}"/>
                @error('name') <span class="text-red-800 text-sm">{{ $message }}</span>@enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="update_owner_name" value="{{ __('Owner Name') }}"/>
                <x-jet-input id="update_owner_name" wire:model.debounce.500ms="owner_name" class="block mt-1 w-full"
                             type="text" value="{{ $owner_name }}"/>
                @error('owner_name') <span class="text-red-800 text-sm">{{ $message }}</span>@enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="update_owner_mobile" value="{{ __('Owner Mobile') }}"/>
                <x-jet-input id="update_owner_mobile" wire:model.debounce.800ms="owner_mobile" class="block mt-1 w-full"
                             type="text" value="{{ $owner_mobile }}"/>
                @error('owner_mobile') <span class="text-red-800 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mt-4">
                <input type="checkbox"
                       id="status"
                       {{ $application_status ? 'checked' : '' }}
                       wire:model="application_status"
                       class='rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'/>
                <label for="status">Activated</label>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeUpdateAppModal" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updateApplication" wire:loading.attr="disabled">
                Edit
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="deleteAppModalOpened">
        <x-slot name="title">
            Delete Application
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this application? Once application is deleted, it will be down on their
            server.
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeDeleteAppModal" wire:loading.attr="disabled">
                Nevermind
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteApplication" wire:loading.attr="disabled">
                Delete Application
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Owner
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    IP Address
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <span>Action</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($applications as $application)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $application->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $application->owner_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $application->owner_mobile }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{$application->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}}">
                                  {{ $application->status ? 'Active' : 'Down' }}
                                </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm text-gray-900">{{ $application->ip_address ?? "The application didn't run yet" }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" wire:click.prevent="openUpdateAppModal({{ $application->id }})"
                                           class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <a href="#" wire:click.prevent="openDeleteAppModal({{ $application->id }})"
                                           class="text-red-600 ml-4 hover:text-indigo-900">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-gray-500"> There is no Applications
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








