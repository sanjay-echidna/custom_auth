import ProductDetailColorSelector from 'ProductGroupWidget/components/molecules/product-detail-color-selector/product-detail-color-selector';
import Component from "ShopUi/models/component"
import ProductDetailColorSelectorCore from 'ProductGroupWidget/components/molecules/product-detail-color-selector/product-detail-color-selector';
import $ from 'jquery/dist/jquery';
import jQuery from 'jquery/dist/jquery';

export default class ProductDetailsAjaxOptions extends Component {

    protected readyCallback(): void {

    }

    protected init(): void {
        super.init();

        alert("Working fine for");


        // // Add click event to each option element
        // const triggerElements = Array.from(document.querySelectorAll('.js-product-detail-color-selector__item'));
        // triggerElements.forEach(element => {
        //     element.addEventListener('click', this.onTriggerClick.bind(this));
        // });

    }

    // protected onTriggerClick(event: Event): void {
    //     event.preventDefault(); // Prevent the default link behavior

    //     const url = (<HTMLElement>event.currentTarget).getAttribute('href');

    //     this.loadContent(url);
    //     this.updateUrl(url);
    // }

    // protected loadContent(url: string): void {
    //     fetch(url)
    //         .then(response => response.text())
    //         .then(data => {
    //             document.open(); // Open a new document
    //             document.write(data); // Write the new content
    //             document.close(); // Close the document to finish loading the new content

    //             this.attachEventListeners(); // Reattach event listeners after content is loaded

    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //         });
    // }
    // protected attachEventListeners(): void {
    //     const triggerElements = Array.from(document.querySelectorAll('.js-product-detail-color-selector__item'));
    //     triggerElements.forEach(element => {
    //         element.addEventListener('click', this.onTriggerClick.bind(this));
    //     });
    // }

    // protected updateUrl(url: string): void {
    //     window.history.pushState(null, '', url);
    // }

    // protected onOptionContextMenu(event: Event): void {
    //     event.preventDefault(); // Prevent the right-click menu
    // }
}
