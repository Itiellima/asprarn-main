<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $posts = Post::with('user')->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {

        $user = Auth::user();

        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $post = new Post();

        return view('posts.create', compact('post'));
    }

    public function show($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $post = Post::findOrFail($id);

        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {

        $user = Auth::user();

        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $arquivos = $request->file('arquivos'); // Deve ser um array de arquivos

        $request->validate([
            'titulo' => 'required',
            'assunto' => 'required',
            'texto' => 'required',
            'data' => 'required',

        ]);

        DB::beginTransaction();
        try {
            $post = Post::create([
                'user_id' => $user->id,
                'titulo' => $request->titulo,
                'assunto' => $request->assunto,
                'texto' => $request->texto,
                'data' => $request->data,
                'owner' => $user->name,
            ]);


            foreach ($arquivos as $arquivo) {
                $path = $arquivo->store('img', 'public');

                $post->files()->create([
                    'path' => $path,
                    'tipo_documento' => 'imagem',
                    'status' => 'ativo',
                    'observacao' => 'Upload automatico'
                ]);
            }

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('posts.index')->with('error', 'Erro ao criar, tente novamente!');
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $post = Post::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:225',
            'assunto' => 'required|string|max:500',
            'img' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'texto' => 'required|string|max:5000',
            'data' => 'required|date',
        ]);


        DB::beginTransaction();
        try {

            $post->update([
                'titulo' => $request->titulo,
                'assunto' => $request->assunto,
                'texto' => $request->texto,
                'data' => $request->data,
            ]);

            $arquivos = $request->file('arquivos');
            
            // Exclui arquivos se existirem outros
            if($arquivos){
                foreach ($post->files as $file) {
                    if (Storage::disk('public')->exists($file->path)) {
                        Storage::disk('public')->delete($file->path);
                    }
                }
    
                // Agora exclui os registros da relação polimórfica
                $post->files()->delete();
            }

            
            if ($arquivos) {

                foreach ($arquivos as $arquivo) {
                    $path = $arquivo->store('img', 'public');

                    $post->files()->create([
                        'path' => $path,
                        'tipo_documento' => 'imagem',
                        'status' => 'ativo',
                        'observacao' => 'Upload automatico'
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('posts.index')->with('success', 'Publicação atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('posts.index')->with('error', 'Erro ao atualizar tente novamente!');
        }
    }



    public function destroy($id)
    {

        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Publicação excluida com sucesso!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasAnyRole(['admin', 'moderador'])) {
            return redirect()->back()->with('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        $post = Post::findOrFail($id);

        return view('posts.create', compact('post'));
    }
}
