<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(auth()->check())
                    <div class="p-6 bg-white border-b border-gray-200">
                        Добро пожаловать, {{ Auth::user()->full_name }}! <a href="{{ route('hotels.index') }}" class="text-blue-500">Перейти к выбору отеля</a>
                    </div>
                @else
                <div class="p-6 bg-white border-b border-gray-200">
                    Добро пожаловать! <a href="{{ route('hotels.index') }}" class="text-blue-500">Перейти к выбору отеля</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
