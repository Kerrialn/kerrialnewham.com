import './bootstrap.js';
import './styles/app.css';
import hljs from 'highlight.js';

import 'htmx.org';
document.addEventListener('turbo:load', () => {
    hljs.highlightAll();
})




