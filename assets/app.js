import './bootstrap.js';
import './vendor/bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';
import hljs from 'highlight.js';

document.addEventListener('turbo:load', () => {
    hljs.highlightAll();
})



