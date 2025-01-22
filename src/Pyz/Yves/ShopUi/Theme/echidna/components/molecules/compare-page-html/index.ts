import './compare-page-html.scss';

import register from 'ShopUi/app/registry';

export default register(
    'compare-page-html', () => import(
        /* webpackMode: "lazy" */
        /* webpackChunkName: "compare-page-html" */
        './compare-page-html'
    )
)