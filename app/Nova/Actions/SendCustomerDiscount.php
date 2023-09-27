<?php

namespace App\Nova\Actions;

use App\Services\DiscountService\DiscountService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendCustomerDiscount extends Action
{
    use InteractsWithQueue, Queueable;

    public function __construct(private DiscountService $discountService)
    {
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(fn($customer) => $this->discountService->email($customer, $fields['discount']));
    }

    /**
     * Get the fields available on the action.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Number::make('Discount')
                ->default(fn () => 10)
                ->min(1)
                ->max(100)
                ->rules('required', 'integer', 'min:1', 'max:100'),
        ];
    }
}