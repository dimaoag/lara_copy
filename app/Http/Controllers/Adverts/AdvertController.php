<?php

namespace App\Http\Controllers\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\SearchRequest;
//use App\Http\Router\AdvertsPath;
//use App\ReadModel\AdvertReadRepository;
use App\Http\Router\AdvertsPath;
use App\UseCases\Adverts\SearchService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdvertController extends Controller
{
    private $search;

    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }



//    public function index(SearchRequest $request, AdvertsPath $path)
//    {
//
//        $region = $path->region;
//        $category = $path->category;
//
//
//        $regions = $region
//            ? $region->children()->orderBy('name')->getModels()
//            : Region::roots()->orderBy('name')->getModels();
//
//        $categories = $category
//            ? $category->children()->defaultOrder()->getModels()
//            : Category::whereIsRoot()->defaultOrder()->getModels();
//
//        $adverts = $this->search->search($category, $region, $request, 20, $request->get('page',  1));
//
//        return view('adverts.index', compact(
//            'region', 'category',
//            'categories', 'regions',
//            'adverts'
//        ));
//    }


        public function index(SearchRequest $request, AdvertsPath $path)
    {
        $region = $path->region;
        $category = $path->category;

        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        $adverts = $result->adverts;
        $regionsCounts = $result->regionsCounts;
        $categoriesCounts = $result->categoriesCounts;



        $query = $region ? $region->children() : Region::roots();
        $regions = $query->orderBy('name')->getModels();

        $query = $category ? $category->children() : Category::whereIsRoot();
        $categories = $query->defaultOrder()->getModels();

//        $regions = array_filter($regions, function (Region $region) use ($regionsCounts) {
//            return isset($regionsCounts[$region->id]) && $regionsCounts[$region->id] > 0;
//        });
//
//        $categories = array_filter($categories, function (Category $category) use ($categoriesCounts) {
//            return isset($categoriesCounts[$category->id]) && $categoriesCounts[$category->id] > 0;
//        });

        return view('adverts.index', compact(
            'category', 'region',
            'categories', 'regions',
            'regionsCounts', 'categoriesCounts',
            'adverts'
        ));
    }



//    public function index(AdvertsPath $path)
//    {
//
//        $region = $path->region;
//        $category = $path->category;
//
//
//        $query = Advert::active()->with(['category', 'region'])->orderByDesc('published_at');
//
//        if ($category){
//            $query->ForCategory($category);
//        }
//
//        if ($region){
//            $query->ForRegion($region);
//        }
//
//        $regions = $region
//            ? $region->children()->orderBy('name')->getModels()
//            : Region::roots()->orderBy('name')->getModels();
//
//        $categories = $category
//            ? $category->children()->defaultOrder()->getModels()
//            : Category::whereIsRoot()->defaultOrder()->getModels();
//
//        $adverts = $query->paginate(20);
//
//
//
//        return view('adverts.index', compact(
//            'region', 'category',
//            'categories', 'regions',
//            'adverts'
//        ));
//    }




//    public function index(Region $region = null, Category $category = null)
//    {
//        $query = Advert::active()->with(['category', 'region'])->orderByDesc('id');
//
//        if ($category){
//            $query->ForCategory($category);
//        }
//
//        if ($region){
//            $query->ForRegion($region);
//        }
//
//        $regions = $region
//            ? $region->children()->orderBy('name')->getModels()
//            : Region::roots()->orderBy('name')->getModels();
//
//        $categories = $category
//            ? $category->children()->defaultOrder()->getModels()
//            : Category::whereIsRoot()->defaultOrder()->getModels();
//
//        $adverts = $query->paginate(20);
//
//
//
//        return view('adverts.index', compact(
//            'region', 'category',
//            'categories', 'regions',
//            'adverts'
//        ));
//    }



    public function show(Advert $advert)
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        $user = Auth::user();

        return view('adverts.show', compact('advert', 'user'));
    }

    public function phone(Advert $advert): string
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        return $advert->user->phone;
    }
}
