import './search-form.scss';
import register from 'ShopUi/app/registry';
export default register(
    'search-form',
    () => import(/* webpackMode: "lazy" */'./search-form'),
);


