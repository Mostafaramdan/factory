import clients from '@/pages/clients/index';
import create from '@/pages/clients/create';
import update from '@/pages/clients/update';
import show from '@/pages/clients/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/clients`,
        name: `clients`,
        component: clients,
    },
    {
        path: `${baseDash}/clients/create`,
        name: `clientsCreate`,
        component: create,
    },
    {
        path: `${baseDash}/clients/update/:id`,
        name: `clientsUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/clients/:id`,
        name: `clientsShow`,
        component: show,
    }
];
