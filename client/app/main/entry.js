import './index.html';
import './style.scss';

let blocks = document.querySelectorAll('.js-button-block');
let textarea = document.querySelector('.js-textarea');

function closed() {
  blocks[1].classList.add('is-closed');
  blocks[0].classList.remove('is-closed');
  textarea.classList.remove('is-open');
}

document.querySelector('.js-button-open-send').addEventListener('click', function() {
  blocks[0].classList.add('is-closed');
  blocks[1].classList.remove('is-closed');
  textarea.classList.add('is-open');
});

document.querySelector('.js-button-closed-send').addEventListener('click', closed, false);

document.querySelector('.js-send').addEventListener('click', () => {
  closed();
});