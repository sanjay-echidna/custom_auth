import Component from 'ShopUi/models/component';
import 'jquery';
import $ from 'jquery/dist/jquery';

export default class NewComponentCounter extends Component {
    protected counter: HTMLElement;
    protected elements: HTMLElement[];

    protected readyCallback(): void {
        this.counter = <HTMLElement>document.querySelector(`.${this.jsName}__counter`);
        this.elements = <HTMLElement[]>Array.from(document.querySelectorAll(this.elementSelector));
        this.count();
    }

    count(): void {
        this.counter.innerText = `${this.elements.length}`;
    }

    get elementSelector(): string {
        return this.getAttribute('element-selector');
    }
}

