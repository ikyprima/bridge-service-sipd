<?php

namespace Modules\InfoSp2d\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\InfoSp2d\Entities\MInfoSp2d;
use Inertia\Inertia;
class InfoSp2dPublicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            # code...
            $MInfoSp2d = MInfoSp2d::where('noSp2d', 'like', '%' . $request->search . '%')
            ->orWhere('keteranganSp2d', 'like', '%' . $request->search . '%')
            ->orWhere('namaSkpd', 'like', '%' . $request->search . '%')
            ->orderBy('tanggalSp2d', 'desc')->paginate(10);
            $pagination = $MInfoSp2d->appends ( array (
                'search' => $request->search
            ) );
            
        }else{
            $MInfoSp2d = MInfoSp2d::where('noSp2d', 'like', '%' . $request->search . '%')
            ->orWhere('keteranganSp2d', 'like', '%' . $request->search . '%')
            ->orWhere('namaSkpd', 'like', '%' . $request->search . '%')
            ->orderBy('tanggalSp2d', 'desc')->paginate(10);
        
        }
    
        return Inertia::render('InfoSp2d/InfoSp2dPublic',[
            'data'=>$MInfoSp2d
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('infosp2d::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('infosp2d::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('infosp2d::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
