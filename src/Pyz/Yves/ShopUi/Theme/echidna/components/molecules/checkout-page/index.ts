import './checkout-page.scss';

// Import the 'register' function from the Shop Application
import register from 'ShopUi/app/registry';

// Register the component
export default register(
    'checkout-page',
    () => import('./checkout-page')
);