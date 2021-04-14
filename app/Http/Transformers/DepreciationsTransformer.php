<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Depreciation;
use Gate;
use Illuminate\Database\Eloquent\Collection;

class DepreciationsTransformer
{

    public function transformDepreciations (Collection $depreciations)
    {
        $array = array();
        foreach ($depreciations as $depreciation) {
            $array[] = self::transformDepreciation($depreciation);
        }
        return (new DatatablesTransformer)->transformDatatables($array);
    }

    public function transformDepreciation (Depreciation $depreciation)
    {
        $array = [
            'id' => (int) $depreciation->id,
            'name' => e($depreciation->name),
            'months' => $depreciation->months . ' '. trans('general.months'),
            'created_at' => Helper::getFormattedDateObject($depreciation->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($depreciation->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', Depreciation::class),
            'delete' => Gate::allows('delete', Depreciation::class),
        ];

        $array += $permissions_array;

        return $array;
    }



}
