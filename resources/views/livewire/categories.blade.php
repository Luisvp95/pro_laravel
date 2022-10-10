<div class="p-2 sm:px-20 bg-white border-b border-gray-200">
    @if (session() ->has('message'))
        <div class="bg-indigo-600" x-data="{show:true}" x-show="show">
          <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
              <div class="w-0 flex-1 flex items-center">
                <span class="flex p-2 rounded-lg bg-indigo-800">
                  <!-- Heroicon name: outline/speakerphone -->
                  <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                  </svg>
                </span>
                <p class="ml-3 font-medium text-white truncate">
                  <span class="hidden md:inline">
                    {{ session('message') }}
                  </span>
                </p>
              </div>
              <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                <button type="button" class="-mr-1 flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2" @click="show = false">
                  <span class="sr-only">Dismiss</span>
                  <!-- Heroicon name: outline/x -->
                  <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
    @endif

    <div class="mt-4 text-2xl flex justify-between shadow-inner">
        <div>Categoria</div>
        <div class="mr-2">
            <x-jet-button wire:click="confirmCategoryAdd" class="bg-blue-500 hover:bg-blue-800">
                Nuevo
            </x-jet-button>
        </div>
    </div>

    <div class="mt-3">
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.500ms="q" type="search" placeholder="Buscar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder-blue-400" name="">
            </div>
        </div>
        
        <table class="table-auto w-full border-separate border rounded table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                        <button wire:click="sortBy('id')">Id</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Nombre</button>
                                <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" /> 
                        </div>
                    </th>
                    
                    <th class="px-4 py-2">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="rounded border px-4 py-2">{{ $category->id }}</td>
                        <td class="rounded border px-4 py-2">{{ $category->name }}</td>
                        <td class="rounded border px-4 py-2">
                            <x-jet-button wire:click="confirmCategoryEdit( {{ $category->id }} )" class="bg-green-500 hover:bg-green-800">
                                Editar
                            </x-jet-button>
                            <x-jet-danger-button wire:click="confirmCategoryDeletion ({{ $category->id }}) " wire:loading.attr="disabled">
                                {{ __('Eliminar') }}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    <x-jet-confirmation-modal wire:model="confirmingCategoryDeletion">
            <x-slot name="title">
                {{ __('Eliminar Categoria') }}
            </x-slot>

            <x-slot name="content">
                {{ __('¿Está seguro que desea eliminar la Categoria?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingCategoryDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteCategory ({{ $confirmingCategoryDeletion }})" wire:loading.attr="disabled">
                    {{ __('Eliminar') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

        <x-jet-dialog-modal wire:model="confirmingCategoryAdd">
            <x-slot name="title">
                {{ isset( $this->category->id) ? 'Editar Categoria' : 'Crear Categoria' }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                        <x-jet-input id="category.name" type="text" class="mt-1 block w-full" wire:model.defer="category.name" />
                        <x-jet-input-error for="category.name" class="mt-2" />
                </div>
                
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingCategoryAdd', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="saveCategory ()" wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>