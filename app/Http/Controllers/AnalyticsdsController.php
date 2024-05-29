<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AnalyticsdsController extends Controller
{
    public function index()
    {
        $url = 'https://back-staging.bosraka.com/content/dtmttag/gtdt';
        $response = Http::withTokenHeader()->get($url);
        $crot = json_decode($response);
        $data = $crot->data;
        return view('analyticsds.index', [
            'title' => 'Analytics',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function editMetaTag(Request $request)
    {
        $raw = $request->validate([
            'metatag' => 'required',
            'article' => 'required',
            'script_livechat' => 'required',
        ]);
        $validatedData = [
            'mttag' => $raw['metatag'],
            'artcl' => $raw['article'],
            'scrptlvc' => $raw['script_livechat'],
        ];
        
        $url = 'https://back-staging.bosraka.com/content/dtmttag/1';
        $response = Http::withTokenHeader()->post($url, $validatedData);
        if ($response->successful()){
            return redirect('/analyticsds')->with('success', 'Data Berhasil di Edit!');
        } else {
            return redirect('/analyticsds')->with('error', 'Data Gagal di Edit!');
        }

    }

    public function apiSitemap()
    {
        $url = 'https://back-staging.bosraka.com/content/stmp';
        $response = Http::withTokenHeader()->get($url);
        $crot = json_decode($response);
        $data = $crot->data;
        return $data;
    }
    public function sitemap()
    {
        $data = $this->apiSitemap();
        usort($data, function ($a, $b) {
            return $a->idstmp <=> $b->idstmp;
        });
        return view('analyticsds.sitemap', [
            'title' => 'Analytics',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }
    public function createSitemap()
    {
        return view('analyticsds.createsitemap');
    }
    public function storeSitemap(Request $request)
    {
        $validatedData = $request->validate([
            'urpage' => 'required'
        ]);
        $url = 'https://back-staging.bosraka.com/content/stmp';
        $response = Http::withTokenHeader()->post($url, $validatedData);
        if ($response->successful()){
            return redirect('/analyticsds/sitemap')->with('success', 'Data Berhasil di Tambah!');
        } else {
            return redirect('/analyticsds/sitemap')->with('error', 'Data Gagal di Tambah!');
        }
    }
    public function updateSitemap(Request $request , $urpage)
    {
        $url = 'https://back-staging.bosraka.com/content/stmp/'.$urpage;
        $waktuUpdate = Carbon::now()->format('Y-m-d');
        if($request->urpage == $urpage && $request->lastmod == $waktuUpdate){
            return redirect('analyticsds/sitemap/')->with('warning','Data ' .$urpage. ' tidak berubah');
        } elseif ($request->urpage == $urpage && $request->lastmod != $waktuUpdate) {
            $urpageSementara = '1asdaf856as1d';
            if ($urpage === '1asdaf856as1d'){
                $urpageSementara = '1fg45ds6g14sad';
            }
            $mauDiubah = [
                'urpage' => $urpageSementara,
                'updated_at' => $waktuUpdate
            ];
            $validatedData = [
                'urpage' => $urpage,
                'updated_at' => $waktuUpdate
            ];
            $urlbalik = 'https://back-staging.bosraka.com/content/stmp/'.$urpageSementara;
            $responsesementara = Http::withTokenHeader()->post($url, $mauDiubah);
            $response = Http::withTokenHeader()->post($urlbalik, $validatedData);
            if($response && $responsesementara->successful()){
                return redirect('analyticsds/sitemap/')->with('success','Berhasil Ubah Tanggal ');
            }
        }
        $validatedData = $request->validate([
            'urpage' => 'required'
        ]);
        $validatedData = [
            'urpage' => $validatedData['urpage'],
            'updated_at' => $waktuUpdate
        ];
        $response = Http::withTokenHeader()->post($url, $validatedData);
      
        if($response->successful()){
            return redirect('analyticsds/sitemap/')->with('success','Berhasil Edit Page ');
        } else {
            return redirect('analyticsds/sitemap/')->with('error','Gagal Edit Page ' );
        }
    }
    public function deleteSitemap($urpage)
    {
        $url = 'https://back-staging.bosraka.com/content/stmp';
        $raw = $this->apiSitemap();
        $data = null;
        foreach ($raw as $item) {
            if ($item->urpage === $urpage) {
                $data = $item;
                break;
            }
        }
        $response = Http::withTokenHeader()->delete($url, $data);
        if($response->successful()){
            return redirect('analyticsds/sitemap/')->with('success','Berhasil Hapus Data '.$urpage);
        } else {
            return redirect('analyticsds/sitemap/')->with('error','Gagal Hapus Data ' .$urpage);
        }
    }
    
}
