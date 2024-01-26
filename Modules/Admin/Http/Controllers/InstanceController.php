<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Modules\Admin\Entities\Instance;
class InstanceController extends Controller
{

    public function index(Request $request)
    {
        
        $listData = Instance::orderBy('id', 'desc')
        ->paginate(10)->through(function($item){
            return collect([
                'id'=>$item->id,
                'kode_skpd'=>$item->kode_skpd,
                'nama_skpd'=>$item->nama_skpd
            ]);
        });

        $header = [
            [
            'title'=> 'id',
            'field'=> 'id',
            'type'=> 'text',
            'size'=>'auto',
            'align'=> 'left'
            ],
            [
                'title'=> 'Kode SKPD',
                'field'=> 'kode_skpd',
                'type'=> 'Text',
                'size'=>'auto',
                'align'=> 'left'
            ],
            [
                'title'=> 'Nama SKPD',
                'field'=> 'nama_skpd',
                'type'=> 'Text',
                'size'=>'auto',
                'align'=> 'left'
            ],
            [
                'title' => 'Aksi',
                'field' => null,
                'type' => 'button-group',
                'data' => [
                    [
                        'text'=> '',
                        'type'=> 'button',
                        'action'=> 'edit',
                        'class'=> 'border border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1] rounded-l-lg',
                        'icon'=> 'fas fa-lg fa-pencil-alt'
                    ],
                    [
                        'text'=> '',
                        'type'=> 'button',
                        'action'=> 'lihatDetail',
                        'class'=> 'border border-blue-500 hover:bg-emerald-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-emerald-500 focus:text-white focus:z-[1]',
                        'icon'=> 'fas fa-lg fa-file-alt'
                    ],
                    [
                        'text'=> '',
                        'type'=> 'button',
                        'action'=> 'hapus',
                        'class'=> 'border  border-blue-500  hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white  focus:z-[1] rounded-r-lg',
                        'icon'=> 'fas fa-lg fa-trash-alt'
                    ]
                ],
                'size'=> 20,
                'align'=> 'center'
            ]
        ];

        return Inertia::render('Admin/Instance',[
            'header' => $header,
            'data' => $listData,
            'titleTable' => 'Data SKPD',
            'slug' => '',
            'dataSearch' => $request->search,
            'buttonTambah' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
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
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
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
