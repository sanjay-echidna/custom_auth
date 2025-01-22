import './camera-modal.scss';
import register from 'ShopUi/app/registry';
export default register(
    'camera-modal',
    () =>
        import(
            /* webpackMode: "lazy" */
            './camera-modal'
            ),
);
