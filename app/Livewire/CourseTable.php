<?php

namespace App\Livewire;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use App\Models\Course;
use App\Models\Level;
use App\Models\Price;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Responsive;
use PowerComponents\LivewirePowergrid\Detail;

final class CourseTable extends PowerGridComponent
{
	public bool $deferLoading = true;
	public string $loadingComponent = 'components.my-custom-loading';

	use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [

//			Responsive::make(),
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns()->withoutLoading(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }
	//updates
	public function onUpdatedEditable(string|int $id, string $field, string $value): void
	{

		$updated =Course::query()->find($id)->update([
			$field => e($value),
		]);
		if ($updated) {
			$this->fillData();
		}
	}
	public function categoryChanged($levelId, $dishId): void
	{
		Course::query()->find($dishId)->update([
			"category_id" => $levelId,
		]);
	}
	public function levelChanged($categoryId, $dishId): void
	{
		Course::query()->find($dishId)->update([
			"level_id" => $categoryId,
		]);
	}
	public function priceChanged($priceId, $dishId): void
	{
		Course::query()->find($dishId)->update([
			"price_id" => $priceId,
		]);
	}
	//left joins
    public function datasource(): Builder
    {
		return Course::query()
			->join('categories', function ($categories) {
				$categories->on('courses.category_id', '=', 'categories.id');
			})
			->join('levels', function ($level) {
				$level->on('courses.level_id', '=', 'levels.id');
			})
			->leftJoin('prices', function ($price) {
				$price->on('courses.price_id', '=', 'prices.id');
			})
			->select('courses.*', 'categories.name as category_name', 'levels.name as level_name', 'prices.value as price_name');
    }

    public function relationSearch(): array
    {
        return [];
    }

	public function fields(): PowerGridFields
	{
		$options = $this->categorySelectOptions();
		$options_level = $this->levelSelectOption();
		$options_price = $this->priceSelectOption();
		return PowerGrid::fields()
			->add('id')
			->add('title')
			->add('description')
			->add('status')
			->add('image_path')
			->add('imagenes', function ($course) {
				return '<div style="width: 8rem; height: auto; overflow: hidden;">
                <img style="width: 100%; height: auto; object-fit: cover;" src="' . htmlspecialchars($course->image) . '" alt="Imagen">
            </div>';
			})
			->add('video_path')
			->add('welcome_message')
			->add('goodbye_message')
			->add('observation')
			->add('user_id')
			->add('level_id')
			->add('price_id', function ($dish) use ($options_price) {
				return view('components.select-category', [
					'options' => $options_price,
					'changeMethod' => 'priceChanged',
					'dishId' => $dish->id,
					'selected' => $dish->price_id
				])->render();
			})
			->add('created_at')
			->add('level_name', function ($dish) use ($options_level) {
				return view('components.select-category', [
					'options' => $options_level,
					'changeMethod' => 'levelChanged',
					'dishId' => $dish->id,
					'selected' => $dish->level_id
				])->render();
			})
			->add('category_name', function ($dish) use ($options) {
				return view('components.select-category', [
					'options' => $options,
					'changeMethod' => 'categoryChanged',
					'dishId' => $dish->id,
					'selected' => $dish->category_id
				])->render();
			});
	}


	public function columns(): array
    {
        return [
			Column::make('Imagen', 'imagenes')
				->headerAttribute('text-center'),

            Column::make('Titulo', 'title')
                ->sortable()
                ->searchable(),


            Column::make('Estado', 'status_name')
                ->searchable(),


			Column::make('Descripcion', 'description')
				->sortable()
				->editOnClick(
					hasPermission: auth()->check(),
					fallback: ''
				)
				->contentClasses('w-full h-full max-w-full overflow-auto whitespace-normal break-words')
				->searchable(),

            Column::make('Nivel', 'level_name'),
            Column::make('Categoria', 'category_name'),
            Column::make('Precio', 'price_id')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Course $row): array
    {
        return [
            Button::add('edit')
                ->slot('Editar')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }
	public function categorySelectOptions(): Collection
	{
		$data = Category::all(['id', 'name'])->mapWithKeys(function ($item) {
			return [
				$item->id => $item->name,
			];
		});
		return new Collection($data);
	}

	public function levelSelectOption(): Collection
	{
		$data = Level::all(['id', 'name'])->mapWithKeys(function ($item) {
			return [
				$item->id => $item->name,
			];
		});
		return new Collection($data);
	}
	public function priceSelectOption(): Collection
	{
		$data = Price::all(['id', 'value'])->mapWithKeys(function ($item) {
			return [
				$item->id => $item->value,
			];
		});
		return new Collection($data);
	}

	/*
	public function actionRules($row): array
	{
	   return [
			// Hide button edit for ID 1
			Rule::button('edit')
				->when(fn($row) => $row->id === 1)
				->hide(),
		];
	}
	*/
}
