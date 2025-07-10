<?php

use App\Models\User;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;

new class extends Component {
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public $photo;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated',
            userName: $user->name,
            userEmail: $user->email
        );
    }


    /*
    * Method to update the profile picture
    */
    public function updateProfilePicture(CloudinaryUploadService $cloudinary): void
    {
        $this->validate([
            'photo' => ['required', 'image', 'max:2048'], // 2MB Max
        ]);

        $user = Auth::user();

        // Use the service to upload the photo
        $uploadedUrl = $cloudinary->upload(
            file: $this->photo,
            folder: 'user-profiles',
            publicId: 'user_' . $user->id
        );

        if ($uploadedUrl) {
            $user->update(['profile_picture' => $uploadedUrl]);
            Session::flash('status', 'profile-picture-updated');
            $this->reset('photo');
            $this->dispatch('profile-updated',
                profile_picture: $uploadedUrl,
                url: $uploadedUrl
            );
        } else {
            // Optionally handle upload failure
            Session::flash('status', 'profile-picture-failed');
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('marketplace', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')
    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <div class="flex flex-row gap-6 justify-between">
            <form wire:submit="updateProfilePicture" class="my-6 w-full space-y-6">
                @if (session('status') === 'profile-picture-updated')
                <p
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-show="show"
                    x-transition
                    class="text-sm text-green-600 dark:text-green-400"
                >
                    {{ __('Profile picture updated successfully.') }}
                </p>
                @endif

                <!-- Current Profile Picture -->
                <div class="flex items-center gap-4">
                    @if (Auth::user()->profile_picture)
                    <img src="{{ Auth::user()->profile_picture }}" alt="{{ Auth::user()->name }}" class=" h-40 w-40 rounded-full border border-neutral-400 object-cover">
                    @else
                    <div class="flex h-40 w-40 items-center justify-center rounded-full border border-neutral-400 bg-zinc-200 dark:bg-zinc-800 ">
                        <span class="text-7xl font-semibold text-zinc-600 dark:text-zinc-400">{{ Auth::user()->initials() }}</span>
                    </div>
                    @endif
                </div>

                <!-- File Input using flux component -->
                <flux:input
                    wire:model="photo"
                    type="file"
                    hidden
                    :label="__('New Photo')"
                    id="photo" />

                <div class="flex items-center gap-4">
                    <flux:button variant="primary" type="submit">
                        <span wire:loading.remove wire:target="updateProfilePicture">{{ __('Save Photo') }}</span>
                        <span wire:loading wire:target="updateProfilePicture">{{ __('Uploading...') }}</span>
                    </flux:button>
                </div>
            </form>
            <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6 ">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                        <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
                <livewire:settings.delete-user-form />

            </form>
        </div>

    </x-settings.layout>
</section>
