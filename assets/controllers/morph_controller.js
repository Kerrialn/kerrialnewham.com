import anime from 'animejs';
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        new Morph(document.querySelector('svg.scene'))
    }
}

class Morph {
    constructor(el) {
        this.DOM = {};
        this.DOM.el = el;
        this.DOM.paths = Array.from(this.DOM.el.querySelectorAll('path'));
        this.animate();
    }

    animate() {
        this.DOM.paths.forEach((path) => {
            setTimeout(() => {
                anime({
                    targets: path,
                    duration: anime.random(5000,10000),
                    easing: 'cubicBezier(0.5, 0, 0.5, 1)',
                    d: path.getAttribute('pathdata:id'),
                    loop: true,
                    direction: 'alternate'
                });
            }, anime.random(0,10000));
        });
    }
}