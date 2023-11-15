<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }} <small> > {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-indigo-800">User Information</h3>
                    <ul>
                        <li class="text-base font-bold p-2">Name: <span class="text-gray-600">{{ $user->name }}</span>
                        </li>
                        <li class="text-base font-bold p-2">ID: <span class="text-gray-600">{{ $user->uuid }}</span>
                        </li>
                        <li class="text-base font-bold p-2">Email: <span
                                class="text-gray-600">{{ $user->email }}</span></li>
                        <li class="text-base font-bold p-2">Sub Account: <span
                                class="text-gray-600">{{ $user->sub_account_id }}</span></li>
                        <li class="text-base font-bold p-2">Account Type: <span
                                class="text-gray-600">{{ $user->type }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-indigo-800">Wallet</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 justify-between mt-2">
                        @foreach ($wallets as $wallet)
                            <div
                                class="m-2 mt-4rounded-lg shadow-lg p-3 space-y-4 {{ $wallet->type == 'chi' ? 'order-first' : '' }} ">
                                <h4 class="font-bold text-lg">{{ $wallet_type[$wallet->type] }}</h4>
                                <p class="text-lg">${{ number_format($wallet->balance ?? 0, 2) }}</p>
                                @if (isAdmin() && $wallet->type == 'chi')
                                    <div class="flex w-full justify-end">
                                        <a href="{{ route('user.account.top-up-form', $user->uuid) }}"
                                            class="flex-end text-base text-center hover:bg-purple-600 bg-purple-700 text-white font-bold px-3 py-2 rounded-lg">Top
                                            Up</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
