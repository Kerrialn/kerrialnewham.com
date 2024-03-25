import './bootstrap.js';
import 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js';
import 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css';
import './styles/app.css';
import hljs from 'highlight.js';

document.addEventListener('turbo:load', () => {
    hljs.highlightAll();
})



