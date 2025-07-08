<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
  #[Validate('required|min:3|max:20')]
  public string $name = '';
  public string $greeting = '';

  public function changeName()
  {
    $this->validate();
  }

  public function mount()
  {
    $this->greeting = 'Hello';
  }
} ?>

<div class="">
    <form wire:submit="changeName()">
        <select wire:model.fill="greeting" class="border p-2 rounded mb-4">
            <option value="Hello">Hello</option>
            <option value="Hi">Hi</option>
            <option value="Greetings">Greetings</option>
            <option value="Welcome">Welcome</option>
        </select>
        <input type="text" wire:model.live="name" class="border p-2 rounded"/>
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Change Name</button>
    </form>

    @if($name)
        <h1 class="mx-1.5">{{$greeting . ' ' . $name }}</h1>
    @endif

</div>
