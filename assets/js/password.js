const show_pw_btn = document.querySelector('#show-passwd');
const show_pw_icon = show_pw_btn.querySelector('img');
const pw_input = document.querySelector('#password');

show_pw_btn.addEventListener('click', () => {
  pw_input.type = pw_input.type === 'password' ? 'text' : 'password';

  if (pw_input.type === 'text') {
    show_pw_icon.src = 'hide.png';
  } else {
    show_pw_icon.src = 'view.png';
  }
});

