<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Movimento;
use App\Models\Parcela;
use App\Models\Pessoa;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if ($request->session()->has('usuario')) {
            return redirect()->route('dashboard');
        }

        if ($request->cookie('user_id')) {

            return redirect()->route('dashboard');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('cpf_pj', 'senha');

        $user = DB::table('usuario')
            ->where('usua_cpfpj', $credentials['cpf_pj'])
            ->first();

        if ($user && Hash::check($credentials['senha'], $user->usua_senha)) {
           
            Cookie::queue('user_name', $user->usua_nome, 43200);
            Cookie::queue('user_id', $user->usua_codigo, 43200);

            Session::put('usuario', $user);
            return redirect('/dashboard');
        }

        return back()->withErrors(['login' => 'CPF ou senha inválidos.']);
    }

    public function logout(Request $request)
    {
        Cookie::queue(Cookie::forget('user_name'));
        Cookie::queue(Cookie::forget('user_id'));
        Session::forget('usuario');

        return redirect('/login');
    }
    
    public function cadastro(AuthRequest $request)
    {
        $request->validated();

        Usuario::create([
            'usua_grupo'    => 'cliente',
            'usua_nome'     => $request->input('nome'),
            'usua_cpfpj'    => $request->input('cpf_pj'),
            'usua_email'    => $request->input('email'),
            'usua_telefone' => $request->input('telefone'),
            'usua_senha'    => Hash::make($request->input('senha')),
        ]);

        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
    }


    public function editSenha()
    {
        $userId = Cookie::get('user_id');
        $usuario = Usuario::findOrFail($userId);

        return view('usuarios.alterarSenha', compact('usuario'));
    }

    public function updateSenha(Request $request)
    {
        $userId = Cookie::get('user_id');
        $usuario = Usuario::findOrFail($userId);

        $request->validate([
            'senha_atual' => 'required',
            'nova_senha' => 'required|min:6|confirmed', 
        ]);


        if (!Hash::check($request->senha_atual, $usuario->usua_senha)) {
            return back()->withErrors(['senha_atual' => 'A senha atual está incorreta.']);
        }

        $usuario->usua_senha = Hash::make($request->nova_senha);
        $usuario->save();

        return redirect()->route('dashboard')->with('success', 'Senha alterada com sucesso!');
    }

    public function editUser(Request $request)
    {
        $userId = Cookie::get('user_id');
        $usuario = Usuario::findOrFail($userId);

        $cpfCnpj   = preg_replace('/\D/', '', $request->input('usua_cpfpj'));
        $telefone  = preg_replace('/\D/', '', $request->input('usua_telefone'));

        $request->merge([
            'usua_cpfpj'    => $cpfCnpj,
            'usua_telefone' => $telefone,
        ]);

        $request->validate([
            'usua_nome'     => 'required|string|max:255',
            'usua_cpfpj'    => 'required|digits_between:11,14|unique:usuario,usua_cpfpj,' . $usuario->usua_codigo . ',usua_codigo',
            'usua_telefone' => 'required|digits_between:10,11',
            'usua_email'    => 'required|string|email|max:255|unique:usuario,usua_email,' . $usuario->usua_codigo . ',usua_codigo',
        ], [
            'required'       => 'O campo :attribute é obrigatório.',
            'email'          => 'O campo :attribute deve ser um e-mail válido.',
            'unique'         => 'O :attribute já está cadastrado.',
            'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos.',
        ]);

        $usuario->update([
            'usua_nome'     => $request->input('usua_nome'),
            'usua_cpfpj'    => $cpfCnpj,
            'usua_telefone' => $telefone,
            'usua_email'    => $request->input('usua_email'),
        ]);

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }



    /* Permissoes */
    public function usuario()
    {
        $userId = Cookie::get('user_id');
        $userName = Cookie::get('user_name');

        $usuario = Usuario::where('usua_codigo', $userId)->first();

        $userEmail = $usuario ? $usuario->usua_email : null;
        $userFone  = $usuario ? $this->formatTelefone($usuario->usua_telefone) : null;
        $userCpfpj = $usuario ? $this->formatCpfCnpj($usuario->usua_cpfpj) : null;

        $totalReceitasParcelas = Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                ->where('movb_natureza', 'Receita');
            })
            ->whereNotNull('par_databaixa')
            ->sum('par_valor');

        $totalDespesasParcelas = Parcela::whereHas('movimento', function ($q) use ($userId) {
                $q->where('movb_codclie', $userId)
                ->where('movb_natureza', 'Despesa');
            })
            ->whereNotNull('par_databaixa')
            ->sum('par_valor');

        $totalReceitasMov = Movimento::where('movb_codclie', $userId)
            ->where('movb_natureza', 'Receita')
            ->whereNotNull('movb_databaixa')
            ->whereDoesntHave('parcelas')
            ->sum('movb_valorliquido');

        $totalDespesasMov = Movimento::where('movb_codclie', $userId)
            ->where('movb_natureza', 'Despesa')
            ->whereNotNull('movb_databaixa')
            ->whereDoesntHave('parcelas')
            ->sum('movb_valorliquido');

        $totalReceitas = $totalReceitasMov + $totalReceitasParcelas;
        $totalDespesas = $totalDespesasMov + $totalDespesasParcelas;
        $saldoAtual = $totalReceitas - $totalDespesas;

        return view('pages.usuario', compact(
            'userId',
            'userName',
            'userEmail',
            'userFone',
            'userCpfpj',
            'saldoAtual',
            'totalReceitas',
            'totalDespesas',
        ));
    }
    private function formatCpfCnpj($value) {
        $v = preg_replace('/\D/', '', $value); 
        if (strlen($v) === 14) { // CNPJ
            return substr($v,0,2) . '.' . substr($v,2,3) . '.' . substr($v,5,3) . '/' . substr($v,8,4) . '-' . substr($v,12,2);
        } elseif (strlen($v) === 11) { // CPF
            return substr($v,0,3) . '.' . substr($v,3,3) . '.' . substr($v,6,3) . '-' . substr($v,9,2);
        }
        return $value;
    }

    private function formatTelefone($value) {
        $v = preg_replace('/\D/', '', $value);
        if (strlen($v) === 11) {
            return '(' . substr($v,0,2) . ') ' . substr($v,2,5) . '-' . substr($v,7);
        } elseif (strlen($v) === 10) {
            return '(' . substr($v,0,2) . ') ' . substr($v,2,4) . '-' . substr($v,6);
        }
        return $value;
    }
}



