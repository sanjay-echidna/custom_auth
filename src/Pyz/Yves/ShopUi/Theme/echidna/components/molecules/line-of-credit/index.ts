import register from 'ShopUi/app/registry';
import './line-of-credit.scss';
import './line-of-credit';

export default register(
    'line-of-credit', () => import(
        /* webpackMode: "lazy" */
        /* webpackChunkName: "line-of-credit" */
        './line-of-credit'
        )
)
