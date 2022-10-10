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
        <div>Cursos</div>
        <div class="mr-2">
            <x-jet-button wire:click="confirmCourseAdd" class="bg-blue-500 hover:bg-blue-800">
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
                            <button wire:click="sortBy('category_id')">Categoria</button>
                                <x-sort-icon sortField="category_id" :sort-by="$sortBy" :sort-asc="$sortAsc" /> 
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')">Nombre</button>
                                <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" /> 
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('slug')">Slug</button>
                                <x-sort-icon sortField="slug" :sort-by="$sortBy" :sort-asc="$sortAsc" /> 
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('image')">imagen</button>
                                <x-sort-icon sortField="image" :sort-by="$sortBy" :sort-asc="$sortAsc" /> 
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('description')">Descripción</button>
                                <x-sort-icon sortField="description" :sort-by="$sortBy" :sort-asc="$sortAsc" /> 
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td class="mx-auto rounder border px-4 py-2">{{ $course->id }}</td>
                        <td class="mx-auto rounder border px-4 py-2">{{ $course->category_id }}</td>
                        <td class="mx-auto rounder border px-4 py-2">{{ $course->name }}</td>
                        <td class="mx-auto rounder border px-4 py-2">{{ $course->slug }}</td>
                        <td class="mx-auto rounder border px-4 py-2">{{ $course->image }}
                            <img src="{{ $course->image }}" alt="" class="mx-auto rounded-md mb-2">
                        </td>
                        <td class="mx-auto rounder border px-4 py-2">{{ $course->description }}</td>
                        <td class="mx-auto rounded border px-4 py-2">
                            <x-jet-button wire:click="confirmCourseEdit( {{ $course->id }} )" class="bg-green-500 hover:bg-green-800">
                                Editar
                            </x-jet-button>
                            <x-jet-danger-button wire:click="confirmCourseDeletion ({{ $course->id }}) " wire:loading.attr="disabled">
                                {{ __('Eliminar') }}
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>

    <x-jet-confirmation-modal wire:model="confirmingCourseDeletion">
            <x-slot name="title">
                {{ __('Eliminar Curso') }}
            </x-slot>

            <x-slot name="content">
                {{ __('¿Está seguro que desea eliminar el Curso?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingCourseDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteCourse ({{ $confirmingCourseDeletion }})" wire:loading.attr="disabled">
                    {{ __('Eliminar') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

        <x-jet-dialog-modal wire:model="confirmingCourseAdd">
            <x-slot name="title">
                {{ isset( $this->course->id) ? 'Editar Curso' : 'Crear Curso' }}
            </x-slot>

            <x-slot name="content">
                <div wire:loading wire:target='image' class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <span class="font-medium">¡Imagen!</span> Espere un momento hasta que la imagen se haya procesado.
                  </div>
                @if ($image)
                    <!--<img class="mb-4" src="{a{$image->temporaryUrl()}}">-->
                @endif
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Categoria') }}" />
                        <x-jet-input id="course.category_id" type="text" class="mt-1 block w-full" wire:model.defer="course.category_id" />
                        <x-jet-input-error for="course.category_id" class="mt-2" />
                </div>
                
           
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                        <x-jet-input id="course.name" type="text" class="mt-1 block w-full" wire:model.defer="course.name" />
                        <x-jet-input-error for="course.name" class="mt-2" />
                </div>
                
            
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Slug') }}" />
                        <x-jet-input id="course.slug" type="text" class="mt-1 block w-full" wire:model.defer="course.slug" />
                        <x-jet-input-error for="course.slug" class="mt-2" />
                </div>
                
                {{$image}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Imagen') }}" />
                       
                        <x-jet-input id="course.image" type="file" class="mt-1 block w-full" wire:model="course.image" />
                        <x-jet-input-error for="course.image" class="mt-2" />
                </div>
                
            
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Descripción') }}" />
                        <x-jet-input id="course.description" type="text" class="mt-1 block w-full" wire:model.defer="course.description" />
                        <x-jet-input-error for="course.description" class="mt-2" />
                </div>
                
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingCourseAdd', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="saveCourse (), image" wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
</div>