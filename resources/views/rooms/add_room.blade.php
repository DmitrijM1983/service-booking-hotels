<x-app-layout>
    <div style="margin-left: auto; margin-right: auto; margin-top: 50px" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <H1><b>Добавить номер</b></H1>
        <form action="{{ route('save.room') }}" method="post">
            @csrf
            <div>
                <x-label for="title">Название</x-label>
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" />
            </div>
            <div>
                <x-label for="description">Описание</x-label>
                <x-input id="description" class="block mt-1 w-full" type="text" name="description" />
            </div>
            <div>
                <x-label for="poster_url">Ссылка на фотографию</x-label>
                <x-input id="poster_url" class="block mt-1 w-full" type="text" name="poster_url" />
            </div>
            <div>
                <x-label for="flour_area">Этаж</x-label>
                <x-input id="flour_area" class="block mt-1 w-full" type="text" name="flour_area" />
            </div>
            <div>
                <x-label for="price">Цена</x-label>
                <x-input id="price" class="block mt-1 w-full" type="text" name="price" />
            </div>
            <input type="hidden" name="hotel_id" value="{{ $hotel_id }}"
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    Сохранить
                </x-button>
            </div>
        </form>
    </div>
    @if ($errors->any())
        <div>
            <ul style="width:300px; color: red; margin-left: auto; margin-right: auto; margin-top: 20px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-app-layout>>

