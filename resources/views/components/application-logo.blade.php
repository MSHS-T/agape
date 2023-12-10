<img src="/{{ env('APP_LOGO') }}" {{ $attributes->class(['w-96 dark:hidden'])->merge() }} alt="Logo AGAPE" />
<img src="/{{ env('APP_LOGO_DARK') }}" {{ $attributes->class(['w-96 hidden dark:inline'])->merge() }} alt="Logo AGAPE" />
