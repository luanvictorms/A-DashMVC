const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme_toggler");

const buttonAtendimento = document.querySelector("#modal-button-atendimento");
const modalAtendimento = document.querySelector("#modal-atendimento");

const buttonCliente = document.querySelector("#modal-button-cliente");
const modalCliente = document.querySelector("#modal-cliente");

const buttonProduto = document.querySelector("#modal-button-produto");
const modalProduto = document.querySelector("#modal-produto");

const buttonNovoServico = document.querySelector("#modal-button-novo-servico");
const modalNovoServico = document.querySelector("#modal-novo-servico");

const buttonProdutoVenda = document.querySelector("#modal-button-produto-venda");
const modalProdutoVenda = document.querySelector("#modal-produto-venda");

const buttonCusto = document.querySelector("#modal-button-custo");
const modalCusto = document.querySelector("#modal-custo");

const buttonVale = document.querySelector("#modal-button-vale");
const modalVale = document.querySelector("#modal-vale");


//Modais
buttonAtendimento.onclick = function() {
    modalAtendimento.showModal()
}

buttonCliente.onclick = function() {
    modalCliente.showModal()
}

buttonProduto.onclick = function() {
    modalProduto.showModal()
}

buttonProdutoVenda.onclick = function() {
    modalProdutoVenda.showModal()
}

buttonNovoServico.onclick = function() {
    modalNovoServico.showModal()
}

buttonCusto.onclick = function() {
    modalCusto.showModal()
}

buttonVale.onclick = function() {
    modalVale.showModal()
}




//Show Sidebar
menuBtn.addEventListener("click", () => {
    sideMenu.style.display = "block";
})

//Close Sidebar
closeBtn.addEventListener("click", () => {
    sideMenu.style.display = "none";
})

//Change Theme
themeToggler.addEventListener("click", () => {
    document.body.classList.toggle('dark-theme-variables');

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
})
