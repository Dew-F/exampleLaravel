<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class GenerateYML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:products {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export products to an XML file';

    // URL сайта

    public $SITE_URL = 'https://localhost.ru/';

    // Название сайта

    public $SITE_NAME = 'Полиграфический комбинат ООО "localhost"';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->argument('file');
        $filePath = storage_path('app/public/export/').$fileName;

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'.
                                    '<yml_catalog date="'.date('Y-m-d\TH:i:sP').'"></yml_catalog>');
        $shop = $xml->addChild('shop');

        //Заполенение статики
        $shop->addChild('name', $this->SITE_NAME);
        $shop->addChild('company', $this->SITE_NAME);
        $shop->addChild('url', $this->SITE_URL);
        $shop->addChild('platform', 'uCoz');
        $shop->addChild('version', '1.0');

        //Валюта
        $currencies = $shop->addChild('currencies');
        $currency = $currencies->addChild('currency');
        $currency->addAttribute('id', 'RUB');

        //Категории
        $categories = $shop->addChild('categories');

        $productCategories = Category::where('active', 1)->pluck('uid')->toArray();
        $productMainCategories = Category::where('active', 1)->whereNull('parent_uid')->get();

        //Древо категорий
        foreach ($productMainCategories as $productCategory) {
            $xmlCategory = $categories->addChild('category', $productCategory->name);
            $xmlCategory->addAttribute('id', array_search($productCategory->uid, $productCategories));
            $this->CategoryTree($productCategory, $categories, $productCategories);
        }

        //Добавить офферы
        $offers = $shop->addChild('offers');

        $products = Product::where('active', 1)->get();

        foreach ($products as $product) {
            $offer = $offers->addChild('offer');
            $offer->addAttribute('id', array_search($product->uid, $products->pluck('uid')->toArray()));
            $offer->addAttribute('available', 'true');

            $offer->addChild('url', $product->route);
            $offer->addChild('price', $product->price);
            $offer->addChild('currencyId', 'RUB');
            $offer->addChild('categoryId', array_search($product->category_uid, $productCategories));
            $offer->addChild('picture', $product->photo());
            $offer->addChild('name', $product->name);
            $offer->addChild('vendor', $this->SITE_NAME);
            $offer->addChild('vendorCode', 1);
            $offer->addChild('description', $product->description);
        }

        //Сохраняю файл
        $domxml = new \DOMDocument('1.0');
        $domxml->preserveWhiteSpace = false;
        $domxml->formatOutput = true;
        $domxml->loadXML($xml->asXML());
        $domxml->save($filePath);

        $this->info('Products exported successfully to ' . $filePath);
    }

    public function CategoryTree($category, $categories, $productCategories){
        if (count($category->children) > 0) {
            foreach ($category->children as $child){
                $xmlCategory = $categories->addChild('category', $child->name);
                $xmlCategory->addAttribute('id', array_search($child->uid, $productCategories));
                $xmlCategory->addAttribute('parentId', array_search($category->uid, $productCategories));
                $this->CategoryTree($child, $categories, $productCategories);
            }
        }
    }
}
