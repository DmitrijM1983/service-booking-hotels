<x-app-layout>
    <div style="margin-left: auto; margin-right: auto; margin-top: 50px" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <H1><b>Редактирование удобств</b></H1>
        <form action="{{ route('save.hotel.facilities') }}" method="post">
            @csrf
            <input type="hidden" name="hotel_id" value="{{ $hotel_id }}">
            @foreach($facilities as $facility)
                <div>
                    <input type="checkbox"  id="{{ $facility['id'] }}" name="{{ $facility['id'] }}">
                    <label for="{{ $facility['id'] }}">{{ $facility['title'] }}</label>
                </div>
            @endforeach
            <div>
                <x-button  class="ml-3">
                    Обновить
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>


