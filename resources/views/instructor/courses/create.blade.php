<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear un nuevo curso
        </h2>
    </x-slot>

    <x-container class="mt-12 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('instructor.courses.store') }}" method="POST">
                @csrf
                <h2 class="text-2xl uppercase text-center mb-4">
                    Complete esta información para crear un nuevo curso
                </h2>
                <x-validation-errors class="mb-4" />
                <div class="mb-4">
                    <x-label for="course-name" class="mb-1">
                        Nombre del curso
                    </x-label>
                    <x-input
                            name="title"
                            placeholder="Nombre del curso"
                            class="w-full"
                            value="{{ old('title') }}"
                            oninput="string_to_slug(this.value, '#slug')"
                    />
                </div>
                <div class="mb-4">
                    <x-label for="course-name" class="mb-1">
                        Slug
                    </x-label>
                    <x-input
                            id="slug"
                            name="slug"
                            placeholder="Slug del curso"
                            class="w-full"
                            value="{{ old('slug') }}"
                    />
                </div>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <x-label class="mb-1">
                            Categorías
                        </x-label>
                        <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-label class="mb-1">
                            Niveles
                        </x-label>
                        <select name="level_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($levels as $level)
                            <option value="{{ $level->id }}" @selected(old('level_id') == $level->id)>
                            {{ $level->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-label class="mb-1">
                            Precios
                        </x-label>
                        <select name="price_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($prices as $price)
                            <option value="{{ $price->id }}" @selected(old('price_id') == $price->id)>
                                @if($price->value == 0)
                                    Gratis
                                @else
                                    S/. {{ $price->value }} .00
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button>
                        Crear curso
                    </x-button>
                </div>

            </form>
        </div>
    </x-container>
</x-instructor-layout>