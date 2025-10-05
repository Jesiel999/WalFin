<div class="p-4 flex items-center justify-between border-b border-indigo-600 text-3xl lg:text-sm">
    <div class="flex items-center">
        <i id="wallet" class="fas fa-wallet text-2xl mr-3 text-3xl lg:text-sm" style="display=none"></i>
        <span class="nav-text logo-text text-xl font-bold hidden">WallFin</span>
    </div>
    <button onclick="toggleSidebar()" class="expand-icon text-white focus:outline-none hidden lg:block">
        <i class="fas fa-chevron-left"></i>
    </button>

    <button onclick="toggleSidebarMobile()" class="lg:hidden text-white p-2">
        <i class="fas fa-times"></i>
    </button>
</div>
<nav class="flex-1 overflow-y-auto py-4 text-3xl lg:text-sm">
    <ul>
        <li class="mb-1">
            <a href="{{'dashboard'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item active" >
                <i class="fas fa-chart-pie mr-3"></i>
                <span class="nav-text hidden text-base">Dashboard</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{'investimento'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item active" >
                <i class="fas fa-chart-line mr-3"></i>
                <span class="nav-text hidden text-base">Investimentos</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{'extrato'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item" >
                <i class="fas fa-exchange-alt mr-3"></i>
                <span class="nav-text hidden text-base">Extrato Geral</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{'pessoa'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item">  
                <i class="fas fa-users mr-3"></i>
                <span class="nav-text hidden text-base">Pessoa</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{'categorias'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item">
                <i class="fas fa-tags mr-3"></i>
                <span class="nav-text hidden text-base">Categorias</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{'condicoesPagamento'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item">
                <i class="fas fa-id-card mr-3"></i>
                <span class="nav-text hidden text-base">Condição de Pagamento</span>
            </a>
        </li>
        <li class="mb-1">
            <a href="{{'usuario'}}" class="flex items-center px-4 py-3 text-white hover:bg-indigo-600 transition nav-item">
                <i class="fas fa-user mr-3"></i>
                <span class="nav-text hidden text-base">Usuario</span>
            </a>
        </li>
    </ul>
</nav>
<div class="p-4 border-t border-indigo-600 flex items-end">
    <div class="flex items-center">
        <img src="https://ui-avatars.com/api/?name=Usuário&background=random" alt="User" class="w-12 h-12 lg:w-8 lg:h-8 rounded-full mr-2">
        <div class="nav-text hidden">
            <p class="text-sm font-medium text-base">{{ Auth::user()->usua_nome }}</p>
        </div>
    </div>
</div>