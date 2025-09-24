<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Grupo</th>
            <th>Nome</th>
            <th>CPF/CNPJ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->usua_codigo }}</td>
                <td>{{ $usuario->usua_grupo }}</td>
                <td>{{ $usuario->usua_nome }}</td>
                <td>{{ $usuario->usua_cpfpj }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
