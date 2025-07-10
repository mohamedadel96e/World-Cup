<div class="flex aspect-square size-8 items-center justify-center rounded-full bg-accent-content text-accent-foreground">
    <x-app-logo-icon :imageUrl="auth()->user()->country->flag ?? asset('images/appLogo.png')"  class="size-5 fill-current text-white dark:text-black" />
</div>
<div class="ms-1 grid flex-1 text-start text-sm">
    <span class="mb-0.5 truncate leading-tight font-semibold">{{ config('app.name') }}</span>
</div>
