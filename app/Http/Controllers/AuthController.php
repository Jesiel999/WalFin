<?php

namespace App\Http\Controllers;

use App\Models\EditUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Movimento;
use App\Models\Parcela;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\EditAuthRequest;

class AuthController extends Controller
{
    /* VERIFICA SE JÁ TEM SESSION */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }


    /* LOGIN DE ACESSO */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'cpf_pj'   => ['required'],
            'senha' => ['required'],
        ]);

        if (Auth::attempt([
            'usua_cpfpj' => $credentials['cpf_pj'], 
            'password'   => $credentials['senha'],
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'CPF ou senha inválidos.',
        ]);
    }

    /* LOGOUT */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('login');
    }
    
    /* CADASTRO DE NOVO USUÁRIO */
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

    /* RETORNA DADOS DO USUÁRIO PARA ALTERAR SENHA */
    public function editSenha()
    {
        $usuario = Auth::user();

        return view('usuarios.alterarSenha', compact('usuario'));
    }

    /* ALTERAR SENHA */
    public function updateSenha(Request $request)
    {

        $usuario = Auth::user();

        $request->validate([
            'senha_atual' => 'required',
            'nova_senha'  => 'required|min:6|confirmed', 
        ]);


        if (!Hash::check($request->senha_atual, $usuario->usua_senha)) {
            return back()->withErrors(['senha_atual' => 'A senha atual está incorreta.']);
        }

        $usuario->usua_senha = Hash::make($request->nova_senha);
        $usuario->save();

        return redirect()->route('dashboard')->with('success', 'Senha alterada com sucesso!');
    }

    /* ALTERAR USUÁRIO */
    public function editUser(EditAuthRequest $request)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->back()->with('error', 'Usuário não identificado.');
        }

        $usuario = EditUsuario::findOrFail($userId);

        $cpfCnpj   = preg_replace('/\D/', '', $request->usua_cpfpj);
        $telefone  = preg_replace('/\D/', '', $request->usua_telefone);

        $updated = $usuario->update([
            'usua_nome'     => $request->usua_nome,
            'usua_cpfpj'    => $cpfCnpj,
            'usua_telefone' => $telefone,
            'usua_email'    => $request->usua_email,
        ]);

        if (!$updated) {
            return redirect()->back()->with('info', 'Nenhuma alteração foi detectada.');
        }

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    /* PERMISSÕES */
    public function usuario()
    {
        $userId = Auth::id();
        $userName = Auth::user()->usua_nome;

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



