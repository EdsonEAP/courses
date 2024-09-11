<x-instructor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Cursos
        </h2>
    </x-slot>
    <x-container class="mt-12 max-w-7xl">
       <div class="md:flex md:justify-end mb-12">
           <a href="{{route('instructor.courses.create')}}" class="btn btn-red block w-full md:w-auto text-center hover:bg-red-700">
               Crear Curso
           </a>
       </div>
        <livewire:course-table/>


    </x-container>

</x-instructor-layout>