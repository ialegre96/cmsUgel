<?php

namespace App\Http\Controllers;

use App\Advertising;
use App\Charge;
use App\Slider;
use App\Article;
use App\Partner;
use App\Reassign;
use App\Documents;
use App\Normativity;
use App\Announcements;
use App\Contract;
use App\Control;
use App\DocumentTree;
use App\InterestLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{

    private $mediaCollection = 'files';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $partners = Partner::get();
        $articles = Article::orderBy('modificado', 'desc')->where([['idarticulo_categoria', '=', 5], ['estado', '=', 1]])->take(3)->get();
        $announcements = Announcements::select('id', 'nombre', 'imagen', 'fecha', 'descripcion')->where('estado', 1)->take(3)->get();
        $links = InterestLink::orderBy('modificado', 'desc')->where([['idservicio_categoria', '=', 1], ['estado', '=', 1]])->get();
        $directLinks = InterestLink::orderBy('modificado')->where([['idservicio_categoria', '=', 2], ['estado', '=', 1]])->get();
        $collection = collect($links);
        $linksArray = $collection;
        $linksArray->toArray();
        $normativities = Normativity::orderBy('fecha', 'desc')->where('estado', 1)->take(3)->get(['id', 'nombre', 'imagen', 'fecha', 'archivo']);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::orderBy('modificado', 'desc')->where('estado', 1)->where('idarticulo_categoria', $section->id)->get();
        });
        $gestions = Article::orderBy('modificado', 'desc')->where('estado', 1)->where('idarticulo_categoria', 9)->take(3)->get(['id', 'titulo', 'imagen', 'modificado', 'resumen']);
        $popUp = Advertising::orderBy('fecha', 'desc')->where([['estado', '=', 1], ['idpublicidad_categoria', '=', 1]])->take(3)->get();
        $partners = Partner::get();
        $slider = Article::orderBy('order')->where([['estado', '=', 1], ['idarticulo_categoria', '=', 11]])->get();
        $companyData = getCompanyData();
        return view('frontend.home')->with([
            'companyData' => $companyData, 'sections' => $sections, 'partners' => $partners, 'sliders' => $slider, 'articles' => $articles, 'gestions' => $gestions, 'announcements' => $announcements, 'normativities' => $normativities, 'linksArray' => $linksArray, 'popUps' => $popUp, 'directLinks' => $directLinks
        ]);
    }

    public function advertisingDetail($id)
    {
        $advertisingDetail = Advertising::where('id', $id)->first();
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $treeDetail = DocumentTree::where('parent_id', $advertisingDetail->tree_id)->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.advertising_detail')->with(compact('advertisingDetail', 'companyData', 'sections', 'treeDetail'));
    }

    public function indexDocuments()
    {
        $documents = Documents::where('category_id', 1)->latest()->paginate(4);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.documents')->with(compact('documents', 'companyData', 'sections'));
    }

    public function indexContact()
    {
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.contact')->with(compact('companyData', 'sections'));
    }

    public function indexArticles()
    {
        $articles = Article::where('idarticulo_categoria', 5)->orderBy('modificado', 'desc')->paginate(4);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.noticias')->with(compact('companyData', 'articles', 'sections'));
    }

    public function indexNormativity(Request $request)
    {
        // $reasigns = Reassign::orderBy('fecha')->title($request->search)->category($request->categoryId)->paginate(4);
        if (!empty($request->categoryId)) {
            $normativities = Normativity::orderBy('fecha')->category($request->categoryId)->paginate(4);
            $normativities->appends(['categoryId' => $request->categoryId]);
        } else if (!empty($request->search)) {
            $normativities = Normativity::orderBy('fecha')->title($request->search)->paginate(4);
            $normativities->appends(['search' => $request->search]);
        } else {
            $normativities = Normativity::orderBy('fecha')->paginate(4);
        }
        $categories = DB::table('dx_disposicion_categoria')->get(['id', 'titulo']);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.normatividad')->with(compact('normativities', 'companyData', 'sections', 'categories'));
    }

    public function indexReassign(Request $request)
    {
        if (!empty($request->categoryId)) {
            $reasigns = Reassign::orderBy('fecha')->category($request->categoryId)->paginate(4);
            $reasigns->appends(['categoryId' => $request->categoryId]);
        } else if (!empty($request->search)) {
            $reasigns = Reassign::orderBy('fecha')->title($request->search)->paginate(4);
            $reasigns->appends(['search' => $request->search]);
        } else {
            $reasigns = Reassign::orderBy('fecha')->paginate(4);
        }
        $categories = DB::table('dx_reasi_categoria')->get(['id', 'titulo']);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.reasignacion')->with(compact('reasigns', 'companyData', 'sections', 'categories'));
    }

    public function indexCharges(Request $request)
    {
        if (!empty($request->categoryId)) {
            $charges = Charge::orderBy('fecha')->category($request->categoryId)->paginate(4);
            $charges->appends(['categoryId' => $request->categoryId]);
        } else if (!empty($request->search)) {
            $charges = Charge::orderBy('fecha')->title($request->search)->paginate(4);
            $charges->appends(['search' => $request->search]);
        } else {
            $charges = Charge::orderBy('fecha')->paginate(4);
        }
        $categories = DB::table('dx_encargatura_categoria')->get(['id', 'titulo']);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.encargaturas')->with(compact('charges', 'companyData', 'sections', 'categories'));
    }

    public function indexControl(Request $request)
    {
        if (!empty($request->categoryId)) {
            $controls = Control::orderBy('modificado')->category($request->categoryId)->paginate(4);
        } else if (!empty($request->search)) {
            $controls = Control::orderBy('modificado')->title($request->search)->paginate(4);
        } else {
            $controls =  Control::orderBy('modificado')->paginate(4);
        }
        $categories = DB::table('dx_control_categoria')->where('estado', 1)->get(['id', 'titulo']);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.internal_control')->with(compact('controls', 'companyData', 'sections', 'categories'));
    }

    public function indexAnnouncements(Request $request)
    {
        $announcements = Announcements::all();
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $files = $this->mediaCollection;
        $companyData = getCompanyData();
        return view('frontend.announcements')->with(compact('announcements', 'companyData', 'sections', 'files'));
    }

    public function indexContract(Request $request)
    {
        if (!empty($request->categoryId)) {
            $contracts = Contract::orderBy('fecha')->category($request->categoryId)->paginate(4);
            $contracts->appends(['categoryId' => $request->categoryId]);
        } else if (!empty($request->search)) {
            $contracts = Contract::orderBy('fecha')->title($request->search)->paginate(4);
            $contracts->appends(['search' => $request->search]);
        } else {
            $contracts = Contract::orderBy('fecha')->paginate(4);
        }
        $categories = DB::table('dx_contrato_categoria')->get(['id', 'titulo']);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.contratos')->with(compact('contracts', 'categories', 'companyData', 'sections'));
    }


    public function announcementDetail($id)
    {
        $announcementDetail = Announcements::find($id);
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $files = $this->mediaCollection;
        $companyData = getCompanyData();
        return view('frontend.announcement_detail')->with(compact('announcementDetail', 'companyData', 'sections', 'files'));
    }

    public function articleDetail($id)
    {
        $articleDetail = Article::find($id);
        $treeDetail = DocumentTree::where('parent_id', $articleDetail->tree_id)->get();
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.article_detail')->with(compact('articleDetail', 'companyData', 'sections', 'treeDetail'));
    }

    public function linkDetail($id)
    {
        $linkDetail = InterestLink::find($id);
        $treeDetail = DocumentTree::where('parent_id', $linkDetail->tree_id)->get();
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.link_detail')->with(compact('linkDetail', 'companyData', 'sections', 'treeDetail'));
    }

    public function controlDetail($id)
    {
        $controlDetail = Control::find($id);
        $controlDetail = DocumentTree::where('parent_id', $controlDetail->tree_id)->get();
        $sections = DB::table('dx_articulo_categoria')->select('id', 'titulo')->where([['id', '<>', 5], ['id', '<>', 9], ['id', '<>', 11], ['estado', '=', 1]])->get();
        $sections->each(function ($section) {
            $section->articles =  Article::select('id', 'titulo')->where('idarticulo_categoria', $section->id)->get();
        });
        $companyData = getCompanyData();
        return view('frontend.control_detail')->with(compact('controlDetail', 'companyData', 'sections', 'treeDetail'));

    }

}
