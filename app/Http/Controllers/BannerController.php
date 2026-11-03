<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    //

    public function create()
    {
        $banner = new Banner();

        $AllBanners = Banner::all();

        return view('banner.create', compact('banner', 'AllBanners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'arquivos' => 'required|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $arquivos = $request->file('arquivos');
        DB::beginTransaction();
        try {
            $banner = Banner::create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
            ]);

            $path = $arquivos->store('img', 'midia');
            $banner->files()->create([
                'path' => $path,
                'tipo_documento' => 'imagem',
                'status' => 'ativo',
                'observacao' => 'Upload automatico'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Banner criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar banner!');
        }
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('banner.create')->with('success', 'Banner deletado com sucesso!');

    }
}
