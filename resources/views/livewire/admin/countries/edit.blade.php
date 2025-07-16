<x-layouts.app>
    <div class="py-8 px-4 sm:px-8">
        <div class="max-w-lg mx-auto">
            <div class="bg-white dark:bg-zinc-800 p-8 rounded-xl shadow">
                <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-zinc-100">Edit Country</h2>
                <form action="{{ route('admin.countries.update', $country) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block mb-1 font-medium" for="name">Name</label>
                        <input type="text" name="name" id="name" class="input w-full"
                            value="{{ old('name', $country->name) }}" required autocomplete="off">
                        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium" for="code">Code</label>
                            <input type="text" name="code" id="code" class="input w-full"
                                value="{{ old('code', $country->code) }}" maxlength="3" required autocomplete="off">
                            @error('code') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium" for="team_id">Team</label>
                            <select name="team_id" id="team_id" class="input w-full" required>
                                <option value="">Select Team</option>
                                @foreach(\App\Models\Team::all() as $team)
                                    <option value="{{ $team->id }}" @if(old('team_id', $country->team_id) == $team->id)
                                    selected @endif>{{ $team->name }}</option>
                                @endforeach
                            </select>
                            @error('team_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium" for="currency_name">Currency Name</label>
                            <input type="text" name="currency_name" id="currency_name" class="input w-full"
                                value="{{ old('currency_name', $country->currency_name) }}" required autocomplete="off">
                            @error('currency_name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium" for="currency_code">Currency Code</label>
                            <input type="text" name="currency_code" id="currency_code" class="input w-full"
                                value="{{ old('currency_code', $country->currency_code) }}" maxlength="3" required
                                autocomplete="off">
                            @error('currency_code') <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium" for="currency_symbol">Currency Symbol</label>
                            <input type="text" name="currency_symbol" id="currency_symbol" class="input w-full"
                                value="{{ old('currency_symbol', $country->currency_symbol) }}" maxlength="5" required
                                autocomplete="off">
                            @error('currency_symbol') <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium" for="balance">Balance</label>
                            <input type="number" name="balance" id="balance" class="input w-full"
                                value="{{ old('balance', $country->balance) }}" min="0" required>
                            @error('balance') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium" for="logo">Logo</label>
                            @if($country->logo)
                                <img src="{{ asset('storage/' . $country->logo) }}" alt="Logo"
                                    class="h-12 w-12 object-cover rounded mb-2" />
                            @endif
                            <input type="file" name="logo" id="logo" class="input w-full">
                            @error('logo') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block mb-1 font-medium" for="flag">Flag</label>
                            @if($country->flag)
                                <img src="{{ asset('storage/' . $country->flag) }}" alt="Flag"
                                    class="h-12 w-12 object-cover rounded mb-2" />
                            @endif
                            <input type="file" name="flag" id="flag" class="input w-full">
                            @error('flag') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
