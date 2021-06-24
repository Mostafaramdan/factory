import returnedOrders from '@/pages/returnedOrders/index';
import create from '@/pages/returnedOrders/create';
import update from '@/pages/returnedOrders/update';
import show from '@/pages/returnedOrders/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/returnedOrders`,
        name: `returnedOrders`,
        component: returnedOrders,
    },
    {
        path: `${baseDash}/returnedOrders/create`,
        name: `returnedOrdersCreate`,
        component: create,
    },
    {
        path: `${baseDash}/returnedOrders/update/:id`,
        name: `returnedOrdersUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/returnedOrders/:id`,
        name: `returnedOrdersShow`,
        component: show,
    }
];
