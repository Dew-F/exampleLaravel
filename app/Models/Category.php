<?php

namespace App\Models;

use App\Extensions\CategoryRouteService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'uid',
        'name',
        'slug',
        'parent_uid',
        'category_type_id',
        'active',
        'sort',
        'category_footer_title',
        'category_footer_text'
    ];

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_uid');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_uid');
    }

    public function childrentree() {
        $result = $this->childrentreefunction($this->children, $this->children);
        return $result;
    }

    public function childrentreefunction($_children, $result) {
        foreach ($_children as $child) {
            if (count($child->children) > 0){
                $result = $result->merge($child->children);
                $result = $this->childrentreefunction($child->children, $result);
            }
        }
        return $result;
    }

    public function parenttree() {
        $result = $this->parenttreefunction($this);
        return $result;
    }

    public function parenttreefunction($_parent, array $result = []) {
        $result[] = $_parent;
        if (!is_null($_parent->parent_uid)){
            $result = $this->parenttreefunction($_parent->parent, $result);
        }
        return $result;
    }

    public function products(){
        $categoriesuids = $this->childrentree()->pluck('uid')->toArray();
        $categoriesuids[] = $this->uid;
        $result = Product::whereIn('category_uid', $categoriesuids)->where('active', 1)->get();
        return $result;
    }

    public function getRouteAttribute()
    {
        $categoryRouteService = app(CategoryRouteService::class);
        return $categoryRouteService->getRoute($this);
    }
}
