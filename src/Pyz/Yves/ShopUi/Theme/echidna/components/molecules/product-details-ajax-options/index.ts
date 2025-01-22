import register from 'ShopUi/app/registry';
import './product-details-ajax-options';
export default register(
    'product-details-ajax-options',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "product-details-ajax-options" */
            './product-details-ajax-options'
        ),
);
