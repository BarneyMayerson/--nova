<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Book extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Book>
     */
    public static $model = \App\Models\Book::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'blurb',
        'author.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Image::make('Cover')
                ->path('cover'),

            Text::make('Title')
                ->sortable()
                ->rules(['required', 'string', 'min:1', 'max:255'])
                ->creationRules('unique:books,title')
                ->updateRules('unique:books,title,{{resourceId}}'),

            BelongsTo::make('Author')
                ->sortable(),

            BelongsTo::make('Publisher')
                ->filterable()
                ->hideFromIndex(),

            Trix::make('Blurb')
                ->alwaysShow()
                ->fullWidth(),

            Number::make('Pages', 'number_of_pages')
                ->filterable()
                ->hideFromIndex()
                ->rules(['required', 'integer', 'min:1', 'max:10000']),

            Number::make('Copies', 'number_of_copies')
                ->sortable()
                ->required()
                ->help('The total number of copies of this book that the library owns.'),

            Boolean::make('Featured', 'is_featured')
                ->sortable()
                ->filterable()
                ->help('Whether this book is featured on the homepage.'),

            File::make('PDF')
                ->path('pdfs')
                ->acceptedTypes('.pdf'),
            
            URL::make('Purchase URL')
                ->displayUsing(fn($value) => $value ? parse_url($value, PHP_URL_HOST) : null),

            BelongsTo::make('Genre'),

            BelongsTo::make('Subgenre', resource: Genre::class),

            HasMany::make('Audio Recordings', 'recordings', resource: Recording::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
