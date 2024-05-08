<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row shadow-md']) }}>
    <div class="h-full w-full md:w-2/5">
        <div class="h-64 w-full bg-cover bg-center bg-no-repeat" style="background-image: url({{ $room->poster_url }})">
        </div>
    </div>
    <div class="p-4 w-full md:w-3/5 flex flex-col justify-between">
        <div class="pb-2">
            <div class="text-xl font-bold">
                {{ $room->title }}
            </div>
            <div>
               <span>•</span> {{ $room->flour_area }} этаж
            </div>
            <div>
                @foreach($room->facilities as $facility)
                    <span>• {{ $facility->title }} </span>
                @endforeach
            </div>
        </div>
        <hr>
        @if(\App\Services\UserService::is_admin(Auth::user()->id))
            <x-nav-link style="width: 150px; margin-top: 20px; background-color: #1a202c; height: 50px; text-align: center; color: honeydew; border-radius: 5px" href="/edit_room_facilities/{{ $room->id }}" active="{{ request()->routeIs('edit_room_facilities') }}">
                {{ __('Edit Facilities') }}
            </x-nav-link>
        @endif

        @if(!\App\Services\UserService::is_admin(Auth::user()->id))
        <div class="flex justify-end pt-2">
            <div class="flex flex-col">
                <span class="text-lg font-bold">{{ $price = $room->getTotalPrice($days) }} руб.</span>
                <span>за {{ $days }} ночей</span>
            </div>

            <form class="ml-4" method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="started_at" value="{{ $startDate }}">
                <input type="hidden" name="finished_at" value="{{ $endDate }}">
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="days" value="{{ $days }}">
                <input type="hidden" name="price" value="{{ $price }}">
                @if(auth()->check())
                <x-the-button class=" h-full w-full">{{ __('Book') }}</x-the-button>
                @else
                <div>
                    <h3 style="background-color: rebeccapurple; height: 50px; border-radius: 3px;"><b>Для бронирования номера необходимо авторизоваться</b></h3>
                </div>
                @endif
            </form>
        </div>
        @endif
    </div>
</div>

