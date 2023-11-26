<x-filament-panels::page>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-4xl sm:text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                            {{ __('pages.dashboard.expert.open_offers') }}
                        </h2>
                    </div>
                    <div class="my-8 gap-4 flex flex-col justify-center items-stretch" id="open-offers">
                        @forelse ($openOffers as $offer)
                            <x-filament.evaluation-offer :offer="$offer" wire:key="open-offer-{{ $offer->id }}" />
                        @empty
                            <h3 class="text-xl font-semibold italic tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                id="no-open-offers">
                                {{ __('pages.dashboard.expert.no_open_offer') }}
                            </h3>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-4xl sm:text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                            {{ __('pages.dashboard.expert.pending_evaluations') }}
                        </h2>
                    </div>
                    <div class="my-8 gap-4 flex justify-center" id="pending-evaluation">
                        @forelse ($pendingEvaluation as $offer)
                            <x-filament.evaluation-offer :offer="$offer"
                                wire:key="pending-evaluation-{{ $offer->id }}" />
                        @empty
                            <h3 class="text-xl font-semibold italic tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                id="no-pending-evaluation">
                                {{ __('pages.dashboard.expert.no_pending_evaluation') }}
                            </h3>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-4xl sm:text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl pt-8">
                            {{ __('pages.dashboard.expert.past_evaluations') }}
                        </h2>
                    </div>
                    <div class="my-8 gap-4 flex justify-center" id="past-evaluation">
                        @forelse ($doneEvaluation as $offer)
                            <x-filament.evaluation-offer :offer="$offer"
                                wire:key="past-evaluation-{{ $offer->id }}" />
                        @empty
                            <h3 class="text-xl font-semibold italic tracking-tight text-gray-900 dark:text-white text-center pt-8"
                                id="no-past-evaluation">
                                {{ __('pages.dashboard.expert.no_past_evaluation') }}
                            </h3>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-filament-actions::modals />
</x-filament-panels::page>
