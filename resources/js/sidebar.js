document.getElementById("menu-btn").addEventListener("click", () => {
  const sidebar = document.getElementById("sidebar");
  const texts = document.querySelectorAll('.nav-text');
  const icon = document.querySelector('.expand-icon i'); 

  texts.forEach(text => text.classList.toggle('hidden'));

    if (icon.classList.contains('fa-chevron-left')) {
      icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
    } else {
      icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
    }

  sidebar.classList.remove("-translate-x-full"); 
});
window.toggleSidebarMobile = function () {
  const sidebar = document.getElementById("sidebar");
  const texts = document.querySelectorAll('.nav-text');
  const icon = document.querySelector('.expand-icon i'); 

  texts.forEach(text => text.classList.toggle('hidden'));

    if (icon.classList.contains('fa-chevron-left')) {
      icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
    } else {
      icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
    }

  
  sidebar.classList.add("-translate-x-full");
};

document.addEventListener('DOMContentLoaded', function () {
  window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const texts = sidebar.querySelectorAll('.nav-text');
    const icon = sidebar.querySelector('.expand-icon i');

    sidebar.classList.toggle('w-16');
    sidebar.classList.toggle('lg:w-64');

    if (mainContent) {
      mainContent.classList.toggle('ml-16');
      mainContent.classList.toggle('lg:ml-64');
    }

    texts.forEach(text => text.classList.toggle('hidden'));

    if (icon.classList.contains('fa-chevron-left')) {
      icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
    } else {
      icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
    }
  };
});

document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {

        document.querySelectorAll('.nav-item').forEach(nav => {
            nav.classList.add('active');
        });

        this.classList.remove('active');

        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.remove('hidden');
        });

        const target = this.getAttribute('data-target');
        document.getElementById(target).classList.add('hidden');

        const headerTitle = document.querySelector('.content header h1');
        switch(target) {
            case 'dashboard':
                headerTitle.textContent = 'Dashboard';
                break;
            case 'transactions':
                headerTitle.textContent = 'Extrato Geral';
                break;
            case 'categories':
                headerTitle.textContent = 'Categorias';
                break;
            case 'condicao-pagamento':
                headerTitle.textContent = 'Condições de Pagamento';
                break;
        }
    });
});