const form = document.getElementById('entrada').querySelector('form');
const email = document.getElementById('email');
const senha = document.getElementById('senha');


const botaoLogin = document.getElementById('login_botao');
botaoLogin.addEventListener('click', function(event) {
  event.preventDefault();
  
  if (!validarEmail(email.value)) {
    alert('Por favor, insira um endereço de email válido.');
    return;
  }
  
  if (senha.value === '') {
    alert('Por favor, insira sua senha.');
    return;
  }
  
  form.submit();
});

function validarEmail(email) {
  const expressaoRegular = /\S+@\S+\.\S+/;
  return expressaoRegular.test(email);
}


