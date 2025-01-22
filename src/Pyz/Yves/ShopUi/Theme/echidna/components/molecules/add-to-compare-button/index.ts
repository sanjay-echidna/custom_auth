import './add-to-compare-button.scss';
import register from 'ShopUi/app/registry';
import './add-to-compare-button';

export default register(
    'add-to-compare-button',
    () =>
        import(
            /* webpackMode: "lazy" */
            /* webpackChunkName: "add-to-compare-button" */
            './add-to-compare-button'
        ),
);

