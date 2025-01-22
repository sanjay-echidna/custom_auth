import './echidna-form.scss';

// Import the 'register' function from the Shop Application
import register from 'ShopUi/app/registry';

// Register the component
export default register(
    'echidna-form',
    () => import('./echidna-form')
);