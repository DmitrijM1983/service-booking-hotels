<x-app-layout>
    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <div class="flex flex-wrap mb-12">
            <div class="w-full flex justify-start md:w-1/3 mb-8 md:mb-0">
                <img class="h-full rounded-l-sm" src="{{ $hotel->poster_url }}" alt="Room Image">
            </div>
            <div class="w-full md:w-2/3 px-4">
                <div class="text-2xl font-bold">{{ $hotel->title }}</div>


                <div class="flex items-center">
                    {{ $hotel->address }}
                </div>
                <div>{{ $hotel->description }}</div>

                @if(auth()->check())
                    @if(\App\Services\UserService::is_admin(Auth::user()->id))
                        <x-nav-link style="width: 200px; margin-top: 20px; background-color: #1a202c; height: 50px; text-align: center; color: honeydew; border-radius: 5px" href="/edit_hotel_facilities/{{ $hotel->id }}" active="{{ request()->routeIs('edit_hotel_facilities') }}">
                            {{ __('Edit Facilities') }}
                        </x-nav-link>
                        <x-nav-link style="width: 150px; margin-top: 20px; background-color: #1a202c; height: 50px; text-align: center; color: honeydew; border-radius: 5px" href="/add_room/{{ $hotel->id }}" active="{{ request()->routeIs('add_room') }}">
                            {{ __('Add Room') }}
                        </x-nav-link>
                        <x-nav-link style="width: 150px; margin-top: 20px; background-color: #1a202c; height: 50px; text-align: center; color: honeydew; border-radius: 5px" href="/delete_hotel/{{ $hotel->id }}" active="{{ request()->routeIs('delete_hotel') }}">
                            {{ __('Delete Hotel') }}
                        </x-nav-link>
                    @endif
                @endif

            </div>
        </div>
        <div class="flex flex-col">
            @if(auth()->check())
                @if(\App\Services\UserService::is_admin(Auth::user()->id))
                    <div></div>
                @else
                <div class="text-2xl text-center md:text-start font-bold">Забронировать комнату</div>

                <form method="get" action="{{ url()->current() }}">
                    <div class="flex my-6">
                        <div class="flex items-center mr-5">
                            <div class="relative">
                                <label>Дата заезда
                                    <input name="start_date"  value="{{ $startDate ?? ''}}"
                                           placeholder="Дата заезда" type="date"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                </label>
                            </div>
                            <span class="mx-4 text-gray-500">по</span>
                            <div class="relative">
                                <label>Дата выезда
                                    <input name="end_date" type="date"  value="{{ $endDate ?? ''}}"
                                           placeholder="Дата выезда"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                </label>
                            </div>
                        </div>
                        <div>
                            <x-the-button type="submit" class=" h-full w-full">Загрузить номера</x-the-button>
                        </div>
                        <div style="width: 50px"></div>
                    </div>
                </form>
                @endif
            @endif

            @if(auth()->check())
                @if(\App\Services\UserService::is_admin(Auth::user()->id))
                        <div class="flex flex-col w-full lg:w-4/5">
                            @foreach($rooms as $room)
                                <x-rooms.room-list-item :room="$room" class="mb-4"></x-rooms.room-list-item>
                            @endforeach
                        </div>
                @endif
                @else
                <h1>Для получения актуальной информации о свободности номеров, необходимо авторизоваться.</h1>
            @endif

            @if(isset($startDate) && isset($endDate))
                <div class="flex flex-col w-full lg:w-4/5">
                    @foreach($rooms as $room)
                        <x-rooms.room-list-item :room="$room" :days="$days" startDate="{{ $startDate }}" endDate="{{ $endDate }}" class="mb-4"></x-rooms.room-list-item>
                    @endforeach
                </div>
            @else
                <div></div>
            @endif
        </div>
    </div>
</x-app-layout>
