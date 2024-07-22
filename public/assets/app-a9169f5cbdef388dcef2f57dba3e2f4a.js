import './bootstrap.js';
import './styles/app.css';
import hljs from 'highlight.js';

import 'htmx.org';
import Morph from "./Model/Morph";
document.addEventListener('turbo:load', () => {
    hljs.highlightAll();
})

new Morph(document.querySelector('svg.scene'))



