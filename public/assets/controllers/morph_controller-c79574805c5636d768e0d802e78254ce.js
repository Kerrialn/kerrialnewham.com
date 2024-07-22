import { Controller } from '@hotwired/stimulus';
import Morph from "../Model/Morph";

export default class extends Controller {

    static target = ['svg']
    connect() {
        new Morph(document.querySelector('svg.scene'))
    }
}



{

    new Morph(document.querySelector('svg.scene'));
};
