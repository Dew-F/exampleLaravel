<?php

namespace App\Extensions;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRouteService
{
    private $routes = [];

    public function __construct()
    {
        $this->determineCategoriesRoutes();
    }

    public function getRoute(Category $category)
    {
        return $this->routes[$category->uid];
    }

    private function determineCategoriesRoutes()
    {
        $categories = Category::all()->keyBy('uid');

        foreach ($categories as $uid => $category) {
            $slugs = $this->determineCategorySlugs($category, $categories);

            if (count($slugs) === 1) {
                $this->routes[$uid] = url('category/' . $slugs[0]);
            }
            else {
                $this->routes[$uid] = url('category/' . implode('/', $slugs));
            }
        }
    }

    private function determineCategorySlugs(Category $category, Collection $categories, array $slugs = [])
    {
        array_unshift($slugs, $category->slug);

        if (!is_null($category->parent_uid)) {
            $slugs = $this->determineCategorySlugs($categories[$category->parent_uid], $categories, $slugs);
        }

        return $slugs;
    }
}
